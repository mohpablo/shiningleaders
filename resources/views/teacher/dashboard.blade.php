<x-admin title="لوحة تحكم المعلم">
    <div class="space-y-8">
        <div class="rounded-3xl bg-white p-8 shadow-xl border border-sand">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-midnight">مرحباً، {{ auth()->user()->name }}</h1>
                    <p class="mt-2 text-sm text-midnight/70">إحصائيات دوراتك وأرباحك الحالية.</p>
                </div>
                <div class="grid gap-4 sm:grid-cols-4 text-center">
                    <div class="rounded-3xl bg-sand p-6">
                        <p class="text-sm text-midnight/70">إجمالي المجموعات</p>
                        <p class="mt-2 text-3xl font-bold text-midnight">{{ $totalGroups }}</p>
                    </div>
                    <div class="rounded-3xl bg-sand p-6">
                        <p class="text-sm text-midnight/70">إجمالي الطلاب</p>
                        <p class="mt-2 text-3xl font-bold text-midnight">{{ $totalStudents }}</p>
                    </div>
                    <div class="rounded-3xl bg-sand p-6">
                        <p class="text-sm text-midnight/70">إجمالي الأرباح</p>
                        <p class="mt-2 text-3xl font-bold text-midnight">{{ number_format($earnings, 2) }} د.إ</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-3xl bg-white p-8 shadow-xl border border-sand">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-midnight">مجموعاتك</h2>
                    <p class="mt-1 text-sm text-midnight/70">اختر مجموعة لمتابعة طلابها وتسجيل الجلسة.</p>
                </div>
                <a href="{{ route('teacher.groups') }}" class="text-sm font-bold text-terracotta hover:text-midnight">عرض كل المجموعات</a>
            </div>
            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                @forelse($groups as $group)
                    <div class="flex min-w-0 flex-col rounded-3xl border border-sand bg-sand/70 p-5">
                        <p class="text-sm font-bold text-terracotta">{{ $group->course->name }}</p>
                        <h3 class="mt-1 wrap-break-word text-xl font-bold text-midnight">{{ $group->name }}</h3>
                        <p class="mt-2 wrap-break-word text-sm text-midnight/70">{{ $group->schedule }}</p>
                        <div class="mt-4 grid grid-cols-2 gap-3">
                            <div class="rounded-2xl bg-white p-3">
                                <p class="text-xs text-midnight/70">الطلاب</p>
                                <p class="mt-1 font-bold text-midnight">{{ $group->students->count() }}</p>
                            </div>
                            <div class="rounded-2xl bg-white p-3">
                                <p class="text-xs text-midnight/70">الجلسات</p>
                                <p class="mt-1 font-bold text-midnight">{{ $group->sessions_completed }}</p>
                            </div>
                        </div>
                        <a href="{{ route('teacher.groups.show', $group) }}" class="mt-5 w-full rounded-2xl bg-midnight px-4 py-3 text-center text-sm font-bold text-sand hover:bg-amber-600 transition">فتح المجموعة</a>
                    </div>
                @empty
                    <div class="rounded-3xl border border-sand p-6 text-center text-midnight/70 sm:col-span-2">
                        لا توجد مجموعات حالياً.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-admin>
