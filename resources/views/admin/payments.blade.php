<x-admin title="مدفوعات الطلاب">
    <div class="space-y-8">
        <div class="border-b-4 border-midnight pb-6">
            <h2 class="text-4xl font-heading font-bold">مدفوعات الطلاب</h2>
            <p class="mt-2 text-midnight/70">جميع الطلاب والدورات المسجلين، مع تحديد حالة الدفع الشهرية.</p>
        </div>

        @if(session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 font-bold text-emerald-700">{{ session('success') }}</div>
        @endif

        <form method="GET" action="{{ route('admin.payments.index') }}" class="flex flex-col gap-3 sm:flex-row">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="ابحث باسم الطالب أو ولي الأمر أو الدورة" class="min-w-0 flex-1 border-2 border-midnight bg-white px-4 py-3 text-right text-midnight outline-none focus:bg-sand">
            <select name="payment_status" class="border-2 border-midnight bg-white px-4 py-3 text-right text-midnight outline-none focus:bg-sand">
                <option value="">كل حالات الدفع</option>
                <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>تم الدفع</option>
                <option value="unpaid" {{ request('payment_status') === 'unpaid' ? 'selected' : '' }}>لم يتم الدفع</option>
            </select>
            <button type="submit" class="bg-midnight px-5 py-3 font-bold text-sand transition hover:bg-terracotta">بحث</button>
        </form>

        <div class="overflow-x-auto border-2 border-midnight bg-sand p-4 shadow-[8px_8px_0px_0px_#0B132B]">
            <table class="w-full border-collapse text-right text-sm text-midnight">
                <thead class="bg-midnight text-sand">
                    <tr>
                        <th class="border-2 border-midnight p-4 font-bold">الطالب</th>
                        <th class="border-2 border-midnight p-4 font-bold">ولي الأمر</th>
                        <th class="border-2 border-midnight p-4 font-bold">الدورة</th>
                        <th class="border-2 border-midnight p-4 font-bold">المبلغ</th>
                        <th class="border-2 border-midnight p-4 font-bold">الحالة</th>
                        <th class="border-2 border-midnight p-4 font-bold">الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        @php
                            $studentCourses = $student->courses
                                ->merge($student->subscriptions->map(fn ($subscription) => $subscription->course))
                                ->filter()
                                ->unique('id');
                        @endphp
                        @foreach($studentCourses as $course)
                            @php
                                $subscription = $student->subscriptions->firstWhere('course_id', $course->id);
                                $payment = $subscription?->payments?->sortByDesc('created_at')->first();
                                $isPaid = $payment?->status === 'success';
                            @endphp
                            @if($paymentStatus === '' || ($paymentStatus === 'paid' && $isPaid) || ($paymentStatus === 'unpaid' && ! $isPaid))
                            <tr class="hover:bg-midnight/5 transition-colors">
                                <td class="border-2 border-midnight p-4 font-bold">{{ $student->name }}</td>
                                <td class="border-2 border-midnight p-4">{{ $student->parent?->name ?? 'غير معروف' }}</td>
                                <td class="border-2 border-midnight p-4">{{ $course->name }}</td>
                                <td class="border-2 border-midnight p-4">{{ number_format($course->monthly_fee, 2) }} د.إ</td>
                                <td class="border-2 border-midnight p-4"><span class="font-bold {{ $isPaid ? 'text-emerald-700' : 'text-rose-700' }}">{{ $isPaid ? 'تم الدفع' : 'لم يتم الدفع' }}</span></td>
                                <td class="border-2 border-midnight p-4">
                                    <div class="flex flex-wrap gap-2">
                                        <form action="{{ route('admin.payments.paid', [$student, $course]) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="rounded-full bg-emerald-600 px-4 py-2 text-xs font-bold text-white transition hover:bg-emerald-700">تم الدفع</button>
                                        </form>
                                        <form action="{{ route('admin.payments.unpaid', [$student, $course]) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="rounded-full bg-rose-600 px-4 py-2 text-xs font-bold text-white transition hover:bg-rose-700">لم يتم الدفع</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    @empty
                    <tr>
                        <td colspan="6" class="border-2 border-midnight p-8 text-center font-bold">لا يوجد طلاب مرتبطون بدورات.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4 border-t-2 border-midnight pt-4">{{ $students->withQueryString()->links() }}</div>
        </div>
    </div>
</x-admin>