<x-app title="إدارة الأبناء">
    <div class="space-y-6 sm:space-y-8">
        @if(session('success'))
        <div class="bg-midnight text-sand border-2 border-midnight p-4 shadow-[4px_4px_0px_0px_#D97706] flex items-center justify-between">
            <span class="font-bold">{{ session('success') }}</span>
            <span class="text-terracotta font-bold">✓</span>
        </div>
        @endif
        <!-- Header & Add Button -->
        <div class="flex flex-col gap-5 border-b-4 border-midnight pb-6 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-3xl font-heading font-bold sm:text-4xl">أبنائي ({{ $count }})</h2>
                <p class="mt-2 text-sm text-midnight/70 sm:text-base">تابع أبناءك، اشتراكاتهم، حالات الدفع، والتقدم اليوم.</p>
            </div>
            <a href="{{ route('add-student') }}"
                class="w-full bg-midnight px-5 py-3 text-center font-bold text-sand shadow-[4px_4px_0px_0px_#D97706] transition-all hover:bg-terracotta hover:text-white sm:w-auto">
                إضافة ابن جديد
            </a>
        </div>

        <div class="mt-6 grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-4">
            <div class="rounded-3xl border border-sand bg-white p-4 shadow-xl sm:p-6">
                <p class="text-sm text-midnight/70">إجمالي الأبناء</p>
                <p class="mt-2 text-2xl font-bold text-midnight sm:mt-3 sm:text-3xl">{{ $count }}</p>
            </div>
            <div class="rounded-3xl border border-sand bg-white p-4 shadow-xl sm:p-6">
                <p class="text-sm text-midnight/70">إجمالي الاشتراكات</p>
                <p class="mt-2 text-2xl font-bold text-midnight sm:mt-3 sm:text-3xl">{{ $totalSubscriptions ?? 0 }}</p>
            </div>
            <div class="rounded-3xl border border-sand bg-white p-4 shadow-xl sm:p-6">
                <p class="text-sm text-midnight/70">الاشتراكات النشطة</p>
                <p class="mt-2 text-2xl font-bold text-midnight sm:mt-3 sm:text-3xl">{{ $activeSubscriptions ?? 0 }}</p>
            </div>
            <div class="rounded-3xl border border-sand bg-white p-4 shadow-xl sm:p-6">
                <p class="text-sm text-midnight/70">المدفوعات الناجحة</p>
                <p class="mt-2 text-2xl font-bold text-midnight sm:mt-3 sm:text-3xl">{{ $successfulPayments ?? 0 }}</p>
            </div>
        </div>

        <div class="space-y-4">
            <div class="flex items-end justify-between gap-3">
                <div>
                    <h3 class="text-2xl font-bold text-midnight">ملف الأبناء</h3>
                    <p class="mt-1 text-sm text-midnight/70">افتح ملف أي طالب لمتابعة الدورات والدفع.</p>
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                @forelse($children as $child)
                    @php
                        $childSubscriptions = $child->subscriptions;
                        $childPayments = $childSubscriptions->flatMap->payments;
                    @endphp
                    <article class="rounded-3xl border-2 border-midnight bg-white p-5 shadow-[5px_5px_0px_0px_#0B132B] sm:p-6">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h4 class="wrap-break-word text-xl font-bold text-midnight">{{ $child->name }}</h4>
                                <p class="mt-1 text-sm text-midnight/70">{{ $child->academic_year ?: 'الصف غير محدد' }}</p>
                            </div>
                            <span class="shrink-0 rounded-full bg-sand px-3 py-1 text-xs font-bold text-midnight">{{ $childSubscriptions->count() }} دورات</span>
                        </div>
                        <div class="mt-5 grid grid-cols-2 gap-3">
                            <div class="rounded-2xl bg-sand p-3">
                                <p class="text-xs text-midnight/70">اشتراكات نشطة</p>
                                <p class="mt-1 text-lg font-bold text-midnight">{{ $childSubscriptions->where('status', 'active')->count() }}</p>
                            </div>
                            <div class="rounded-2xl bg-sand p-3">
                                <p class="text-xs text-midnight/70">مدفوعات ناجحة</p>
                                <p class="mt-1 text-lg font-bold text-midnight">{{ $childPayments->where('status', 'success')->count() }}</p>
                            </div>
                        </div>
                        <a href="{{ route('parent.student.show', $child) }}" class="mt-5 block w-full bg-midnight px-4 py-3 text-center text-sm font-bold text-sand transition hover:bg-terracotta">فتح ملف الطالب</a>
                    </article>
                @empty
                    <div class="rounded-3xl border-2 border-midnight bg-white p-8 text-center font-bold md:col-span-2">لم يتم إضافة أبناء بعد.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app>