<x-admin title="لوحة تحكم المعلم">
    <div class="space-y-8">
        <div class="rounded-3xl bg-white p-8 shadow-xl border border-sand">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-midnight">مرحباً، {{ auth()->user()->name }}</h1>
                    <p class="mt-2 text-sm text-midnight/70">إحصائيات دوراتك وأرباحك الحالية.</p>
                </div>
                <div class="grid gap-4 sm:grid-cols-3 text-center">
                    <div class="rounded-3xl bg-sand p-6">
                        <p class="text-sm text-midnight/70">إجمالي الدورات</p>
                        <p class="mt-2 text-3xl font-bold text-midnight">{{ $courses->count() }}</p>
                    </div>
                    <div class="rounded-3xl bg-sand p-6">
                        <p class="text-sm text-midnight/70">إجمالي المجموعات</p>
                        <p class="mt-2 text-3xl font-bold text-midnight">{{ $totalGroups }}</p>
                    </div>
                    <div class="rounded-3xl bg-sand p-6">
                        <p class="text-sm text-midnight/70">إجمالي الأرباح</p>
                        <p class="mt-2 text-3xl font-bold text-midnight">{{ number_format($earnings, 2) }} د.إ</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-3xl bg-white p-8 shadow-xl border border-sand">
            <h2 class="text-2xl font-bold text-midnight">الدورات الخاصة بك</h2>
            <div class="mt-6 grid gap-6 xl:grid-cols-2">
                @forelse($courses as $course)
                    <div class="rounded-3xl border border-sand p-6 bg-sand/70">
                        <h3 class="text-xl font-bold text-midnight">{{ $course->name }}</h3>
                        <p class="mt-2 text-sm text-midnight/70">{{ $course->description }}</p>
                        <div class="mt-4 grid gap-4 sm:grid-cols-2">
                            <div class="rounded-3xl bg-white p-4">
                                <p class="text-sm text-midnight/70">عدد المجموعات</p>
                                <p class="mt-2 text-lg font-bold text-midnight">{{ $course->groups_count }}</p>
                            </div>
                            <div class="rounded-3xl bg-white p-4">
                                <p class="text-sm text-midnight/70">عدد الطلاب</p>
                                <p class="mt-2 text-lg font-bold text-midnight">{{ $course->students_count }}</p>
                            </div>
                        </div>
                        <div class="mt-6 text-left">
                            <a href="{{ route('teacher.courses.show', $course) }}" class="rounded-3xl bg-midnight px-5 py-3 text-sm font-bold text-sand hover:bg-amber-600 transition">عرض الدورة</a>
                        </div>
                    </div>
                @empty
                    <div class="rounded-3xl border border-sand p-6 text-center text-midnight/70">
                        لا توجد دورات حالياً.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-admin>
