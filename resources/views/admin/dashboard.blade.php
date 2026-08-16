<x-admin>
    <div class="space-y-8">
        <section class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-3xl bg-white p-6 shadow-xl border border-sand">
                <p class="text-sm font-semibold text-midnight/70">أولياء الأمور</p>
                <p class="mt-4 text-4xl font-bold text-midnight">{{ number_format($totalParents) }}</p>
            </div>
            <div class="rounded-3xl bg-white p-6 shadow-xl border border-sand">
                <p class="text-sm font-semibold text-midnight/70">الطلاب</p>
                <p class="mt-4 text-4xl font-bold text-midnight">{{ number_format($totalStudents) }}</p>
            </div>
            <div class="rounded-3xl bg-white p-6 shadow-xl border border-sand">
                <p class="text-sm font-semibold text-midnight/70">المجموعات</p>
                <p class="mt-4 text-4xl font-bold text-midnight">{{ number_format($totalGroups) }}</p>
            </div>
            <div class="rounded-3xl bg-white p-6 shadow-xl border border-sand">
                <p class="text-sm font-semibold text-midnight/70">الدورات</p>
                <p class="mt-4 text-4xl font-bold text-midnight">{{ number_format($totalCourses) }}</p>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-3xl bg-gradient-to-br from-midnight to-amber-700 p-6 text-sand shadow-xl border border-amber-500">
                <p class="text-sm font-semibold uppercase tracking-[0.14em]">إجمالي الإيرادات</p>
                <p class="mt-4 text-4xl font-bold">{{ number_format($totalEarnings, 2) }} د.إ</p>
                <p class="mt-2 text-sm text-sand/80">إجمالي المدفوعات الناجحة من {{ number_format($totalPayments) }} دفعات</p>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-xl border border-sand">
                <p class="text-sm font-semibold text-midnight/70">طلاب دفعوا</p>
                <p class="mt-4 text-3xl font-bold text-emerald-700">{{ number_format($paidStudents) }}</p>
                <p class="mt-2 text-sm text-midnight/70">طلاب مع دفعات ناجحة</p>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-xl border border-sand">
                <p class="text-sm font-semibold text-midnight/70">طلاب لم يدفعوا</p>
                <p class="mt-4 text-3xl font-bold text-rose-600">{{ number_format($pendingStudents) }}</p>
                <p class="mt-2 text-sm text-midnight/70">طلاب بدون دفعة ناجحة</p>
            </div>
        </section>

        <section class="rounded-3xl bg-white p-6 shadow-xl border border-sand">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-midnight">آخر المجموعات</h2>
                    <p class="mt-1 text-sm text-midnight/70">المجموعة، الدورة، وساعة الجدول.</p>
                </div>
                <span class="inline-flex items-center rounded-full bg-sand px-4 py-2 text-sm font-semibold text-midnight">أحدث 5 مجموعات</span>
            </div>

            <div class="mt-6 space-y-4">
                @forelse($latestGroups as $group)
                    <div class="rounded-3xl border border-sand p-4 bg-sand/70">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="font-bold text-midnight">{{ $group->name }}</p>
                                <p class="text-sm text-midnight/70">{{ $group->course->name ?? 'دورة غير معروفة' }}</p>
                            </div>
                            <p class="text-sm font-semibold text-midnight/70">سعة {{ $group->capacity ?? 'غير محددة' }}</p>
                        </div>
                        <p class="mt-3 text-sm text-midnight/70">{{ $group->schedule }}</p>
                    </div>
                @empty
                    <p class="text-sm text-midnight/70">لا توجد مجموعات حتى الآن.</p>
                @endforelse
            </div>
        </section>
    </div>
</x-admin>