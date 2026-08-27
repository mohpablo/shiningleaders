<x-admin title="مدفوعات الطلاب">
    <div class="space-y-8">
        <div class="border-b-4 border-midnight pb-6">
            <h2 class="text-4xl font-heading font-bold">مدفوعات الطلاب</h2>
            <p class="mt-2 text-midnight/70">جميع الطلاب والدورات المسجلين، مع تحديد حالة الدفع الشهرية.</p>
        </div>

        @if(session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 font-bold text-emerald-700">{{ session('success') }}</div>
        @endif

        <div class="overflow-x-auto border-2 border-midnight bg-sand p-4 shadow-[8px_8px_0px_0px_#0B132B]">
            <table class="w-full text-right text-sm text-midnight">
                <thead class="bg-midnight text-sand">
                    <tr>
                        <th class="p-4">الطالب</th>
                        <th class="p-4">ولي الأمر</th>
                        <th class="p-4">الدورة</th>
                        <th class="p-4">المبلغ</th>
                        <th class="p-4">الحالة</th>
                        <th class="p-4">الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        @foreach($student->courses as $course)
                            @php
                                $subscription = $student->subscriptions->firstWhere('course_id', $course->id);
                                $payment = $subscription?->payments?->sortByDesc('created_at')->first();
                                $isPaid = $payment?->status === 'success';
                            @endphp
                            <tr class="border-b-2 border-midnight/20">
                                <td class="p-4 font-bold">{{ $student->name }}</td>
                                <td class="p-4">{{ $student->parent?->name ?? 'غير معروف' }}</td>
                                <td class="p-4">{{ $course->name }}</td>
                                <td class="p-4">{{ number_format($course->monthly_fee, 2) }} د.إ</td>
                                <td class="p-4"><span class="font-bold {{ $isPaid ? 'text-emerald-700' : 'text-rose-700' }}">{{ $isPaid ? 'تم الدفع' : 'لم يتم الدفع' }}</span></td>
                                <td class="p-4">
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
                        @endforeach
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center font-bold">لا يوجد طلاب مرتبطون بدورات.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-6">{{ $students->links() }}</div>
        </div>
    </div>
</x-admin>