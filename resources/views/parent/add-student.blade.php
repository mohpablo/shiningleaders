<x-app title="إضافة ابن جديد - الخطوة 1">
    <div class="max-w-2xl mx-auto space-y-8">
        <!-- Header -->
        <div class="border-b-4 border-midnight pb-4">
            <h2 class="text-3xl font-heading font-bold">إضافة طالب/ابن جديد (الخطوة 1 من 2)</h2>
            <p class="text-terracotta font-bold mt-1">الرجاء إدخال البيانات الأساسية للطالب</p>
        </div>

        <!-- Form Card -->
        <div class="bg-sand border-2 border-midnight p-8 shadow-[8px_8px_0px_0px_#0B132B]">
            <form action="{{ route('store-student') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block font-bold mb-2">اسم الطالب</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="w-full bg-sand border-2 border-midnight p-3 focus:outline-none focus:ring-2 focus:ring-terracotta font-medium">
                    @error('name')
                    <span class="text-terracotta text-sm font-bold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Age & Phone Number Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="age" class="block font-bold mb-2">العمر</label>
                        <input type="number" id="age" name="age" value="{{ old('age') }}" required
                            class="w-full bg-sand border-2 border-midnight p-3 focus:outline-none focus:ring-2 focus:ring-terracotta font-medium">
                        @error('age')
                        <span class="text-terracotta text-sm font-bold mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="phone_number" class="block font-bold mb-2">رقم الهاتف</label>
                        <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                            class="w-full bg-sand border-2 border-midnight p-3 focus:outline-none focus:ring-2 focus:ring-terracotta font-medium">
                        @error('phone_number')
                        <span class="text-terracotta text-sm font-bold mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- School & Academic Year Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="school" class="block font-bold mb-2">المدرسة</label>
                        <input type="text" id="school" name="school" value="{{ old('school') }}"
                            class="w-full bg-sand border-2 border-midnight p-3 focus:outline-none focus:ring-2 focus:ring-terracotta font-medium">
                        @error('school')
                        <span class="text-terracotta text-sm font-bold mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="academic_year" class="block font-bold mb-2">السنة الدراسية (الصف)</label>
                        <select id="academic_year" name="academic_year" required
                            class="w-full bg-sand border-2 border-midnight p-3 focus:outline-none focus:ring-2 focus:ring-terracotta font-medium">
                            <option value="" disabled {{ old('academic_year') ? '' : 'selected' }}>-- اختر السنة الدراسية --</option>
                            @foreach($academicYears as $year)
                            <option value="{{ $year }}" {{ old('academic_year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                            @endforeach
                        </select>
                        @error('academic_year')
                        <span class="text-terracotta text-sm font-bold mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end gap-4 pt-4 border-t-2 border-midnight">
                    <a href="{{ route('parent.dashboard') }}"
                        class="px-6 py-3 font-bold border-2 border-midnight hover:bg-midnight/10 transition">
                        إلغاء
                    </a>
                    <button type="submit"
                        class="bg-midnight text-sand px-8 py-3 font-bold border-2 border-midnight shadow-[4px_4px_0px_0px_#D97706] hover:bg-terracotta hover:text-white transition-all">
                        التالي: اختيار الكورسات ←
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app>