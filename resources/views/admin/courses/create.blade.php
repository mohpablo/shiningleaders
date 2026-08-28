<x-admin>
    <div class="w-full max-w-3xl space-y-6 rounded-3xl border-2 border-midnight bg-white p-5 shadow-[8px_8px_0px_0px_#0B132B] sm:p-8">
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

            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
                <a href="{{ route('admin.course') }}" class="w-full rounded-3xl border border-midnight px-5 py-3 text-center text-sm font-bold text-midnight sm:w-auto">إلغاء</a>
                <button type="submit" class="w-full rounded-3xl bg-midnight px-5 py-3 text-sm font-bold text-sand sm:w-auto">حفظ الدورة</button>
            </div>
        </form>
    </div>
</x-admin>