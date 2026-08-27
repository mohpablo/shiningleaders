<x-admin title="تأكيد المدفوعات">
    <div class="space-y-8">
        <div class="border-b-4 border-midnight pb-6">
            <h2 class="text-4xl font-heading font-bold">تأكيد المدفوعات</h2>
            <p class="mt-2 text-midnight/70">اختر الاشتراكات التي تم دفعها لتفعيلها.</p>
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
                    @forelse($payments as $payment)
                    <tr class="border-b-2 border-midnight/20">
                        <td class="p-4 font-bold">{{ $payment->subscription->student->name ?? 'غير معروف' }}</td>
                        <td class="p-4">{{ $payment->subscription->parent->name ?? 'غير معروف' }}</td>
                        <td class="p-4">{{ $payment->subscription->course->name ?? 'غير معروف' }}</td>
                        <td class="p-4">{{ number_format($payment->amount, 2) }} د.إ</td>
                        <td class="p-4">{{ $payment->status === 'success' ? 'تم الدفع' : 'بانتظار الدفع' }}</td>
                        <td class="p-4">
                            @if($payment->status !== 'success')
                            <form action="{{ route('admin.payments.paid', $payment) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="rounded-full bg-emerald-600 px-4 py-2 text-xs font-bold text-white transition hover:bg-emerald-700">تم الدفع</button>
                            </form>
                            @else
                            <span class="font-bold text-emerald-700">مؤكد</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center font-bold">لا توجد مدفوعات بعد.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-6">{{ $payments->links() }}</div>
        </div>
    </div>
</x-admin>