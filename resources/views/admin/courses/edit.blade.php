<x-admin>
    <div class="space-y-6">
        <div class="rounded-3xl bg-white p-8 shadow-xl border border-sand">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-midnight">تحرير الدورة</h1>
                    <p class="mt-2 text-sm text-midnight/70">يمكنك تحديث اسم الدورة، المعلم، والرسوم الشهرية هنا.</p>
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
                        <label class="mb-2 block text-sm font-semibold text-midnight">الرسوم الشهرية</label>
                        <input type="number" step="0.01" min="0" name="monthly_fee" value="{{ old('monthly_fee', $course->monthly_fee) }}" class="w-full rounded-3xl border border-sand bg-sand/60 px-4 py-3 text-right text-midnight outline-none focus:border-midnight" required>
                        @error('monthly_fee')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-midnight">عدد الجلسات في الشهر</label>
                        <input type="number" min="1" name="monthly_sessions" value="{{ old('monthly_sessions', $course->monthly_sessions) }}" class="w-full rounded-3xl border border-sand bg-sand/60 px-4 py-3 text-right text-midnight outline-none focus:border-midnight" required>
                        @error('monthly_sessions')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-midnight">المعلم</label>
                        <select name="teacher_id" class="w-full rounded-3xl border border-sand bg-sand/60 px-4 py-3 text-right text-midnight outline-none focus:border-midnight">
                            <option value="">بدون معلم</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('teacher_id', $course->teacher_id) == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                        @error('teacher_id')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
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

            <div class="mt-6 space-y-4">
                <form action="{{ route('admin.course.groups.store', $course) }}" method="POST" class="rounded-3xl border border-sand bg-sand/60 p-6">
                    @csrf

                    <div class="grid gap-4 md:grid-cols-3">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-midnight">اسم المجموعة</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-3xl border border-sand bg-white px-4 py-3 text-right text-midnight outline-none focus:border-midnight" required>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-midnight">الجدول</label>
                            <input type="text" name="schedule" value="{{ old('schedule') }}" class="w-full rounded-3xl border border-sand bg-white px-4 py-3 text-right text-midnight outline-none focus:border-midnight" required>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-midnight">السعة</label>
                            <input type="number" min="1" name="capacity" value="{{ old('capacity') }}" class="w-full rounded-3xl border border-sand bg-white px-4 py-3 text-right text-midnight outline-none focus:border-midnight">
                        </div>
                    </div>

                    <div class="mt-4 text-left">
                        <button type="submit" class="inline-flex items-center rounded-3xl bg-midnight px-5 py-3 text-sm font-bold text-sand">إضافة مجموعة</button>
                    </div>
                </form>

                <div class="overflow-hidden rounded-3xl border border-sand bg-white shadow-sm">
                    <table class="min-w-full text-right text-sm text-midnight">
                        <thead class="bg-sand text-midnight/80">
                            <tr>
                                <th class="px-4 py-4">اسم المجموعة</th>
                                <th class="px-4 py-4">الجدول</th>
                                <th class="px-4 py-4">السعة</th>
                                <th class="px-4 py-4">إجراء</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-sand/80">
                            @forelse($course->groups as $group)
                                <tr>
                                    <td class="px-4 py-4">{{ $group->name }}</td>
                                    <td class="px-4 py-4">{{ $group->schedule }}</td>
                                    <td class="px-4 py-4">{{ $group->capacity ?? 'غير محددة' }}</td>
                                    <td class="px-4 py-4 text-left">
                                        <form action="{{ route('admin.course.groups.destroy', [$course, $group]) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center rounded-full bg-rose-500 px-4 py-2 text-xs font-bold text-white transition hover:bg-rose-600" onclick="return confirm('هل تريد حذف هذه المجموعة؟');">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-midnight/70">لا توجد مجموعات لهذه الدورة.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="rounded-3xl bg-white p-8 shadow-xl border border-sand">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-midnight">الطلاب المرتبطون بهذه الدورة</h2>
            </div>
            <div class="mt-6 overflow-hidden rounded-3xl border border-sand bg-sand/60">
                <table class="min-w-full text-right text-sm text-midnight">
                    <thead class="bg-sand text-midnight/80">
                        <tr>
                            <th class="px-4 py-4">الاسم</th>
                            <th class="px-4 py-4">العمر</th>
                            <th class="px-4 py-4">المعلم</th>
                            <th class="px-4 py-4">ولي الأمر</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-sand/80">
                        @forelse($students as $student)
                            <tr>
                                <td class="px-4 py-4">{{ $student->name }}</td>
                                <td class="px-4 py-4">{{ $student->age }}</td>
                                <td class="px-4 py-4">{{ $course->teacher?->name ?? 'غير محدد' }}</td>
                                <td class="px-4 py-4">{{ $student->parent?->name ?? 'غير معروف' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-midnight/70">لا يوجد طلاب مرتبطين بهذه الدورة بعد.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin>
