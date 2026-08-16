<x-admin title="دورة المعلم">
    <div class="space-y-8">
        <div class="rounded-3xl bg-white p-8 shadow-xl border border-sand">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-midnight">{{ $course->name }}</h1>
                    <p class="mt-2 text-sm text-midnight/70">عرض المجموعات والطلاب المرتبطين بهذه الدورة.</p>
                </div>
                <div class="text-right">
                    <a href="{{ route('teacher.courses') }}" class="rounded-3xl bg-sand px-5 py-3 text-sm font-bold text-midnight hover:bg-amber-100 transition">عودة إلى الدورات</a>
                </div>
            </div>

            <div class="mt-8 grid gap-4 sm:grid-cols-3">
                <div class="rounded-3xl bg-sand p-6">
                    <p class="text-sm text-midnight/70">عدد المجموعات</p>
                    <p class="mt-2 text-2xl font-bold text-midnight">{{ $groups->count() }}</p>
                </div>
                <div class="rounded-3xl bg-sand p-6">
                    <p class="text-sm text-midnight/70">عدد الطلاب المشتركين</p>
                    <p class="mt-2 text-2xl font-bold text-midnight">{{ $students->count() }}</p>
                </div>
                <div class="rounded-3xl bg-sand p-6">
                    <p class="text-sm text-midnight/70">الأرباح المحتسبة</p>
                    <p class="mt-2 text-2xl font-bold text-midnight">{{ number_format($students->count() * $course->monthly_fee * (auth()->user()->teacher_share / 100), 2) }} د.إ</p>
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-3xl bg-white p-8 shadow-xl border border-sand">
                <h2 class="text-2xl font-bold text-midnight">المجموعات</h2>
                <div class="mt-6 space-y-4">
                    @forelse($groups as $group)
                        <div class="rounded-3xl border border-sand p-6 bg-sand/70">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <h3 class="text-xl font-bold text-midnight">{{ $group->name }}</h3>
                                    <p class="mt-2 text-sm text-midnight/70">{{ $group->schedule }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-midnight/70">الطلاب</p>
                                    <p class="mt-1 font-bold text-midnight">{{ $group->students_count }}</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-3xl border border-amber-200 bg-amber-50 p-4 text-right">
                                <p class="text-sm text-midnight/70">الجلسات المكتملة</p>
                                <p class="mt-1 text-lg font-bold text-midnight">{{ $group->sessions_completed ?? 0 }} / {{ $course->monthly_sessions }}</p>
                                <p class="text-sm font-semibold {{ ($group->sessions_completed ?? 0) >= $course->monthly_sessions ? 'text-emerald-700' : 'text-amber-700' }}">
                                    {{ ($group->sessions_completed ?? 0) >= $course->monthly_sessions ? 'مكتملة' : 'جارية' }}
                                </p>
                            </div>
                            <div class="mt-6 text-left">
                                <a href="{{ route('teacher.courses.groups.show', [$course, $group]) }}" class="rounded-3xl bg-midnight px-5 py-3 text-sm font-bold text-sand hover:bg-amber-600 transition">عرض المجموعة</a>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-3xl border border-sand p-6 text-center text-midnight/70">
                            لا توجد مجموعات لهذه الدورة.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="rounded-3xl bg-white p-8 shadow-xl border border-sand">
                <h2 class="text-2xl font-bold text-midnight">الطلاب في الدورة</h2>
                <div class="mt-6 overflow-hidden rounded-3xl border border-sand bg-sand/60">
                    <table class="min-w-full text-right text-sm text-midnight">
                        <thead class="bg-sand text-midnight/80">
                            <tr>
                                <th class="px-4 py-4">الاسم</th>
                                <th class="px-4 py-4">السنة الدراسية</th>
                                <th class="px-4 py-4">ولي الأمر</th>
                                <th class="px-4 py-4">الحالة</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-sand/80">
                            @forelse($students as $student)
                                <tr>
                                    <td class="px-4 py-4">{{ $student->name }}</td>
                                    <td class="px-4 py-4">{{ $student->academic_year }}</td>
                                    <td class="px-4 py-4">{{ $student->parent?->name ?? 'غير معروف' }}</td>
                                    <td class="px-4 py-4">{{ $student->groups->contains(fn($studentGroup) => $studentGroup->course_id === $course->id) ? 'مسجل' : 'غير مسجل' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-midnight/70">لا يوجد طلاب في هذه الدورة.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin>
