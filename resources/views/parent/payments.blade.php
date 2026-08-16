<x-app title="سجل المدفوعات">
    <div class="space-y-8">
        <div class="border-b-4 border-midnight pb-6">
            <h2 class="text-4xl font-heading font-bold">سجل المدفوعات</h2>
            <p class="mt-2 text-midnight/70">تحقق من حالة جميع المدفوعات الخاصة باشتراكات أبنائك.</p>
        </div>

        <div class="overflow-x-auto rounded-3xl bg-white border border-sand shadow-xl">
            <table class="w-full text-right text-sm text-midnight">
                <thead class="bg-sand text-midnight/80">
                    <tr>
                        <th class="px-4 py-4">الطالب</th>
                        <th class="px-4 py-4">الدورة</th>
                        <th class="px-4 py-4">المبلغ</th>
                        <th class="px-4 py-4">الحالة</th>
                        <th class="px-4 py-4">التاريخ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-sand/80">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-sand/50">
                            <td class="px-4 py-4 font-semibold text-midnight">{{ $payment->subscription->student->name ?? 'غير معروف' }}</td>
                            <td class="px-4 py-4">{{ $payment->subscription->course->name ?? 'غير معروف' }}</td>
                            <td class="px-4 py-4">{{ number_format($payment->amount, 2) }} د.إ</td>
                            <td class="px-4 py-4">{{ ucfirst($payment->status) }}</td>
                            <td class="px-4 py-4">{{ $payment->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-midnight/70">لا توجد دفعات بعد.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $payments->links() }}
        </div>
    </div>
</x-app>
