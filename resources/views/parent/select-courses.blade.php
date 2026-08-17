<x-app title="اختيار الكورسات">
    <div class="max-w-2xl mx-auto space-y-8">
        <!-- Header -->
        <div class="border-b-4 border-midnight pb-4">
            <h2 class="text-3xl font-heading font-bold">اختيار الكورسات (الخطوة 2 من 2)</h2>
            <p class="text-midnight font-bold mt-1">
                الطالب: <span class="text-terracotta">{{ $student->name }}</span> |
                الصف: <span class="text-terracotta">{{ $student->academic_year }}</span>
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-sand border-2 border-midnight p-8 shadow-[8px_8px_0px_0px_#0B132B]">
            <form action="{{ route('store-courses', $student->id) }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block font-bold text-xl border-b-2 border-midnight pb-2 mb-4">
                        الكورسات المراد التسجيل بها
                    </label>

                    @if($courses->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($courses as $course)
                        <label class="flex items-center space-x-3 space-x-reverse bg-sand border-2 border-midnight p-4 cursor-pointer hover:bg-midnight/5 transition">
                            <input type="checkbox"
                                name="courses[]"
                                value="{{ $course->id }}"
                                class="w-5 h-5 text-midnight border-2 border-midnight focus:ring-terracotta">
                            <span class="font-bold text-midnight text-lg">{{ $course->name }}</span>
                        </label>
                        @endforeach
                    </div>
                    @else
                    <div class="p-4 bg-terracotta/10 border-2 border-terracotta text-terracotta font-bold">
                        لا توجد كورسات متاحة حالياً للصف ({{ $student->academic_year }}). يمكنك المتابعة بدون اختيار كورسات.
                    </div>
                    @endif

                    @error('courses')
                    <span class="text-terracotta text-sm font-bold mt-2 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between pt-6 border-t-2 border-midnight">
                    <span class="text-sm font-bold text-gray-600">يمكنك المتابعة أو الحفظ دون تحديد كورس.</span>

                    <button type="submit"
                        class="bg-midnight text-sand px-8 py-3 font-bold border-2 border-midnight shadow-[4px_4px_0px_0px_#D97706] hover:bg-terracotta hover:text-white transition-all">
                        حفظ البيانات وإتمام التسجيل
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app>