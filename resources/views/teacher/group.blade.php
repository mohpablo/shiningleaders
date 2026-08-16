<x-admin title="مجموعة المعلم">
    <div class="space-y-8">
        <div class="rounded-3xl bg-white p-8 shadow-xl border border-sand">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-midnight">{{ $group->name }}</h1>
                    <p class="mt-2 text-sm text-midnight/70">تحديث حالات الطلاب ضمن هذه المجموعة.</p>
                    <p class="mt-2 text-sm font-semibold text-midnight/80">الجلسات المكتملة: {{ $group->sessions_completed }}</p>
                </div>
                <div class="text-left flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
                    <a href="{{ route('teacher.courses.show', $course) }}" class="rounded-3xl bg-sand px-5 py-3 text-sm font-bold text-midnight hover:bg-amber-100 transition">عودة إلى الدورة</a>
                    <form action="{{ route('teacher.courses.groups.session.complete', [$course, $group]) }}" method="POST">
                        @csrf
                        <button type="submit" class="rounded-3xl bg-midnight px-5 py-3 text-sm font-bold text-sand hover:bg-amber-600 transition">تسجيل الجلسة المنفذة</button>
                    </form>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-3xl bg-white p-8 shadow-xl border border-sand">
            <h2 class="text-2xl font-bold text-midnight">الطلاب في المجموعة</h2>
            <div class="mt-6 overflow-hidden rounded-3xl border border-sand bg-sand/60">
                <table class="min-w-full text-right text-sm text-midnight">
                    <thead class="bg-sand text-midnight/80">
                        <tr>
                            <th class="px-4 py-4">الاسم</th>
                            <th class="px-4 py-4">ولي الأمر</th>
                            <th class="px-4 py-4">الحضور</th>
                            <th class="px-4 py-4">الواجب</th>
                            <th class="px-4 py-4">التعليق</th>
                            <th class="px-4 py-4">إجراء</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-sand/80">
                        @forelse($students as $student)
                            <tr>
                                <td class="px-4 py-4">{{ $student->name }}</td>
                                <td class="px-4 py-4">{{ $student->parent?->name ?? 'غير معروف' }}</td>
                                <td class="px-4 py-4">{{ $student->pivot->attendance ? 'حاضر' : 'غائب' }}</td>
                                <td class="px-4 py-4">{{ $student->pivot->homework_completed ? 'مكتمل' : 'غير مكتمل' }}</td>
                                <td class="px-4 py-4">{{ $student->pivot->comment ?? 'لا يوجد' }}</td>
                                <td class="px-4 py-4 text-left">
                                    <form action="{{ route('teacher.courses.groups.students.mark', [$course, $group, $student]) }}" method="POST" class="space-y-3">
                                        @csrf
                                        <div class="flex flex-col gap-2">
                                            <label class="inline-flex items-center gap-2">
                                                <input type="checkbox" name="attendance" value="1" {{ $student->pivot->attendance ? 'checked' : '' }} class="rounded border-sand text-midnight focus:ring-midnight">
                                                حضور
                                            </label>
                                            <label class="inline-flex items-center gap-2">
                                                <input type="checkbox" name="homework_completed" value="1" {{ $student->pivot->homework_completed ? 'checked' : '' }} class="rounded border-sand text-midnight focus:ring-midnight">
                                                واجب مكتمل
                                            </label>
                                            <label class="block">
                                                <span class="text-sm font-semibold text-midnight/80">تعليق المعلم</span>
                                                <textarea name="comment" rows="2" class="mt-2 w-full rounded-3xl border border-sand bg-white px-4 py-3 text-sm text-midnight shadow-sm focus:border-midnight focus:outline-none focus:ring-midnight/20">{{ old('comment', $student->pivot->comment) }}</textarea>
                                            </label>
                                            <button type="submit" class="rounded-3xl bg-midnight px-4 py-2 text-xs font-bold text-sand hover:bg-amber-600 transition">تحديث</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-midnight/70">لا يوجد طلاب في هذه المجموعة.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin>
