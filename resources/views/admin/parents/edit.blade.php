<x-admin>
    <div class="space-y-6">
        <div class="rounded-3xl bg-white p-8 shadow-xl border border-sand/60">
            <!-- الهيدر والإنفوجرافيك العلوية -->
            <div class="flex flex-col gap-4 border-b border-sand pb-6 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-midnight text-sand shadow-md">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black text-midnight sm:text-3xl">تغيير كلمة المرور</h1>
                        <p class="mt-1 text-sm font-medium text-midnight/70">
                            تحديث بيانات الأمان لولي الأمر: <span class="font-bold text-midnight underline decoration-terracotta decoration-2 underline-offset-4">{{ $parent->name }}</span>
                        </p>
                    </div>
                </div>

                <a href="{{ route('admin.parents.index') }}" class="inline-flex items-center justify-center gap-2 rounded-full border-2 border-midnight bg-white px-5 py-2.5 text-sm font-bold text-midnight transition hover:bg-midnight hover:text-sand">
                    <svg class="h-4 w-4 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                    إلغاء والعودة
                </a>
            </div>

            <!-- عرض الأخطاء -->
            @if($errors->any())
                <div class="mt-6 rounded-2xl border border-rose-200 bg-rose-50/80 p-4 text-sm text-rose-800 backdrop-blur-sm">
                    <div class="flex items-center gap-2 font-bold mb-2 text-rose-900">
                        <svg class="h-5 w-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        يرجى تصحيح الأخطاء التالية:
                    </div>
                    <ul class="list-disc list-inside space-y-1 pr-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- النموذج -->
            <form method="POST" action="{{ route('admin.parents.update', $parent) }}" class="mt-6 space-y-5 max-w-xl">
                @csrf
                @method('PUT')

                <div>
                    <label for="password" class="block text-sm font-bold text-midnight mb-2">
                        كلمة المرور الجديدة
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required placeholder="••••••••" class="w-full rounded-xl border-2 border-midnight/80 bg-white px-4 py-3 text-right text-midnight outline-none transition focus:border-midnight focus:bg-sand/30 focus:ring-2 focus:ring-midnight/20">
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-midnight mb-2">
                        تأكيد كلمة المرور الجديدة
                    </label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="••••••••" class="w-full rounded-xl border-2 border-midnight/80 bg-white px-4 py-3 text-right text-midnight outline-none transition focus:border-midnight focus:bg-sand/30 focus:ring-2 focus:ring-midnight/20">
                    </div>
                </div>

                <!-- شريط الإجراءات (Action Bar) -->
                <div class="pt-6 border-t border-sand/80 flex items-center gap-3">
                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-midnight px-7 py-3 text-sm font-bold text-sand shadow-lg transition hover:bg-terracotta hover:shadow-xl focus:ring-2 focus:ring-midnight/50">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        حفظ التغييرات
                    </button>
                    
                    <a href="{{ route('admin.parents.index') }}" class="rounded-xl px-5 py-3 text-sm font-bold text-midnight/70 transition hover:bg-sand/50 hover:text-midnight">
                        إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-admin>