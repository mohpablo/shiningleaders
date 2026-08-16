<x-app title="إضافة ابن جديد">
    <div class="max-w-2xl mx-auto space-y-8">
        <!-- Header -->
        <div class="border-b-4 border-midnight pb-4">
            <h2 class="text-3xl font-heading font-bold">إضافة طالب/ابن جديد</h2>
            <p class="text-terracotta font-bold mt-1">الرجاء إدخال بيانات الطالب بدقة</p>
        </div>

        <!-- Form Card -->
        <div class="bg-sand border-2 border-midnight p-8 shadow-[8px_8px_0px_0px_#0B132B]">
            <form action="{{ route('parent.add-student') }}" method="POST" class="space-y-6">
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
                        <label for="academic_year" class="block font-bold mb-2">السنة الدراسية</label>
                        <input type="text" id="academic_year" name="academic_year" value="{{ old('academic_year') }}"
                            class="w-full bg-sand border-2 border-midnight p-3 focus:outline-none focus:ring-2 focus:ring-terracotta font-medium">
                        @error('academic_year')
                        <span class="text-terracotta text-sm font-bold mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Courses Selection Checkboxes -->
                <div>
                    <label class="block font-bold mb-3">الكورسات المراد التسجيل بها</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($courses as $course)
                        <label class="flex items-center space-x-3 space-x-reverse bg-sand border-2 border-midnight p-3 cursor-pointer hover:bg-midnight/5 transition">
                            <input type="checkbox"
                                name="courses[]"
                                value="{{ $course->id }}"
                                {{ is_array(old('courses')) && in_array($course->id, old('courses')) ? 'checked' : '' }}
                                class="w-5 h-5 text-midnight border-2 border-midnight focus:ring-terracotta">
                            <span class="font-bold text-midnight">{{ $course->name }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('courses')
                    <span class="text-terracotta text-sm font-bold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end gap-4 pt-4 border-t-2 border-midnight">
                    <a href="{{ route('parent.dashboard') }}"
                        class="px-6 py-3 font-bold border-2 border-midnight hover:bg-midnight/10 transition">
                        إلغاء
                    </a>
                    <button type="submit"
                        class="bg-midnight text-sand px-8 py-3 font-bold border-2 border-midnight shadow-[4px_4px_0px_0px_#D97706] hover:bg-terracotta hover:text-white transition-all">
                        حفظ البيانات
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app>