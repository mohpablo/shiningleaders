<x-app title="متابعة الطالب {{ $student->name }}">
    <div class="space-y-8">
        <div class="flex items-center justify-between border-b-4 border-midnight pb-6">
            <div>
                <h2 class="text-4xl font-heading font-bold">متابعة {{ $student->name }}</h2>
                <p class="mt-2 text-midnight/70">عرض تفاصيل التقدم، الاشتراكات، الدفع، ونتائج الاختبارات.</p>
            </div>
            <a href="{{ route('parent.dashboard') }}" class="bg-sand border-2 border-midnight px-5 py-3 font-bold text-midnight hover:bg-midnight hover:text-sand transition">عودة إلى الأبناء</a>
        </div>

        @if(session('success'))
            <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-6 xl:grid-cols-[1.1fr_0.9fr]">
            <div class="space-y-6">
                <div class="rounded-3xl bg-white p-6 shadow-xl border border-sand">
                    <h3 class="text-2xl font-bold text-midnight">معلومات الطالب</h3>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl bg-sand p-4">
                            <p class="text-sm text-midnight/70">الاسم</p>
                            <p class="mt-2 font-semibold text-midnight">{{ $student->name }}</p>
                        </div>
                        <div class="rounded-3xl bg-sand p-4">
                            <p class="text-sm text-midnight/70">السنة الدراسية</p>
                            <p class="mt-2 font-semibold text-midnight">{{ $student->academic_year ?? 'غير محددة' }}</p>
                        </div>
                        <div class="rounded-3xl bg-sand p-4">
                            <p class="text-sm text-midnight/70">المدرس</p>
                            <p class="mt-2 font-semibold text-midnight">{{ $student->subscriptions->first()?->course?->teacher?->name ?? 'لم يتم التسجيل بعد' }}</p>
                        </div>
                        <div class="rounded-3xl bg-sand p-4">
                            <p class="text-sm text-midnight/70">عدد الطلاب المشتركين</p>
                            <p class="mt-2 font-semibold text-midnight">{{ $student->subscriptions->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow-xl border border-sand">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-midnight">اشتراكات الطالب</h3>
                            <p class="mt-1 text-sm text-midnight/70">تحكم في الاشتراكات والمدفوعات لكل دورة.</p>
                        </div>
                        <div class="text-right text-sm text-midnight/60">
                            <p>الاشتراكات: {{ $student->subscriptions->count() }}</p>
                            <p>المدفوعات الناجحة: {{ $student->subscriptions->flatMap(fn($sub) => $sub->payments)->where('status', 'success')->count() }}</p>
                        </div>
                    </div>

                    @if($student->subscriptions->isEmpty())
                        <div class="mt-6 rounded-3xl border border-midnight/10 bg-sand p-6 text-midnight/70">
                            لا يوجد اشتراكات بعد. قم بإضافة اشتراك جديد لاختبار عملية الدفع.
                        </div>
                    @else
                        <div class="mt-6 space-y-4">
                            @foreach($student->subscriptions as $subscription)
                                <div class="rounded-3xl border border-sand p-6 bg-sand/70">
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                        <div>
                                            <h4 class="text-xl font-bold text-midnight">{{ $subscription->course->name ?? 'دورة محذوفة' }}</h4>
                                            <p class="mt-2 text-sm text-midnight/70">المعلم: {{ $subscription->course->teacher?->name ?? 'غير محدد' }}</p>
                                        </div>
                                        <span class="rounded-full bg-midnight px-4 py-2 text-xs font-bold text-sand">{{ ucfirst($subscription->status) }}</span>
                                    </div>

                                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                                        <div class="rounded-3xl bg-white p-4">
                                            <p class="text-sm text-midnight/70">الحالة المالية</p>
                                            <p class="mt-2 text-lg font-bold text-midnight">{{ $subscription->payments->last()?->status === 'success' ? 'مدفوع' : 'قيد الانتظار' }}</p>
                                        </div>
                                        <div class="rounded-3xl bg-white p-4">
                                            <p class="text-sm text-midnight/70">المبلغ المطلوب</p>
                                            <p class="mt-2 text-lg font-bold text-midnight">{{ number_format($subscription->course->monthly_fee, 2) }} د.إ</p>
                                        </div>
                                        <div class="rounded-3xl bg-white p-4">
                                            <p class="text-sm text-midnight/70">جلسات مستخدمة</p>
                                            <p class="mt-2 text-lg font-bold text-midnight">{{ $subscription->sessions_used }} / {{ $subscription->sessions_limit }}</p>
                                        </div>
                                        <div class="rounded-3xl bg-white p-4">
                                            <p class="text-sm text-midnight/70">المتبقي من الجلسات</p>
                                            <p class="mt-2 text-lg font-bold text-midnight">{{ $subscription->sessions_left }}</p>
                                        </div>
                                    </div>

                                    <div class="mt-6 flex flex-wrap gap-3 items-center">
                                        @if($subscription->payments->last()?->status !== 'success')
                                            <a href="{{ route('parent.student.subscription.checkout', [$student, $subscription]) }}" class="rounded-3xl bg-midnight px-6 py-3 text-sm font-bold text-sand hover:bg-amber-600 transition">ادفع الآن (وضع التجربة)</a>
                                        @else
                                            <span class="rounded-3xl bg-emerald-500 px-6 py-3 text-sm font-bold text-sand">تم الدفع تجريبياً</span>
                                        @endif
                                        <div class="rounded-3xl border border-midnight/10 bg-white p-4">
                                            <p class="text-xs uppercase tracking-[0.2em] text-midnight/60">تفاصيل الدفع</p>
                                            <p class="mt-2 text-sm text-midnight/70">رقم الطلب: {{ $subscription->payments->last()?->paymob_order_id ?? '-' }}</p>
                                            <p class="mt-2 text-sm text-midnight/70">رقم المعاملة: {{ $subscription->payments->last()?->paymob_transaction_id ?? '-' }}</p>
                                            <p class="mt-2 text-sm text-midnight/70">حالة الدفع الأخيرة: {{ ucfirst($subscription->payments->last()?->status ?? 'لم يتم الدفع') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <aside class="space-y-6">
                <div class="rounded-3xl bg-white p-6 shadow-xl border border-sand">
                    <h3 class="text-2xl font-bold text-midnight">أداء الواجبات</h3>
                    <p class="mt-2 text-sm text-midnight/70">تحتاج إضافة حقول فعلية لبيانات الواجبات والاختبار.</p>

                    <div class="mt-6 space-y-4">
                        <div class="rounded-3xl bg-sand p-4">
                            <p class="text-sm text-midnight/70">الواجبات المكتملة</p>
                            <p class="mt-2 text-lg font-bold text-midnight">{{ $student->homework_completed ?? 'غير متوفر' }}</p>
                        </div>
                        <div class="rounded-3xl bg-sand p-4">
                            <p class="text-sm text-midnight/70">حالة كل الواجبات</p>
                            <p class="mt-2 text-lg font-bold text-midnight">{{ $student->all_homework_done ? 'نعم' : 'لا' }}</p>
                        </div>
                        <div class="rounded-3xl bg-sand p-4">
                            <p class="text-sm text-midnight/70">تقييم الاختبار من 10</p>
                            <p class="mt-2 text-lg font-bold text-midnight">{{ $student->quiz_score ?? 'غير متوفر' }}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow-xl border border-sand">
                    <h3 class="text-2xl font-bold text-midnight">اشتراك جديد</h3>
                    <p class="mt-2 text-sm text-midnight/70">اختر دورة جديدة للطالب واستعد الدفع التجريبي.</p>

                    <form action="{{ route('parent.student.subscribe', $student) }}" method="POST" class="mt-6 space-y-4">
                        @csrf
                        <label class="block text-sm font-semibold text-midnight">اختر الدورة</label>
                        <select name="course_id" class="w-full rounded-3xl border border-sand bg-sand/60 px-4 py-3 text-right text-midnight outline-none focus:border-midnight" required>
                            <option value="">اختر دورة</option>
                            @foreach(\App\Models\Course::all() as $course)
                                <option value="{{ $course->id }}">{{ $course->name }} - {{ number_format($course->monthly_fee, 2) }} د.إ</option>
                            @endforeach
                        </select>
                        @error('course_id')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                        <button type="submit" class="w-full rounded-3xl bg-midnight px-5 py-3 text-sm font-bold text-sand">إنشاء اشتراك</button>
                    </form>
                </div>
            </aside>
        </div>
    </div>
</x-app>
