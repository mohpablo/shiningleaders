<x-admin title="لوحة تحكم الإدارة">
    <div class="space-y-6 sm:space-y-8">
        <section class="border-2 border-midnight bg-midnight p-5 text-sand shadow-[8px_8px_0px_0px_#D97706] sm:p-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-terracotta">Shining Leaders</p>
                    <h1 class="mt-3 text-3xl font-bold leading-tight text-white sm:text-5xl">لوحة الإدارة</h1>
                    <p class="mt-3 max-w-xl text-sm leading-7 text-sand/80 sm:text-base">نظرة سريعة على الطلاب، أولياء الأمور، الدورات، المجموعات والمدفوعات.</p>
                </div>
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-4 lg:min-w-120">
                    <a href="{{ route('admin.students.index') }}" class="border border-sand/30 bg-clay p-3 text-center transition hover:border-terracotta hover:bg-terracotta">
                        <span class="block text-2xl font-bold text-white">{{ number_format($totalStudents) }}</span>
                        <span class="mt-1 block text-xs font-bold text-sand/75">الطلاب</span>
                    </a>
                    <a href="{{ route('admin.course') }}" class="border border-sand/30 bg-clay p-3 text-center transition hover:border-terracotta hover:bg-terracotta">
                        <span class="block text-2xl font-bold text-white">{{ number_format($totalCourses) }}</span>
                        <span class="mt-1 block text-xs font-bold text-sand/75">الدورات</span>
                    </a>
                    <a href="{{ route('admin.programs.index') }}" class="border border-sand/30 bg-clay p-3 text-center transition hover:border-terracotta hover:bg-terracotta">
                        <span class="block text-2xl font-bold text-white">{{ number_format($totalTeachers) }}</span>
                        <span class="mt-1 block text-xs font-bold text-sand/75">المدرسون</span>
                    </a>
                    <a href="{{ route('admin.parents.index') }}" class="border border-sand/30 bg-clay p-3 text-center transition hover:border-terracotta hover:bg-terracotta">
                        <span class="block text-2xl font-bold text-white">{{ number_format($totalParents) }}</span>
                        <span class="mt-1 block text-xs font-bold text-sand/75">الأهالي</span>
                    </a>
                </div>
            </div>
        </section>

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="border-2 border-midnight bg-white p-5 shadow-[5px_5px_0px_0px_#0B132B] sm:p-6">
                <p class="text-sm font-bold text-midnight/65">إجمالي المجموعات</p>
                <p class="mt-3 text-3xl font-bold text-midnight sm:text-4xl">{{ number_format($totalGroups) }}</p>
                <div class="mt-4 h-1 bg-terracotta"></div>
            </div>
            <div class="border-2 border-midnight bg-white p-5 shadow-[5px_5px_0px_0px_#065F46] sm:p-6">
                <p class="text-sm font-bold text-midnight/65">إجمالي الإيرادات</p>
                <p class="mt-3 text-2xl font-bold text-midnight sm:text-3xl">{{ number_format($totalEarnings, 2) }} د.إ</p>
                <p class="mt-2 text-xs text-midnight/60">من {{ number_format($totalPayments) }} دفعة</p>
            </div>
            <div class="border-2 border-midnight bg-white p-5 shadow-[5px_5px_0px_0px_#10B981] sm:p-6">
                <p class="text-sm font-bold text-midnight/65">طلاب دفعوا</p>
                <p class="mt-3 text-3xl font-bold text-emerald-700 sm:text-4xl">{{ number_format($paidStudents) }}</p>
                <p class="mt-2 text-xs text-midnight/60">لديهم دفعة ناجحة</p>
            </div>
            <div class="border-2 border-midnight bg-white p-5 shadow-[5px_5px_0px_0px_#E11D48] sm:p-6">
                <p class="text-sm font-bold text-midnight/65">طلاب لم يدفعوا</p>
                <p class="mt-3 text-3xl font-bold text-rose-600 sm:text-4xl">{{ number_format($pendingStudents) }}</p>
                <p class="mt-2 text-xs text-midnight/60">بدون دفعة ناجحة</p>
            </div>
        </section>

        <section class="border-2 border-midnight bg-white shadow-[8px_8px_0px_0px_#0B132B]">
            <div class="flex flex-col gap-4 border-b-2 border-midnight bg-sand p-5 sm:flex-row sm:items-center sm:justify-between sm:p-6">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-forest">المتابعة اليومية</p>
                    <h2 class="mt-1 text-2xl font-bold text-midnight">آخر المجموعات</h2>
                    <p class="mt-1 text-sm text-midnight/70">تابع الجدول وعدد الجلسات المنفذة لكل مجموعة.</p>
                </div>
                <a href="{{ route('admin.course') }}" class="w-full border-2 border-midnight bg-white px-4 py-3 text-center text-sm font-bold text-midnight transition hover:bg-midnight hover:text-sand sm:w-auto">إدارة الدورات</a>
            </div>

            <div class="grid gap-4 p-4 sm:p-6 lg:grid-cols-2">
                @forelse($latestGroups as $group)
                    <article class="border-2 border-midnight bg-sand p-4 transition hover:bg-white sm:p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-terracotta">{{ $group->course->name ?? 'دورة غير معروفة' }}</p>
                                <h3 class="mt-1 wrap-break-word text-lg font-bold text-midnight">{{ $group->name }}</h3>
                            </div>
                            <span class="shrink-0 border border-midnight bg-white px-2 py-1 text-xs font-bold text-midnight">{{ $group->sessions_completed ?? 0 }} جلسات</span>
                        </div>
                        <p class="mt-4 border-t border-midnight/15 pt-3 text-sm text-midnight/70">{{ $group->schedule }}</p>
                    </article>
                @empty
                    <p class="p-4 text-sm text-midnight/70 lg:col-span-2">لا توجد مجموعات حتى الآن.</p>
                @endforelse
            </div>
        </section>
    </div>
</x-admin>