<x-admin title="مجموعة المعلم">
    <div class="space-y-8">
        <div class="rounded-3xl bg-white p-4 shadow-xl border border-sand sm:p-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-midnight">{{ $group->name }}</h1>
                    <p class="mt-2 text-sm text-midnight/70">تحديث حالات الطلاب ضمن هذه المجموعة.</p>
                    <p class="mt-2 text-sm font-semibold text-midnight/80">الجلسة الحالية: {{ $currentSession }} | الجلسات المكتملة: {{ $group->sessions_completed }}</p>
                </div>
                <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:items-center sm:justify-end">
                    <a href="{{ route('teacher.groups') }}" class="w-full rounded-3xl bg-sand px-5 py-3 text-center text-sm font-bold text-midnight hover:bg-amber-100 transition sm:w-auto">عودة إلى المجموعات</a>
                        <form action="{{ route('teacher.groups.session.complete', $group) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full rounded-3xl bg-midnight px-5 py-3 text-sm font-bold text-sand hover:bg-amber-600 transition sm:w-auto">تسجيل الجلسة المنفذة</button>
                    </form>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-3xl bg-white p-4 shadow-xl border border-sand sm:p-8">
            <h2 class="text-2xl font-bold text-midnight">الطلاب في المجموعة</h2>
            <div class="mt-6 space-y-4 md:hidden">
                @forelse($students as $student)
                    @php($currentRecord = $student->sessionRecords->firstWhere('session_number', $currentSession))
                    <article class="rounded-2xl border border-sand bg-sand/60 p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h3 class="wrap-break-word text-lg font-bold text-midnight">{{ $student->name }}</h3>
                                <p class="mt-1 text-sm text-midnight/70">ولي الأمر: {{ $student->parent?->name ?? 'غير معروف' }}</p>
                            </div>
                            <span class="shrink-0 rounded-full bg-white px-3 py-1 text-xs font-bold text-midnight">الجلسة {{ $currentSession }}</span>
                        </div>
                        <form action="{{ route('teacher.groups.students.mark', [$group, $student]) }}" method="POST" class="mt-4 space-y-3">
                            @csrf
                            <label class="block">
                                <span class="text-sm font-semibold text-midnight/80">الحضور</span>
                                <select name="attendance" class="mt-2 w-full rounded-2xl border border-sand bg-white px-4 py-3 text-sm text-midnight focus:border-midnight focus:outline-none">
                                    <option value="1" {{ $currentRecord?->attendance ? 'selected' : '' }}>حاضر</option>
                                    <option value="0" {{ $currentRecord && ! $currentRecord->attendance ? 'selected' : '' }}>غائب</option>
                                </select>
                            </label>
                            <label class="block">
                                <span class="text-sm font-semibold text-midnight/80">حالة الواجب</span>
                                <select name="homework_status" class="mt-2 w-full rounded-2xl border border-sand bg-white px-4 py-3 text-sm text-midnight focus:border-midnight focus:outline-none">
                                    <option value="completed" {{ $currentRecord?->homework_status === 'completed' ? 'selected' : '' }}>مكتمل</option>
                                    <option value="partial" {{ $currentRecord?->homework_status === 'partial' ? 'selected' : '' }}>أنجز نصفه</option>
                                    <option value="not_completed" {{ ! $currentRecord || $currentRecord->homework_status === 'not_completed' ? 'selected' : '' }}>لم ينجزه</option>
                                </select>
                            </label>
                            <label class="block">
                                <span class="text-sm font-semibold text-midnight/80">ملاحظات المعلم</span>
                                <textarea name="comment" rows="3" class="mt-2 w-full rounded-2xl border border-sand bg-white px-4 py-3 text-sm text-midnight shadow-sm focus:border-midnight focus:outline-none">{{ old('comment', $currentRecord?->comment) }}</textarea>
                            </label>
                            <button type="submit" class="w-full rounded-2xl bg-midnight px-4 py-3 text-sm font-bold text-sand hover:bg-amber-600 transition">حفظ بيانات الجلسة</button>
                        </form>
                        @if($student->sessionRecords->isNotEmpty())
                            <details class="mt-4 text-right">
                                <summary class="cursor-pointer text-xs font-bold text-midnight">سجل الجلسات السابقة</summary>
                                <div class="mt-2 space-y-2 text-xs leading-5 text-midnight/80">
                                    @foreach($student->sessionRecords as $record)
                                        <p>الجلسة {{ $record->session_number }}: {{ $record->attendance ? 'حاضر' : 'غائب' }}، {{ ['completed' => 'الواجب مكتمل', 'partial' => 'أنجز نصف الواجب', 'not_completed' => 'الواجب غير مكتمل'][$record->homework_status] }}{{ $record->comment ? ' - ' . $record->comment : '' }}</p>
                                    @endforeach
                                </div>
                            </details>
                        @endif
                    </article>
                @empty
                    <div class="rounded-2xl border border-sand p-6 text-center text-midnight/70">لا يوجد طلاب في هذه المجموعة.</div>
                @endforelse
            </div>
            <div class="mt-6 hidden overflow-x-auto rounded-3xl border border-sand bg-sand/60 md:block">
                <table class="min-w-225 text-right text-sm text-midnight">
                    <thead class="bg-sand text-midnight/80">
                        <tr>
                            <th class="px-4 py-4">الاسم</th>
                            <th class="px-4 py-4">ولي الأمر</th>
                            <th class="px-4 py-4">حضور الجلسة {{ $currentSession }}</th>
                            <th class="px-4 py-4">الواجب</th>
                            <th class="px-4 py-4">ملاحظات</th>
                            <th class="px-4 py-4">إجراء</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-sand/80">
                        @forelse($students as $student)
                            @php($currentRecord = $student->sessionRecords->firstWhere('session_number', $currentSession))
                            <tr>
                                <td class="px-4 py-4">{{ $student->name }}</td>
                                <td class="px-4 py-4">{{ $student->parent?->name ?? 'غير معروف' }}</td>
                                <td class="px-4 py-4">{{ $currentRecord?->attendance ? 'حاضر' : 'غائب' }}</td>
                                <td class="px-4 py-4">
                                    {{ ['completed' => 'مكتمل', 'partial' => 'أنجز نصفه', 'not_completed' => 'لم ينجزه'][$currentRecord?->homework_status ?? 'not_completed'] }}
                                </td>
                                <td class="px-4 py-4">{{ $currentRecord?->comment ?? 'لا يوجد' }}</td>
                                <td class="px-4 py-4 text-left">
                                    <form action="{{ route('teacher.groups.students.mark', [$group, $student]) }}" method="POST" class="space-y-3">
                                        @csrf
                                        <div class="flex flex-col gap-2">
                                            <label class="block">
                                                <span class="text-sm font-semibold text-midnight/80">الحضور</span>
                                                <select name="attendance" class="mt-2 w-full rounded-3xl border border-sand bg-white px-4 py-3 text-sm text-midnight focus:border-midnight focus:outline-none">
                                                    <option value="1" {{ $currentRecord?->attendance ? 'selected' : '' }}>حاضر</option>
                                                    <option value="0" {{ $currentRecord && ! $currentRecord->attendance ? 'selected' : '' }}>غائب</option>
                                                </select>
                                            </label>
                                            <label class="block">
                                                <span class="text-sm font-semibold text-midnight/80">حالة الواجب</span>
                                                <select name="homework_status" class="mt-2 w-full rounded-3xl border border-sand bg-white px-4 py-3 text-sm text-midnight focus:border-midnight focus:outline-none">
                                                    <option value="completed" {{ $currentRecord?->homework_status === 'completed' ? 'selected' : '' }}>مكتمل</option>
                                                    <option value="partial" {{ $currentRecord?->homework_status === 'partial' ? 'selected' : '' }}>أنجز نصفه</option>
                                                    <option value="not_completed" {{ ! $currentRecord || $currentRecord->homework_status === 'not_completed' ? 'selected' : '' }}>لم ينجزه</option>
                                                </select>
                                            </label>
                                            <label class="block">
                                                <span class="text-sm font-semibold text-midnight/80">ملاحظات المعلم</span>
                                                <textarea name="comment" rows="2" class="mt-2 w-full rounded-3xl border border-sand bg-white px-4 py-3 text-sm text-midnight shadow-sm focus:border-midnight focus:outline-none focus:ring-midnight/20">{{ old('comment', $currentRecord?->comment) }}</textarea>
                                            </label>
                                            <button type="submit" class="rounded-3xl bg-midnight px-4 py-2 text-xs font-bold text-sand hover:bg-amber-600 transition">تحديث</button>
                                        </div>
                                    </form>
                                    @if($student->sessionRecords->isNotEmpty())
                                        <details class="mt-3 text-right">
                                            <summary class="cursor-pointer text-xs font-bold text-midnight">سجل الجلسات السابقة</summary>
                                            <div class="mt-2 space-y-1 text-xs text-midnight/80">
                                                @foreach($student->sessionRecords as $record)
                                                    <p>الجلسة {{ $record->session_number }}: {{ $record->attendance ? 'حاضر' : 'غائب' }}، {{ ['completed' => 'الواجب مكتمل', 'partial' => 'أنجز نصف الواجب', 'not_completed' => 'الواجب غير مكتمل'][$record->homework_status] }}{{ $record->comment ? ' - ' . $record->comment : '' }}</p>
                                                @endforeach
                                            </div>
                                        </details>
                                    @endif
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
