<x-app title="دفع PayMob">
    <div class="space-y-8">
        <div class="rounded-3xl bg-white p-8 shadow-xl border border-sand">
            <h2 class="text-3xl font-bold text-midnight">دفع عبر PayMob (وضع الاختبار)</h2>
            <p class="mt-3 text-sm text-midnight/70">سيتم تحويلك إلى صفحة الدفع التجريبي لاختبار عملية الدفع قبل الإنتاج.</p>

            <div class="mt-8 grid gap-6 lg:grid-cols-2">
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
                    <p class="mt-2 font-bold text-midnight">{{ number_format($subscription->course->monthly_fee, 2) }} د.إ</p>
                </div>
                <div class="rounded-3xl bg-sand p-6">
                    <p class="text-sm text-midnight/70">حالة الدفع</p>
                    <p class="mt-2 font-bold text-midnight">{{ ucfirst($subscription->status) }}</p>
                </div>
            </div>

            <div class="mt-8">
                @if(config('services.paymob.iframe_id'))
                    <a href="https://accept.paymob.com/api/acceptance/iframes/{{ config('services.paymob.iframe_id') }}?payment_token={{ $paymentToken }}" target="_blank" class="inline-flex items-center justify-center rounded-3xl bg-midnight px-6 py-3 text-sm font-bold text-sand hover:bg-amber-600 transition">ابدأ الدفع التجريبي</a>
                @else
                    <div class="rounded-3xl border border-rose-200 bg-rose-50 p-4 text-rose-700">
                        PAYMOB_IFRAME_ID غير مضبوط، أضف قيمته في .env ثم أعد تشغيل التطبيق.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app>
