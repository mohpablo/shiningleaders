<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ParentController extends Controller
{
    public function dashboard()
    {
        $parentId = auth()->guard('web')->id();
        $children = Student::where('parent_id', $parentId)
            ->with(['subscriptions.course.teacher', 'subscriptions.payments'])
            ->get();

        $subscriptions = $children->flatMap(fn($child) => $child->subscriptions);
        $payments = $subscriptions->flatMap->payments;

        $count = $children->count();
        $totalSubscriptions = $subscriptions->count();
        $activeSubscriptions = $subscriptions->where('status', 'active')->count();
        $pendingPayments = $payments->where('status', 'pending')->count();
        $successfulPayments = $payments->where('status', 'success')->count();

        return view('parent.index', compact('children', 'count', 'totalSubscriptions', 'activeSubscriptions', 'pendingPayments', 'successfulPayments'));
    }

    public function show(Student $student)
    {
        $this->authorizeStudent($student);

        $student->load(['subscriptions.course', 'subscriptions.payments']);

        return view('parent.student', compact('student'));
    }

    public function courses()
    {
        $courses = Course::with('teacher')->paginate(12);
        $students = Student::where('parent_id', Auth::id())->get();

        return view('parent.courses', compact('courses', 'students'));
    }

    public function payments()
    {
        $payments = payment::whereHas('subscription', fn($query) => $query->where('parent_id', auth()->guard('web')->id()))
            ->with(['subscription.course', 'subscription.student'])
            ->latest()
            ->paginate(12);

        return view('parent.payments', compact('payments'));
    }

    public function settings()
    {
        return view('parent.settings');
    }

    public function subscribe(Request $request, Student $student)
    {
        $this->authorizeStudent($student);

        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
        ]);

        $course = \App\Models\Course::findOrFail($validated['course_id']);

        $subscription = $student->subscriptions()->create([
            'course_id' => $course->id,
            'parent_id' => auth()->guard('web')->id(),
            'status' => 'pending',
            'valid_until' => now()->addMonth(),
            'sessions_used' => 0,
            'sessions_limit' => $course->monthly_sessions ?? 0,
        ]);

        return redirect()->route('parent.student.subscription.checkout', [$student, $subscription]);
    }

    public function checkout(Student $student, \App\Models\subscription $subscription)
    {
        $this->authorizeStudent($student);

        if ($subscription->student_id !== $student->id) {
            abort(403);
        }

        $amountCents = intval($subscription->course->monthly_fee * 100);
        $merchantOrderId = 'ORDER_' . now()->timestamp . '_' . $subscription->id;

        $subscription->payments()->create([
            'amount' => $subscription->course->monthly_fee,
            'status' => 'pending',
            'paymob_order_id' => $merchantOrderId,
        ]);

        $authToken = $this->getPaymobAuthToken();
        $order = $this->createPaymobOrder($authToken, $amountCents, $merchantOrderId, $subscription);
        $paymentToken = $this->getPaymobPaymentToken($authToken, $order['id'], $amountCents, $subscription);

        return view('parent.paymob-checkout', compact('paymentToken', 'subscription', 'student'));
    }

    protected function getPaymobAuthToken()
    {
        $response = $this->paymobClient()->post('https://accept.paymob.com/api/auth/tokens', [
            'api_key' => config('services.paymob.api_key'),
        ]);

        if ($response->failed() || !isset($response['token'])) {
            Log::error('PayMob auth token request failed', ['body' => $response->body()]);
            abort(500, 'فشل التحقق من PayMob. تحقق من إعدادات API.');
        }

        return $response['token'];
    }

    protected function createPaymobOrder(string $authToken, int $amountCents, string $merchantOrderId, \App\Models\subscription $subscription): array
    {
        $response = $this->paymobClient()->withToken($authToken)
            ->post('https://accept.paymob.com/api/ecommerce/orders', [
                'delivery_needed' => false,
                'amount_cents' => $amountCents,
                'currency' => config('services.paymob.currency'),
                'merchant_order_id' => $merchantOrderId,
                'items' => [
                    [
                        'name' => $subscription->course->name,
                        'amount_cents' => $amountCents,
                        'description' => 'دفع اشتراك دورة',
                        'quantity' => 1,
                    ],
                ],
            ]);

        if ($response->failed() || !isset($response['id'])) {
            Log::error('PayMob order creation failed', ['body' => $response->body()]);
            abort(500, 'فشل إنشاء طلب PayMob.');
        }

        return $response->json();
    }

    protected function getPaymobPaymentToken(string $authToken, int $orderId, int $amountCents, \App\Models\subscription $subscription): string
    {
        $user = auth()->guard('web')->user();

        $response = $this->paymobClient()->withToken($authToken)
            ->post('https://accept.paymob.com/api/acceptance/payment_keys', [
                'amount_cents' => $amountCents,
                'expiration' => 3600,
                'order_id' => $orderId,
                'billing_data' => [
                    'first_name' => $user->name,
                    'last_name' => 'Parent',
                    'email' => $user->email,
                    'phone_number' => $user->phone_number ?? '0000000000',
                    'country' => 'AE',
                    'city' => 'Dubai',
                    'state' => 'NA',
                    'street' => 'NA',
                    'building' => 'NA',
                    'floor' => 'NA',
                    'apartment' => 'NA',
                    'postal_code' => '00000',
                    'shipping_method' => 'NA',
                ],
                'currency' => config('services.paymob.currency'),
                'integration_id' => config('services.paymob.integration_id'),
                'redirect_url' => config('services.paymob.redirect_url'),
            ]);

        if ($response->failed() || !isset($response['token'])) {
            Log::error('PayMob payment key request failed', ['body' => $response->body()]);
            abort(500, 'فشل إنشاء مفتاح دفع PayMob.');
        }

        return $response['token'];
    }

    protected function paymobClient()
    {
        $client = Http::acceptJson();

        if ($this->shouldDisablePaymobSslVerification()) {
            $client = $client->withoutVerifying();
        }

        return $client;
    }

    protected function shouldDisablePaymobSslVerification(): bool
    {
        return app()->environment(['local', 'testing']) || config('services.paymob.mode') === 'test';
    }

    protected function authorizeStudent(Student $student)
    {
        if ($student->parent_id !== auth()->guard('web')->id()) {
            abort(403);
        }
    }

    public function create()
    {
        $courses = Course::all();
        return view('parent.add-student', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'age'           => ['required', 'integer', 'min:1', 'max:30'],
            'phone_number'  => ['nullable', 'string', 'max:20'],
            'school'        => ['nullable', 'string', 'max:255'],
            'academic_year' => ['nullable', 'string', 'max:255'],
            'courses'       => ['nullable', 'array'],
            'courses.*'     => ['exists:courses,id'],
        ]);

        $student = Student::create([
            'parent_id'     => auth()->guard('web')->id(),
            'name'          => $validated['name'],
            'age'           => $validated['age'],
            'phone_number'  => $validated['phone_number'],
            'school'        => $validated['school'],
            'academic_year' => $validated['academic_year'],
        ]);

        if (!empty($validated['courses'])) {
            $student->courses()->attach($validated['courses']);
        }

        return redirect()->route('parent.dashboard')->with('success', 'تم إضافة الطالب بنجاح');
    }
}
