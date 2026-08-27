<x-admin>
    <div class="max-w-3xl space-y-6 rounded-3xl bg-white p-8 shadow-xl border border-sand">
        <div>
            <h1 class="text-3xl font-bold text-midnight">إنشاء دورة جديدة</h1>
            <p class="mt-2 text-sm text-midnight/70">حدد اسم الدورة والرسوم الشهرية. يتم اختيار المعلم عند إنشاء المجموعة.</p>
        </div>

        <form action="{{ route('admin.course.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="mb-2 block text-sm font-semibold text-midnight">اسم الدورة</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-3xl border border-sand bg-sand/60 px-4 py-3 text-right text-midnight outline-none focus:border-midnight" required>
                @error('name')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-midnight">الوصف</label>
                <textarea name="description" rows="4" class="w-full rounded-3xl border border-sand bg-sand/60 px-4 py-3 text-right text-midnight outline-none focus:border-midnight">{{ old('description') }}</textarea>
                @error('description')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <!-- Grade Selection -->
                <div>
                    <label class="mb-2 block text-sm font-semibold text-midnight">الصف الدراسي</label>
                    <select name="grade" class="w-full rounded-3xl border border-sand bg-sand/60 px-4 py-3 text-right text-midnight outline-none focus:border-midnight" required>
                        <option value="" disabled {{ old('grade') ? '' : 'selected' }}>-- اختر الصف الدراسي --</option>
                        @foreach($grades as $grade)
                        <option value="{{ $grade }}" {{ old('grade') == $grade ? 'selected' : '' }}>{{ $grade }}</option>
                        @endforeach
                    </select>
                    @error('grade')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-midnight">الرسوم الشهرية</label>
                    <input type="number" step="0.01" min="0" name="monthly_fee" value="{{ old('monthly_fee') }}" class="w-full rounded-3xl border border-sand bg-sand/60 px-4 py-3 text-right text-midnight outline-none focus:border-midnight" required>
                    @error('monthly_fee')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-midnight">عدد الجلسات في الشهر</label>
                    <input type="number" min="1" name="monthly_sessions" value="{{ old('monthly_sessions', 8) }}" class="w-full rounded-3xl border border-sand bg-sand/60 px-4 py-3 text-right text-midnight outline-none focus:border-midnight" required>
                    @error('monthly_sessions')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.course') }}" class="rounded-3xl border border-midnight px-5 py-3 text-sm font-bold text-midnight">إلغاء</a>
                <button type="submit" class="rounded-3xl bg-midnight px-5 py-3 text-sm font-bold text-sand">حفظ الدورة</button>
            </div>
        </form>
    </div>
</x-admin>