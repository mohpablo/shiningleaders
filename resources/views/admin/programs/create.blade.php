<x-admin>
    <div class="w-full max-w-3xl space-y-6 rounded-3xl border-2 border-midnight bg-white p-5 shadow-[8px_8px_0px_0px_#0B132B] sm:p-8">
        <div>
            <h1 class="text-3xl font-bold text-midnight">إنشاء مدرس جديد</h1>
            <p class="mt-2 text-sm text-midnight/70">أضف معلومات المدرس ونسبة أرباحه من الدورات.</p>
        </div>

        <form action="{{ route('admin.programs.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="mb-2 block text-sm font-semibold text-midnight">الاسم</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-3xl border border-sand bg-sand/60 px-4 py-3 text-right text-midnight outline-none focus:border-midnight" required>
                @error('name')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-midnight">البريد الإلكتروني</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-3xl border border-sand bg-sand/60 px-4 py-3 text-right text-midnight outline-none focus:border-midnight" required>
                @error('email')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-midnight">كلمة المرور</label>
                <input type="password" name="password" class="w-full rounded-3xl border border-sand bg-sand/60 px-4 py-3 text-right text-midnight outline-none focus:border-midnight" required>
                @error('password')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-midnight">نسبة المدرس من الدخل</label>
                <input type="number" name="teacher_share" min="0" max="100" value="{{ old('teacher_share', 30) }}" class="w-full rounded-3xl border border-sand bg-sand/60 px-4 py-3 text-right text-midnight outline-none focus:border-midnight" required>
                @error('teacher_share')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
                <a href="{{ route('admin.programs.index') }}" class="w-full rounded-3xl border border-midnight px-5 py-3 text-center text-sm font-bold text-midnight sm:w-auto">إلغاء</a>
                <button type="submit" class="w-full rounded-3xl bg-midnight px-5 py-3 text-sm font-bold text-sand sm:w-auto">إنشاء المدرس</button>
            </div>
        </form>
    </div>
</x-admin>
