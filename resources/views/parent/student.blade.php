<x-app title="متابعة الطالب {{ $student->name }}">
    <div class="space-y-6 md:space-y-8">
        <!-- الترويسة -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b-4 border-midnight pb-6">
            <div>
                <h2 class="text-3xl md:text-4xl font-heading font-bold text-midnight">متابعة {{ $student->name }}</h2>
                <p class="mt-2 text-sm md:text-base text-midnight/70">عرض تفاصيل الطالب وإدارة الدورات الخاصة به.</p>
            </div>
            <a href="{{ route('parent.dashboard') }}" class="w-full sm:w-auto text-center bg-sand border-2 border-midnight px-5 py-3 font-bold text-midnight hover:bg-midnight hover:text-sand transition rounded-2xl sm:rounded-none">
                عودة إلى الأبناء
            </a>
        </div>

        <!-- رسائل النجاح والخطأ -->
        @if(session('success'))
        <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-800">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="rounded-3xl border border-rose-200 bg-rose-50 p-4 text-sm font-semibold text-rose-800">
            {{ session('error') }}
        </div>
        @endif

        <div class="space-y-6">
            <!-- معلومات الطالب الأساسية -->
            <div class="rounded-3xl bg-white p-5 md:p-6 shadow-xl border border-sand">
                <h3 class="text-xl md:text-2xl font-bold text-midnight mb-4">معلومات الطالب</h3>
                <div class="grid gap-3 grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-2xl bg-sand/60 p-4 flex flex-col justify-center">
                        <span class="text-xs md:text-sm text-midnight/70">الاسم</span>
                        <span class="mt-1 font-bold text-midnight text-sm md:text-base truncate" title="{{ $student->name }}">{{ $student->name }}</span>
                    </div>
                    <div class="rounded-2xl bg-sand/60 p-4 flex flex-col justify-center">
                        <span class="text-xs md:text-sm text-midnight/70">السنة الدراسية</span>
                        <span class="mt-1 font-bold text-midnight text-sm md:text-base truncate">{{ $student->academic_year ?? 'غير محددة' }}</span>
                    </div>
                    <div class="rounded-2xl bg-sand/60 p-4 flex flex-col justify-center">
                        <span class="text-xs md:text-sm text-midnight/70">المدرسة</span>
                        <span class="mt-1 font-bold text-midnight text-sm md:text-base truncate" title="{{ $student->school }}">{{ $student->school ?? 'غير محددة' }}</span>
                    </div>
                    <div class="rounded-2xl bg-sand/60 p-4 flex flex-col justify-center">
                        <span class="text-xs md:text-sm text-midnight/70">العمر</span>
                        <span class="mt-1 font-bold text-midnight text-sm md:text-base">{{ $student->age ?? 'غير محدد' }}</span>
                    </div>
                </div>
            </div>

            <!-- إضافة دورة جديدة (بطاقات مباشرة بدون dropdown) -->
            <div class="rounded-3xl bg-white p-5 md:p-6 shadow-xl border border-sand">
                <div class="mb-5">
                    <h3 class="text-xl md:text-2xl font-bold text-midnight">إضافة دورة جديدة</h3>
                    <p class="mt-1 text-xs md:text-sm text-midnight/70">الدورات المتاحة للمرحلة الدراسية الخاصة بالطالب.</p>
                </div>

                @php
                $availableCourses = \App\Models\Course::where('grade', $student->academic_year)
                ->whereNotIn('id', $student->courses->pluck('id'))
                ->get();
                @endphp

                @if($availableCourses->isEmpty())
                <div class="rounded-2xl bg-sand/50 p-4 text-midnight/70 text-sm leading-relaxed text-center font-medium">
                    لا توجد دورات أخرى متاحة للإضافة في هذه المرحلة الدراسية، أو أن الطالب مسجل في جميع الدورات بالفعل.
                </div>
                @else
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($availableCourses as $c)
                    <div class="rounded-2xl border border-sand bg-sand/30 p-4 flex flex-col justify-between hover:border-midnight/40 transition">
                        <div>
                            <h4 class="font-bold text-midnight text-base md:text-lg break-words">{{ $c->name }}</h4>
                            <div class="mt-2 inline-flex items-center gap-1.5 text-xs md:text-sm text-midnight/80 font-semibold bg-white px-3 py-1 rounded-xl border border-sand">
                                <span>التكلفة:</span>
                                <span class="text-midnight font-bold">{{ number_format($c->monthly_fee, 2) }} د.إ</span>
                            </div>
                        </div>

                        <form action="{{ route('parent.student.course.add', $student) }}" method="POST" class="mt-4 pt-3 border-t border-sand/60">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $c->id }}">
                            <button type="submit" class="w-full rounded-xl bg-midnight py-2.5 px-4 text-xs md:text-sm font-bold text-sand hover:bg-amber-600 transition flex justify-center items-center gap-2">
                                <span>إضافة الدورة</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- دورات الطالب الحالية -->
            <div class="rounded-3xl bg-white p-5 md:p-6 shadow-xl border border-sand">
                <div class="mb-6">
                    <h3 class="text-xl md:text-2xl font-bold text-midnight">دورات الطالب الحالية</h3>
                    <p class="mt-1 text-xs md:text-sm text-midnight/70">الدورات التي تم تسجيل الطالب بها بالفعل.</p>
                </div>

                @if($student->courses->isEmpty())
                <div class="rounded-2xl border border-midnight/10 bg-sand/50 p-6 text-center text-midnight/70 font-semibold text-sm md:text-base">
                    لا توجد دورات مسجلة لهذا الطالب حتى الآن.
                </div>
                @else
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($student->courses as $course)
                    <div class="rounded-2xl border border-sand bg-white shadow-sm hover:shadow-md transition p-5 flex flex-col justify-between h-full">
                        <div>
                            <h4 class="text-lg md:text-xl font-bold text-midnight break-words">{{ $course->name }}</h4>
                        </div>

                        <div class="mt-6 space-y-3 pt-4 border-t border-sand/40">
                            <div class="flex items-center justify-center w-full rounded-xl bg-sand/60 px-4 py-2.5 text-xs md:text-sm font-bold text-midnight text-center">
                                التكلفة: {{ number_format($course->monthly_fee, 2) }} د.إ
                            </div>

                            <!-- زر الحذف -->
                            <form action="{{ route('parent.student.course.remove', [$student, $course]) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من رغبتك في إزالة هذه الدورة من سجل الطالب؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full flex justify-center items-center rounded-xl border border-rose-500 bg-white text-rose-600 px-4 py-2 text-xs md:text-sm font-bold hover:bg-rose-500 hover:text-white transition">
                                    إزالة الدورة
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app>