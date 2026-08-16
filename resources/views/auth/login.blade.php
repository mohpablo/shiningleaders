<x-guest>
    <x-slot name="title">تسجيل الدخول | أكاديمية Shining Leaders</x-slot>

    <!-- Title Header -->
    <div class="mb-6 text-center">
        <h1 class="text-3xl font-heading font-bold text-midnight mb-2">تسجيل الدخول</h1>
        <p class="text-sm font-medium text-midnight/70">مرحباً بك مجدداً في مجتمع الأكاديمية</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
    <div class="mb-4 p-3 bg-emerald-100 border-2 border-midnight font-bold text-xs text-forest">
        {{ session('status') }}
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="البريد الإلكتروني" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="example@domain.com" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1">
                <x-input-label for="password" value="كلمة المرور" />
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-xs font-bold text-terracotta hover:underline">
                    نسيت كلمة المرور؟
                </a>
                @endif
            </div>
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                <x-checkbox id="remember_me" name="remember" />
                <span class="text-xs font-bold text-midnight">تذكر بياناتي</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <x-primary-button>
                تسجيل الدخول
            </x-primary-button>
        </div>
    </form>

    <!-- Register Link -->
    <div class="mt-6 pt-6 border-t-2 border-midnight text-center">
        <p class="text-xs font-bold text-midnight">
            ليس لديك حساب بعد؟
            <a href="{{ route('register') }}" class="text-terracotta underline font-extrabold hover:text-amber-700">
                إنشاء حساب جديد
            </a>
        </p>
    </div>
</x-guest>