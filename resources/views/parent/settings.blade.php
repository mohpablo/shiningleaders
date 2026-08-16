<x-app title="إعدادات الحساب">
    <div class="space-y-8">
        <div class="border-b-4 border-midnight pb-6">
            <h2 class="text-4xl font-heading font-bold">إعدادات الحساب</h2>
            <p class="mt-2 text-midnight/70">يمكنك تعديل إعدادات حساب ولي الأمر ومعلومات الاتصال لاحقًا.</p>
        </div>

        <div class="rounded-3xl bg-white p-8 shadow-xl border border-sand">
            <div class="grid gap-6 lg:grid-cols-2">
                <div class="rounded-3xl bg-sand p-6">
                    <h3 class="font-bold text-midnight">معلومات الحساب</h3>
                    <p class="mt-3 text-midnight/70">تأتي هذه المعلومات من حساب المستخدم المسجل.</p>
                </div>
                <div class="rounded-3xl bg-sand p-6">
                    <p class="text-sm text-midnight/70">البريد الإلكتروني</p>
                    <p class="mt-2 font-semibold text-midnight">{{ auth()->user()->email }}</p>
                </div>
                <div class="rounded-3xl bg-sand p-6">
                    <p class="text-sm text-midnight/70">الاسم</p>
                    <p class="mt-2 font-semibold text-midnight">{{ auth()->user()->name }}</p>
                </div>
                <div class="rounded-3xl bg-sand p-6">
                    <p class="text-sm text-midnight/70">الدور</p>
                    <p class="mt-2 font-semibold text-midnight">{{ ucfirst(auth()->user()->role) }}</p>
                </div>
            </div>

            <div class="mt-8 rounded-3xl bg-sand p-6">
                <p class="font-bold text-midnight">ملاحظة</p>
                <p class="mt-2 text-midnight/70">يمكن إضافة صفحة إعدادات متقدمة لاحقًا لتغيير كلمة المرور أو إعدادات الدفع.</p>
            </div>
        </div>
    </div>
</x-app>
