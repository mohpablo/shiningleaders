<x-guest>
    <x-slot name="title">إنشاء حساب جديد | أكاديمية Shining Leaders</x-slot>

    <!-- Title Header -->
    <div class="mb-6 text-center">
        <h1 class="text-3xl font-heading font-bold text-midnight mb-2">حساب جديد</h1>
        <p class="text-sm font-medium text-midnight/70">انضم إلى عائلة Shining Leaders اليوم</p>
    </div>

    <!-- novalidate لتسليم الفحص للارافيل وإظهار الأخطاء المصممة -->
    <form method="POST" action="{{ route('register') }}" novalidate class="space-y-4">
        @csrf

        <!-- Registered By Select -->
        <div>
            <x-input-label for="registered_by" value="من يقوم بالتسجيل؟" />
            <select id="registered_by" name="registered_by" onchange="toggleRegistrationFields(this.value)"
                class="w-full border-2 border-midnight bg-white p-2.5 text-sm font-bold text-midnight focus:border-terracotta focus:ring-0">
                <option value="father" {{ old('registered_by', 'father') === 'father' ? 'selected' : '' }}>الأب</option>
                <option value="mother" {{ old('registered_by', 'father') === 'mother' ? 'selected' : '' }}>الأم</option>
            </select>
            <x-input-error :messages="$errors->get('registered_by')" />
        </div>

        <!-- Full Name (Account Owner) -->
        <div>
            <x-input-label for="name" id="name_label" :value="old('registered_by', 'father') === 'father' ? 'اسم الأب الكامل' : 'اسم الأم الكامل'" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" autofocus autocomplete="name" placeholder="أدخل اسمك الكامل" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="البريد الإلكتروني" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" autocomplete="username" placeholder="example@domain.com" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Primary Mobile Number -->
        <div>
            <x-input-label for="mobile" value="رقم الهاتف / الواتساب" />
            <x-text-input id="mobile" type="text" name="mobile" :value="old('mobile')" placeholder="01012345678" />
            <x-input-error :messages="$errors->get('mobile')" />
        </div>

        <!-- Father Information Section -->
        <div class="p-4 border-2 border-midnight bg-sand/40 space-y-3">
            <h3 class="font-bold text-midnight text-sm border-b border-midnight/20 pb-1">بيانات الأب</h3>

            <!-- Father Name & Mobile (Shown ONLY when Mother registers) -->
            <div id="father_extra_fields" class="space-y-3" style="{{ old('registered_by', 'father') === 'mother' ? '' : 'display: none;' }}">
                <div>
                    <x-input-label for="father_name" value="اسم الأب الكامل" />
                    <x-text-input id="father_name" type="text" name="father_name" :value="old('father_name')" placeholder="اسم الأب" />
                    <x-input-error :messages="$errors->get('father_name')" />
                </div>
                <div>
                    <x-input-label for="father_mobile" value="رقم هاتف الأب" />
                    <x-text-input id="father_mobile" type="text" name="father_mobile" :value="old('father_mobile')" placeholder="010xxxxxxxx" />
                    <x-input-error :messages="$errors->get('father_mobile')" />
                </div>
            </div>

            <div>
                <x-input-label for="father_job" value="وظيفة الأب" />
                <x-text-input id="father_job" type="text" name="father_job" :value="old('father_job')" placeholder="مهندس / طبيب / معلم..." />
                <x-input-error :messages="$errors->get('father_job')" />
            </div>
        </div>

        <!-- Mother Information Section -->
        <div class="p-4 border-2 border-midnight bg-sand/40 space-y-3">
            <h3 class="font-bold text-midnight text-sm border-b border-midnight/20 pb-1">بيانات الأم</h3>

            <!-- Mother Name & Mobile (Shown ONLY when Father registers) -->
            <div id="mother_extra_fields" class="space-y-3" style="{{ old('registered_by', 'father') === 'father' ? '' : 'display: none;' }}">
                <div>
                    <x-input-label for="mother_name" value="اسم الأم الكامل" />
                    <x-text-input id="mother_name" type="text" name="mother_name" :value="old('mother_name')" placeholder="اسم الأم" />
                    <x-input-error :messages="$errors->get('mother_name')" />
                </div>
                <div>
                    <x-input-label for="mother_mobile" value="رقم هاتف الأم" />
                    <x-text-input id="mother_mobile" type="text" name="mother_mobile" :value="old('mother_mobile')" placeholder="010xxxxxxxx" />
                    <x-input-error :messages="$errors->get('mother_mobile')" />
                </div>
            </div>

            <div>
                <x-input-label for="mother_job" value="وظيفة الأم" />
                <x-text-input id="mother_job" type="text" name="mother_job" :value="old('mother_job')" placeholder="ربّة منزل / معلّمة..." />
                <x-input-error :messages="$errors->get('mother_job')" />
            </div>
        </div>

        <!-- Address -->
        <div>
            <x-input-label for="address" value="العنوان السكني التفصيلي" />
            <x-text-input id="address" type="text" name="address" :value="old('address')" placeholder="المدينة، المنطقة، الشارع" />
            <x-input-error :messages="$errors->get('address')" />
        </div>

        <!-- Ideal Community Opinion -->
        <div>
            <x-input-label for="ideal_community_opinion" value="رأيك في المجتمع المثالي للطفل (اختياري)" />
            <textarea id="ideal_community_opinion" name="ideal_community_opinion" rows="3"
                class="w-full border-2 border-midnight bg-white p-2.5 text-sm font-medium text-midnight focus:border-terracotta focus:ring-0"
                placeholder="اكتب وجهة نظرك في المهارات والقيم التي تتمنى رؤيتها في طفلك...">{{ old('ideal_community_opinion') }}</textarea>
            <x-input-error :messages="$errors->get('ideal_community_opinion')" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" value="كلمة المرور" />
            <x-text-input id="password" type="password" name="password" autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" value="تأكيد كلمة المرور" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <x-primary-button class="w-full justify-center">
                إنشاء الحساب الان
            </x-primary-button>
        </div>
    </form>

    <!-- Login Link -->
    <div class="mt-6 pt-6 border-t-2 border-midnight text-center">
        <p class="text-xs font-bold text-midnight">
            لديك حساب بالفعل؟
            <a href="{{ route('login') }}" class="text-terracotta underline font-extrabold hover:text-amber-700">
                تسجيل الدخول
            </a>
        </p>
    </div>

    <!-- Vanilla JS Script to bypass any Alpine configuration glitches -->
    <script>
        function toggleRegistrationFields(role) {
            const nameLabel = document.getElementById('name_label');
            const fatherExtraFields = document.getElementById('father_extra_fields');
            const motherExtraFields = document.getElementById('mother_extra_fields');

            if (role === 'father') {
                nameLabel.innerText = 'اسم الأب الكامل';
                fatherExtraFields.style.display = 'none';
                motherExtraFields.style.display = 'block';
            } else {
                nameLabel.innerText = 'اسم الأم الكامل';
                fatherExtraFields.style.display = 'block';
                motherExtraFields.style.display = 'none';
            }
        }
    </script>
</x-guest>