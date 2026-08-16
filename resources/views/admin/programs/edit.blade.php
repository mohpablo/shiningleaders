<x-admin>
    <div class="max-w-3xl space-y-6 rounded-3xl bg-white p-8 shadow-xl border border-sand">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-midnight">تعديل بيانات المدرس</h1>
                <p class="mt-2 text-sm text-midnight/70">حدّث اسم المدرس، البريد الإلكتروني، أو نسبة الأرباح.</p>
            </div>
            <a href="{{ route('admin.programs.index') }}" class="inline-flex items-center justify-center rounded-3xl bg-sand px-5 py-3 text-sm font-bold text-midnight transition hover:bg-amber-100">عودة إلى المدرسين</a>
        </div>

        @if(session('success'))
            <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.programs.update', $teacher) }}" method="POST" class="mt-6 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="mb-2 block text-sm font-semibold text-midnight">الاسم</label>
                <input type="text" name="name" value="{{ old('name', $teacher->name) }}" class="w-full rounded-3xl border border-sand bg-sand/60 px-4 py-3 text-right text-midnight outline-none focus:border-midnight" required>
                @error('name')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-midnight">البريد الإلكتروني</label>
                <input type="email" name="email" value="{{ old('email', $teacher->email) }}" class="w-full rounded-3xl border border-sand bg-sand/60 px-4 py-3 text-right text-midnight outline-none focus:border-midnight" required>
                @error('email')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-midnight">كلمة المرور الجديدة</label>
                <input type="password" name="password" class="w-full rounded-3xl border border-sand bg-sand/60 px-4 py-3 text-right text-midnight outline-none focus:border-midnight">
                <p class="mt-2 text-sm text-midnight/70">اترك هذا الحقل فارغًا إن لم ترغب بتغيير كلمة المرور.</p>
                @error('password')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-midnight">نسبة المدرس من الدخل</label>
                <input type="number" name="teacher_share" min="0" max="100" value="{{ old('teacher_share', $teacher->teacher_share) }}" class="w-full rounded-3xl border border-sand bg-sand/60 px-4 py-3 text-right text-midnight outline-none focus:border-midnight" required>
                @error('teacher_share')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.programs.index') }}" class="rounded-3xl border border-midnight px-5 py-3 text-sm font-bold text-midnight">إلغاء</a>
                <button type="submit" class="rounded-3xl bg-midnight px-5 py-3 text-sm font-bold text-sand">حفظ التغييرات</button>
            </div>
        </form>
    </div>
</x-admin>
