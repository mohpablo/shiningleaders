<x-app title="تأكيد الدفع">
    <div class="space-y-8">
        <div class="rounded-3xl border border-sand bg-white p-8 shadow-xl">
            <h2 class="text-3xl font-bold text-midnight">تم تسجيل طلب الدفع</h2>
            <p class="mt-3 text-midnight/70">يرجى التواصل مع الإدارة لإتمام الدفع. سيتم تفعيل الاشتراك بعد تأكيد استلام المبلغ.</p>

            <div class="mt-8 grid gap-6 lg:grid-cols-3">
                <div class="rounded-3xl bg-sand p-6">
                    <p class="text-sm text-midnight/70">الطالب</p>
                    <p class="mt-2 font-bold text-midnight">{{ $student->name }}</p>
                </div>
                <div class="rounded-3xl bg-sand p-6">
                    <p class="text-sm text-midnight/70">الدورة</p>
                    <p class="mt-2 font-bold text-midnight">{{ $subscription->course->name }}</p>
                </div>
                <div class="rounded-3xl bg-sand p-6">
                    <p class="text-sm text-midnight/70">المبلغ</p>
                    <p class="mt-2 font-bold text-midnight">{{ number_format($payment->amount, 2) }} د.إ</p>
                </div>
            </div>

            <a href="{{ route('parent.payments') }}" class="mt-8 inline-flex items-center justify-center rounded-3xl bg-midnight px-6 py-3 text-sm font-bold text-sand transition hover:bg-amber-600">عرض سجل المدفوعات</a>
        </div>
    </div>
</x-app>