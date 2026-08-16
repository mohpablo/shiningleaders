<x-admin title="الدورات الخاصة بالمعلم">
    <div class="space-y-8">
        <div class="rounded-3xl bg-white p-8 shadow-xl border border-sand">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-midnight">الدورات الخاصة بك</h1>
                    <p class="mt-2 text-sm text-midnight/70">إدارة دوراتك والمجموعات المرتبطة بها.</p>
                </div>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            @forelse($courses as $course)
                <div class="rounded-3xl border border-sand bg-white p-6 shadow-xl">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-2xl font-bold text-midnight">{{ $course->name }}</h3>
                            <p class="mt-2 text-sm text-midnight/70">{{ $course->description }}</p>
                        </div>
                        <span class="rounded-full bg-sand px-4 py-2 text-sm font-semibold text-midnight">{{ number_format($course->monthly_fee, 2) }} د.إ</span>
                    </div>
                    <div class="mt-6 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-3xl bg-sand p-4">
                            <p class="text-sm text-midnight/70">المجموعات</p>
                            <p class="mt-2 font-bold text-midnight">{{ $course->groups_count }}</p>
                        </div>
                        <div class="rounded-3xl bg-sand p-4">
                            <p class="text-sm text-midnight/70">الطلاب</p>
                            <p class="mt-2 font-bold text-midnight">{{ $course->students_count }}</p>
                        </div>
                        <div class="rounded-3xl bg-sand p-4">
                            <p class="text-sm text-midnight/70">الجلسات</p>
                            <p class="mt-2 font-bold text-midnight">{{ $course->monthly_sessions }}</p>
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

        <div class="mt-6">
            {{ $courses->links() }}
        </div>
    </div>
</x-admin>
