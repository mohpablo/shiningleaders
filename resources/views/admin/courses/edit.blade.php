<x-admin>
    <div class="space-y-6">
        <div class="rounded-3xl bg-white p-8 shadow-xl border border-sand">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-midnight">تحرير الدورة</h1>
                    <p class="mt-2 text-sm text-midnight/70">يمكنك تحديث بيانات الدورة. يتم اختيار المعلم لكل مجموعة.</p>
                </div>
                <a href="{{ route('admin.course') }}" class="inline-flex items-center justify-center rounded-3xl bg-sand px-5 py-3 text-sm font-bold text-midnight transition hover:bg-amber-100">عودة إلى الدورات</a>
            </div>

            @if(session('success'))
            <div class="mt-6 rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('admin.course.update', $course) }}" method="POST" class="mt-8 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="mb-2 block text-sm font-semibold text-midnight">اسم الدورة</label>
                    <input type="text" name="name" value="{{ old('name', $course->name) }}" class="w-full rounded-3xl border border-sand bg-sand/60 px-4 py-3 text-right text-midnight outline-none focus:border-midnight" required>
                    @error('name')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-midnight">الوصف</label>
                    <textarea name="description" rows="4" class="w-full rounded-3xl border border-sand bg-sand/60 px-4 py-3 text-right text-midnight outline-none focus:border-midnight">{{ old('description', $course->description) }}</textarea>
                    @error('description')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-midnight">الصف الدراسي</label>
                        <select name="grade" class="w-full rounded-3xl border border-sand bg-sand/60 px-4 py-3 text-right text-midnight outline-none focus:border-midnight" required>
                            <option value="" disabled {{ old('grade', $course->grade) ? '' : 'selected' }}>-- اختر الصف الدراسي --</option>
                            @foreach($grades as $grade)
                            <option value="{{ $grade }}" {{ old('grade', $course->grade) == $grade ? 'selected' : '' }}>
                                {{ $grade }}
                            </option>
                            @endforeach
                        </select>
                        @error('grade')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-midnight">الرسوم الشهرية</label>
                        <input type="number" step="0.01" min="0" name="monthly_fee" value="{{ old('monthly_fee', $course->monthly_fee) }}" class="w-full rounded-3xl border border-sand bg-sand/60 px-4 py-3 text-right text-midnight outline-none focus:border-midnight" required>
                        @error('monthly_fee')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-midnight">عدد الجلسات في الشهر</label>
                        <input type="number" min="1" name="monthly_sessions" value="{{ old('monthly_sessions', $course->monthly_sessions) }}" class="w-full rounded-3xl border border-sand bg-sand/60 px-4 py-3 text-right text-midnight outline-none focus:border-midnight" required>
                        @error('monthly_sessions')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <button type="submit" class="rounded-3xl bg-midnight px-5 py-3 text-sm font-bold text-sand">حفظ التغييرات</button>
                </div>
            </form>
        </div>

        <div class="rounded-3xl bg-white p-8 shadow-xl border border-sand">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-midnight">المجموعات المرتبطة بهذه الدورة</h2>
                    <p class="mt-1 text-sm text-midnight/70">يمكنك إنشاء مجموعة جديدة أو حذف مجموعة مرتبطة.</p>
                </div>
            </div>

            <div class="mt-6 space-y-5">
                @php
                    $currentPageStudentIds = $students->pluck('id')->map(fn($id) => (string)$id)->all();
                    $currentPageTeacherIds = $teachers->pluck('id')->map(fn($id) => (string)$id)->all();
                @endphp

                <!-- نموذج إنشاء مجموعة جديدة مع حفظ الحالة -->
                <form action="{{ route('admin.course.groups.store', $course) }}" method="POST"
                    x-data="{
                        selectedTeacher: '{{ request('selected_teacher', old('teacher_id', '')) }}',
                        selectedStudents: {{ json_encode(array_map('strval', request('selected_students', old('student_ids', [])))) }},
                        teacherSearch: '{{ addslashes($teacherSearch) }}',
                        studentSearch: '{{ addslashes($studentSearch) }}',
                        
                        navigate(extra = {}) {
                            const params = new URLSearchParams(window.location.search);
                            if (this.teacherSearch) params.set('teacher_q', this.teacherSearch);
                            else params.delete('teacher_q');
                            
                            if (this.studentSearch) params.set('student_q', this.studentSearch);
                            else params.delete('student_q');
                            
                            if (this.selectedTeacher) params.set('selected_teacher', this.selectedTeacher);
                            else params.delete('selected_teacher');
                            
                            params.delete('selected_students[]');
                            this.selectedStudents.forEach(id => params.append('selected_students[]', id));
                            
                            for (const [k, v] of Object.entries(extra)) {
                                if (v !== null && v !== undefined) params.set(k, v);
                            }
                            window.location.href = '{{ route('admin.course.edit', $course) }}?' + params.toString();
                        }
                    }"
                    class="rounded-3xl border-2 border-midnight bg-sand p-5 shadow-[6px_6px_0px_0px_#0B132B] sm:p-6">
                    @csrf

                    <!-- حقول مخفية للطلاب المحددين من صفحات أخرى -->
                    <template x-for="id in selectedStudents.filter(i => !{{ json_encode($currentPageStudentIds) }}.includes(String(i)))" :key="id">
                        <input type="hidden" name="student_ids[]" :value="id">
                    </template>

                    <!-- حقل مخفي للمعلم المحدد إذا كان في صفحة أخرى -->
                    <template x-if="selectedTeacher && !{{ json_encode($currentPageTeacherIds) }}.includes(String(selectedTeacher))">
                        <input type="hidden" name="teacher_id" :value="selectedTeacher">
                    </template>

                    <div class="mb-5">
                        <h3 class="text-xl font-bold text-midnight">إنشاء مجموعة جديدة</h3>
                        <p class="mt-1 text-sm text-midnight/70">حدد المعلم والطلاب المرتبطين بهذه المجموعة.</p>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-midnight">اسم المجموعة</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-2xl border border-sand bg-white px-4 py-3 text-right text-midnight outline-none focus:border-midnight" required>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-midnight">الجدول</label>
                            <input type="text" name="schedule" value="{{ old('schedule') }}" class="w-full rounded-2xl border border-sand bg-white px-4 py-3 text-right text-midnight outline-none focus:border-midnight" required>
                        </div>
                        <div class="sm:col-span-2">
                            <div>
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                    <label class="text-sm font-semibold text-midnight">اختر المعلم</label>
                                    <div class="flex w-full gap-2 sm:w-auto">
                                        <input type="search" x-model="teacherSearch" @keydown.enter.prevent="navigate()" placeholder="ابحث باسم المعلم أو البريد الإلكتروني" class="min-w-0 flex-1 rounded-2xl border border-sand bg-white px-4 py-3 text-sm text-midnight outline-none focus:border-midnight sm:w-80">
                                        <button type="button" class="rounded-2xl bg-midnight px-4 py-3 text-xs font-bold text-sand" @click="navigate()">بحث</button>
                                    </div>
                                </div>
                                <div class="mt-3 overflow-x-auto rounded-2xl border-2 border-midnight bg-white">
                                    <table class="w-full min-w-150 border-collapse text-right text-sm text-midnight">
                                        <thead class="bg-midnight text-sand">
                                            <tr>
                                                <th class="border-2 border-midnight p-3 font-bold">اختيار</th>
                                                <th class="border-2 border-midnight p-3 font-bold">اسم المعلم</th>
                                                <th class="border-2 border-midnight p-3 font-bold">البريد الإلكتروني</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($teachers as $teacher)
                                                <tr class="transition hover:bg-amber-50 has-checked:bg-amber-50">
                                                    <td class="border-2 border-midnight p-3 text-center">
                                                        <input type="radio" name="teacher_id" value="{{ $teacher->id }}" x-model="selectedTeacher" class="h-4 w-4 border-sand text-midnight focus:ring-midnight" required>
                                                    </td>
                                                    <td class="border-2 border-midnight p-3 font-bold">{{ $teacher->name }}</td>
                                                    <td class="border-2 border-midnight p-3">{{ $teacher->email }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3">{{ $teachers->appends(['student_q' => $studentSearch, 'selected_teacher' => request('selected_teacher'), 'selected_students' => request('selected_students')])->links() }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="flex items-center justify-between gap-3">
                            <label class="text-sm font-semibold text-midnight">طلاب المجموعة (<span x-text="selectedStudents.length"></span> محددون)</label>
                            <span class="text-xs text-midnight/60">اختر طالباً أو أكثر (يتم حفظ الاختيارات أثناء الترقيم والبحث)</span>
                        </div>
                        <div class="mt-3 flex gap-2">
                            <input type="search" x-model="studentSearch" @keydown.enter.prevent="navigate()" placeholder="ابحث باسم الطالب أو ولي الأمر" class="min-w-0 flex-1 rounded-2xl border border-sand bg-white px-4 py-3 text-sm text-midnight outline-none focus:border-midnight">
                            <button type="button" class="rounded-2xl bg-midnight px-4 py-3 text-xs font-bold text-sand" @click="navigate()">بحث</button>
                        </div>
                        <div class="mt-3 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                            @forelse($students as $student)
                                <label class="flex cursor-pointer items-start gap-3 rounded-2xl border border-sand bg-white p-3 transition hover:border-midnight has-checked:border-midnight has-checked:bg-amber-50">
                                    <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" x-model="selectedStudents" class="mt-1 h-4 w-4 rounded border-sand text-midnight focus:ring-midnight">
                                    <span class="min-w-0">
                                        <span class="block wrap-break-word text-sm font-bold text-midnight">{{ $student->name }}</span>
                                        <span class="mt-1 block wrap-break-word text-xs text-midnight/60">{{ $student->parent?->name ?? 'ولي أمر غير معروف' }}</span>
                                    </span>
                                </label>
                            @empty
                                <p class="text-sm text-midnight/60 sm:col-span-2 lg:col-span-3">لا يوجد طلاب مرتبطون بهذه الدورة بعد.</p>
                            @endforelse
                        </div>
                        <div class="mt-3">{{ $students->appends(['teacher_q' => $teacherSearch, 'selected_teacher' => request('selected_teacher'), 'selected_students' => request('selected_students')])->links() }}</div>
                    </div>
                    <div class="mt-5 flex justify-stretch sm:justify-end">
                        <button type="submit" class="w-full rounded-2xl bg-midnight px-5 py-3 text-sm font-bold text-sand transition hover:bg-terracotta sm:w-auto">إضافة مجموعة</button>
                    </div>
                </form>

                <!-- المجموعات الحالية -->
                <div class="space-y-4">
                    <h3 class="text-xl font-bold text-midnight">المجموعات الحالية</h3>
                    @forelse($course->groups as $group)
                        <div class="rounded-3xl border-2 border-midnight bg-white p-5 shadow-[4px_4px_0px_0px_#0B132B] sm:p-6">
                            <form action="{{ route('admin.course.groups.update', [$course, $group]) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="student_ids_present" value="1">
                                @foreach($group->students as $assignedStudent)
                                    @if(! $students->getCollection()->contains('id', $assignedStudent->id))
                                        <input type="hidden" name="student_ids[]" value="{{ $assignedStudent->id }}">
                                    @endif
                                @endforeach
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="mb-2 block text-xs font-bold text-midnight/70">اسم المجموعة</label>
                                        <input type="text" name="name" value="{{ $group->name }}" class="w-full rounded-2xl border border-sand bg-sand/50 px-4 py-3 text-sm text-midnight outline-none focus:border-midnight" required>
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-xs font-bold text-midnight/70">الجدول</label>
                                        <input type="text" name="schedule" value="{{ $group->schedule }}" class="w-full rounded-2xl border border-sand bg-sand/50 px-4 py-3 text-sm text-midnight outline-none focus:border-midnight" required>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <div x-data="{ teacherSearch: '' }">
                                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                                <label class="text-xs font-bold text-midnight/70">معلم المجموعة</label>
                                                <input type="search" x-model="teacherSearch" placeholder="ابحث باسم المعلم أو البريد الإلكتروني" class="w-full rounded-2xl border border-sand bg-white px-4 py-3 text-sm text-midnight outline-none focus:border-midnight sm:w-80">
                                            </div>
                                            <div class="mt-3 overflow-x-auto rounded-2xl border-2 border-midnight bg-white">
                                                <table class="w-full min-w-150 border-collapse text-right text-sm text-midnight">
                                                    <thead class="bg-midnight text-sand">
                                                        <tr>
                                                            <th class="border-2 border-midnight p-3 font-bold">اختيار</th>
                                                            <th class="border-2 border-midnight p-3 font-bold">اسم المعلم</th>
                                                            <th class="border-2 border-midnight p-3 font-bold">البريد الإلكتروني</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($teachers as $teacher)
                                                            <tr data-search="{{ strtolower($teacher->name . ' ' . $teacher->email) }}" x-show="!teacherSearch || $el.dataset.search.includes(teacherSearch.toLowerCase())" class="transition hover:bg-amber-50 has-checked:bg-amber-50">
                                                                <td class="border-2 border-midnight p-3 text-center">
                                                                    <input type="radio" name="teacher_id" value="{{ $teacher->id }}" {{ (string) $group->teacher_id === (string) $teacher->id ? 'checked' : '' }} class="h-4 w-4 border-sand text-midnight focus:ring-midnight" required>
                                                                </td>
                                                                <td class="border-2 border-midnight p-3 font-bold">{{ $teacher->name }}</td>
                                                                <td class="border-2 border-midnight p-3">{{ $teacher->email }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5 border-t border-sand pt-5">
                                    <div class="flex items-center justify-between gap-3">
                                        <p class="text-sm font-bold text-midnight">طلاب المجموعة <span class="text-midnight/60">({{ $group->students->count() }})</span></p>
                                        <span class="text-xs text-midnight/60">اختر لتحديث القائمة</span>
                                    </div>
                                    <div class="mt-3 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                                        @foreach($students as $student)
                                            <label class="flex cursor-pointer items-start gap-3 rounded-2xl border border-sand bg-sand/40 p-3 transition hover:border-midnight has-checked:border-midnight has-checked:bg-amber-50">
                                                <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" {{ $group->students->contains('id', $student->id) ? 'checked' : '' }} class="mt-1 h-4 w-4 rounded border-sand text-midnight focus:ring-midnight">
                                                <span class="min-w-0 wrap-break-word text-sm font-semibold text-midnight">{{ $student->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:justify-end">
                                    <button type="submit" class="w-full rounded-2xl bg-midnight px-5 py-3 text-sm font-bold text-sand transition hover:bg-terracotta sm:w-auto">حفظ التعديلات</button>
                                </div>
                            </form>
                            <form action="{{ route('admin.course.groups.destroy', [$course, $group]) }}" method="POST" class="mt-3 border-t border-sand pt-3 text-left">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm font-bold text-rose-600 transition hover:text-rose-800" onclick="return confirm('هل تريد حذف هذه المجموعة؟');">حذف المجموعة</button>
                            </form>
                        </div>
                    @empty
                        <div class="rounded-3xl border-2 border-midnight bg-sand p-6 text-center text-sm text-midnight/70">لا توجد مجموعات لهذه الدورة.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="rounded-3xl bg-white p-8 shadow-xl border border-sand">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-midnight">الطلاب المرتبطون بهذه الدورة</h2>
            </div>
            <div class="mt-6 overflow-x-auto border-2 border-midnight bg-sand p-4 shadow-[8px_8px_0px_0px_#0B132B]">
                <table class="w-full min-w-150 border-collapse text-right text-sm text-midnight">
                    <thead class="bg-midnight text-sand">
                        <tr>
                            <th class="border-2 border-midnight p-4 font-bold">الاسم</th>
                            <th class="border-2 border-midnight p-4 font-bold">العمر</th>
                            <th class="border-2 border-midnight p-4 font-bold">ولي الأمر</th>
                            <th class="border-2 border-midnight p-4 font-bold">حالة الدفع</th>
                            <th class="border-2 border-midnight p-4 font-bold">تاريخ آخر دفعة</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-sand/80">
                        @forelse($students as $student)
                        @php
                            $subscription = $student->subscriptions->first();
                            $latestPayment = $subscription?->payments?->sortByDesc('created_at')->first();
                            $isPaid = $latestPayment?->status === 'success';
                        @endphp
                        <tr class="hover:bg-midnight/5 transition-colors">
                            <td class="border-2 border-midnight p-4">{{ $student->name }}</td>
                            <td class="border-2 border-midnight p-4">{{ $student->age }}</td>
                            <td class="border-2 border-midnight p-4">{{ $student->parent?->name ?? 'غير معروف' }}</td>
                            <td class="border-2 border-midnight p-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $isPaid ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    {{ $isPaid ? 'تم الدفع' : 'لم يتم الدفع' }}
                                </span>
                            </td>
                            <td class="border-2 border-midnight p-4">{{ $latestPayment?->created_at?->format('Y-m-d') ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="border-2 border-midnight p-6 text-center text-midnight/70">لا يوجد طلاب مرتبطين بهذه الدورة بعد.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin>