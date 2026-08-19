<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أكاديمية Shining Leaders | بناء الإنسان والقائد</title>

    <!-- Google Fonts: El Messiri & Tajawal -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@600;700&family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">

    @include('partials.lang-boot')

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="selection:bg-terracotta selection:text-white">

    <!-- Header Navigation -->
    <header class="border-b-2 border-midnight bg-sand sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between gap-4">

            <!-- Logo -->
            <a href="#" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-midnight text-sand font-heading font-bold text-xl flex items-center justify-center border-2 border-midnight">
                    SL
                </div>
                <div class="flex flex-col">
                    <span class="font-heading font-bold text-xl leading-none text-midnight">Shining Leaders</span>
                    <span class="text-xs font-bold text-terracotta tracking-tight">أكاديمية قادة الغد</span>
                </div>
            </a>

            <!-- Nav Links -->
            <nav class="hidden md:flex items-center gap-8 font-bold text-sm text-midnight">
                <a href="#vision" class="hover:text-terracotta transition-colors">الرؤية والرسالة</a>
                <a href="#challenges" class="hover:text-terracotta transition-colors">التحديات</a>
                <a href="#pillars" class="hover:text-terracotta transition-colors">الركائز التربوية</a>
                <a href="#community" class="hover:text-terracotta transition-colors">مجتمعنا</a>
            </nav>

            <div class="flex items-center gap-3">

                @include('partials.lang-switcher')

                <a href="/login" class="bg-white hover:bg-slate-100 text-midnight px-4 py-2 text-sm font-bold border-2 border-midnight transition-colors shadow-[3px_3px_0px_0px_#0B132B]">
                    تسجيل الدخول
                </a>

                <a href="https://www.facebook.com/share/18gaCNmSHy/?mibextid=wwXIfr" target="_blank" rel="noopener noreferrer" class="hidden lg:inline-block bg-midnight hover:bg-forest text-sand px-4 py-2 text-sm font-bold border-2 border-midnight transition-colors shadow-[3px_3px_0px_0px_#D97706]">
                    تواصل معنا
                </a>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="border-b-2 border-midnight bg-sand py-16 lg:py-24">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">

                    <!-- Text Block -->
                    <div class="lg:col-span-7 space-y-8">
                        <div class="inline-block bg-terracotta text-white font-bold text-xs px-3 py-1 border border-midnight">
                            من 4 إلى 16 سنة
                        </div>

                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight text-midnight">
                            <span class="text-forest underline decoration-terracotta underline-offset-8">إحنا مجتمع هدفه بناء جيل واعٍ، مبدع، وذو قيم</span>
                        </h1>

                        <p class="text-lg sm:text-xl font-medium text-midnight/80 leading-relaxed max-w-2xl">
                            الشعار: <strong class="text-terracotta font-heading font-bold">هنا يبدأ التعلم… ويبدأ معه بناء الإنسان</strong>.<br>
                            لأننا نؤمن أن التعليم الحقيقي لا يقتصر على الدروس ، بل يمتد إلى بناء القيم ، وتنمية المهارات ، وصناعة صحبة صالحة 
                        </p>

                        <div class="pt-4 flex flex-col sm:flex-row gap-4 items-stretch sm:items-center">
                            @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-terracotta hover:bg-amber-700 text-white font-bold px-8 py-4 text-center border-2 border-midnight shadow-[6px_6px_0px_0px_#0B132B] transition-all hover:translate-x-1 hover:translate-y-1 hover:shadow-none">
                                انضم إلى مجتمعنا الآن
                            </a>
                            @else
                            <a href="https://www.facebook.com/share/18gaCNmSHy/?mibextid=wwXIfr" target="_blank" rel="noopener noreferrer" class="bg-terracotta hover:bg-amber-700 text-white font-bold px-8 py-4 text-center border-2 border-midnight shadow-[6px_6px_0px_0px_#0B132B] transition-all hover:translate-x-1 hover:translate-y-1 hover:shadow-none">
                                انضم إلى مجتمعنا على الفيسبوك
                            </a>
                            @endif

                            <a href="#pillars" class="bg-white text-midnight font-bold px-8 py-4 text-center border-2 border-midnight shadow-[6px_6px_0px_0px_#065F46] transition-all hover:bg-slate-50">
                                استعرض برامجنا التربوية
                            </a>
                        </div>
                    </div>

                    <!-- Visual Card Block -->
                    <div class="lg:col-span-5 w-full">
                        <div class="bg-clay text-sand p-8 border-2 border-midnight shadow-[12px_12px_0px_0px_#D97706] space-y-6">
                            <div class="border-b border-sand/20 pb-4">
                                <span class="text-xs font-mono uppercase text-terracotta tracking-widest">منهجية العمل</span>
                                <h2 class="text-2xl font-heading font-bold text-white mt-1">التربية المتكاملة</h2>
                            </div>

                            <ul class="space-y-4 text-sm font-medium">
                                <li class="flex items-start gap-3">
                                    <span class="w-3 h-3 bg-emerald-accent border border-midnight mt-1 shrink-0"></span>
                                    <span><strong>الجانب التعليمي:</strong> تأسيس، لغات، مهارات القراءة والخط.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="w-3 h-3 bg-terracotta border border-midnight mt-1 shrink-0"></span>
                                    <span><strong>الجانب الديني:</strong> قرآن باللعب، تجويد، وسيرة صحابة.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="w-3 h-3 bg-forest border border-midnight mt-1 shrink-0"></span>
                                    <span><strong>الجانب النفسي والقيادي:</strong> ثقة، تحمل مسؤولية، وضبط النفس.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="w-3 h-3 bg-amber-400 border border-midnight mt-1 shrink-0"></span>
                                    <span><strong>الأنشطة والأعمال اليدوية:</strong> مكرمية، رسم، ونجارة للطلاب.</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Vision & Mission -->
        <section id="vision" class="border-b-2 border-midnight bg-white py-20">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="border-2 border-midnight p-8 bg-sand shadow-[8px_8px_0px_0px_#0B132B]">
                        <span class="text-xs font-bold text-forest uppercase tracking-widest">التوجه المستقبلي</span>
                        <h2 class="text-3xl font-heading font-bold text-midnight mt-2 mb-4">الرؤية</h2>
                        <p class="text-lg leading-relaxed text-midnight/90 font-medium">
                            أن نصنع جيلًا متعلمًا، واثقًا، ملتزمًا، ومبدعًا، يجمع بين العلم والأخلاق والمهارات الحياتية.
                        </p>
                    </div>

                    <div class="border-2 border-midnight p-8 bg-midnight text-sand shadow-[8px_8px_0px_0px_#D97706]">
                        <span class="text-xs font-bold text-terracotta uppercase tracking-widest">الواجب اليومي</span>
                        <h2 class="text-3xl font-heading font-bold text-white mt-2 mb-4">الرسالة</h2>
                        <p class="text-lg leading-relaxed text-sand/90 font-medium">
                            تقديم بيئة تعليمية آمنة وممتعة للطلاب من سن (4 إلى 16 سنة)، تجمع بين التعليم الدراسي، التربية الإسلامية، المهارات الشخصية، الأنشطة الفنية، وتنمية المواهب لبناء شخصية الطالب.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Problems Faced by Parents -->
        <section id="challenges" class="border-b-2 border-midnight bg-sand py-20">
            <div class="max-w-7xl mx-auto px-6">
                <div class="max-w-3xl mb-12">
                    <span class="text-xs font-bold text-terracotta uppercase tracking-widest">تشخيص الواقع</span>
                    <h2 class="text-3xl sm:text-4xl font-heading font-bold text-midnight mt-1">المشاكل التي تواجه ولي الأمر عامة</h2>
                    <p class="text-midnight/70 font-medium mt-2">نحن ندرك التحديات المعاصرة التي تؤرق كل أسرة في تربية أبنائها:</p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div class="p-4 border-2 border-midnight bg-white font-bold text-midnight text-sm">• فرط حركة وعدم تركيز</div>
                    <div class="p-4 border-2 border-midnight bg-white font-bold text-midnight text-sm">• التعلق بالموبايل والإدمان الرقمي</div>
                    <div class="p-4 border-2 border-midnight bg-white font-bold text-midnight text-sm">• ضعف النطق والقراءة</div>
                    <div class="p-4 border-2 border-midnight bg-white font-bold text-midnight text-sm">• العناد والعصبية</div>
                    <div class="p-4 border-2 border-midnight bg-white font-bold text-midnight text-sm">• عدم الالتزام بالصلاة</div>
                    <div class="p-4 border-2 border-midnight bg-white font-bold text-midnight text-sm">• غياب الصحبة الجيدة</div>
                    <div class="p-4 border-2 border-midnight bg-white font-bold text-midnight text-sm">• كره المذاكرة والتشتت</div>
                    <div class="p-4 border-2 border-midnight bg-white font-bold text-midnight text-sm">• ضعف الشخصية والثقة</div>
                    <div class="p-4 border-2 border-midnight bg-white font-bold text-midnight text-sm">• الكذب وقت الفراغ الكبير</div>
                    <div class="p-4 border-2 border-midnight bg-white font-bold text-midnight text-sm">• ضعف الانتماء للدين</div>
                    <div class="p-4 border-2 border-midnight bg-white font-bold text-midnight text-sm">• ضعف مهارات الحياة</div>
                    <div class="p-4 border-2 border-midnight bg-white font-bold text-midnight text-sm">• قلة تحمل المسؤولية</div>
                </div>
            </div>
        </section>

        <!-- Solutions / Pillars -->
        <section id="pillars" class="border-b-2 border-midnight bg-white py-20">
            <div class="max-w-7xl mx-auto px-6">
                <div class="mb-16">
                    <span class="text-xs font-bold text-forest uppercase tracking-widest">منظومة البناء</span>
                    <h2 class="text-3xl sm:text-4xl font-heading font-bold text-midnight mt-1">حلول متكاملة يقدمها مجتمع الأكاديمية</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="border-2 border-midnight bg-sand p-6 flex flex-col justify-between shadow-[6px_6px_0px_0px_#0B132B]">
                        <div>
                            <div class="w-8 h-8 bg-forest text-white font-bold text-xs flex items-center justify-center border border-midnight mb-4">01</div>
                            <h3 class="text-xl font-heading font-bold text-midnight mb-4">الجانب التعليمي</h3>
                            <ul class="space-y-2 text-sm font-medium text-midnight/80">
                                <li>• التعليم الدراسي الذكي</li>
                                <li>• متابعة الواجبات وشرح المواد</li>
                                <li>• تأسيس عربي وإنجليزي</li>
                                <li>• نحو وإملاء</li>
                                <li>• مهارات القراءة السريعة</li>
                                <li>• تحسين الخط</li>
                            </ul>
                        </div>
                    </div>

                    <div class="border-2 border-midnight bg-sand p-6 flex flex-col justify-between shadow-[6px_6px_0px_0px_#D97706]">
                        <div>
                            <div class="w-8 h-8 bg-terracotta text-white font-bold text-xs flex items-center justify-center border border-midnight mb-4">02</div>
                            <h3 class="text-xl font-heading font-bold text-midnight mb-4">الجانب الديني والروحاني</h3>
                            <ul class="space-y-2 text-sm font-medium text-midnight/80">
                                <li>• تحفيظ قرآن بطريقة اللعب</li>
                                <li>• تجويد مبسط</li>
                                <li>• قصص الصحابة والسيرة النبوية</li>
                                <li>• تعليم الصلاة عمليًا</li>
                                <li>• بر الوالدين والأدب الإسلامي</li>
                            </ul>
                        </div>
                    </div>

                    <div class="border-2 border-midnight bg-sand p-6 flex flex-col justify-between shadow-[6px_6px_0px_0px_#0B132B]">
                        <div>
                            <div class="w-8 h-8 bg-midnight text-white font-bold text-xs flex items-center justify-center border border-midnight mb-4">03</div>
                            <h3 class="text-xl font-heading font-bold text-midnight mb-4">الجانب النفسي والقيادي</h3>
                            <ul class="space-y-2 text-sm font-medium text-midnight/80">
                                <li>• الثقة بالنفس واحترام الذات</li>
                                <li>• الجرأة في الكلام والقيادة</li>
                                <li>• تحمل المسؤولية</li>
                                <li>• التحكم في الغضب والصبر</li>
                            </ul>
                        </div>
                    </div>

                    <div class="border-2 border-midnight bg-sand p-6 flex flex-col justify-between shadow-[6px_6px_0px_0px_#065F46]">
                        <div>
                            <div class="w-8 h-8 bg-emerald-accent text-midnight font-bold text-xs flex items-center justify-center border border-midnight mb-4">04</div>
                            <h3 class="text-xl font-heading font-bold text-midnight mb-4">الجانب الفني والترفيهي</h3>
                            <ul class="space-y-2 text-sm font-medium text-midnight/80">
                                <li>• رسم، كرافت، وهاند ميد</li>
                                <li>• رسم على الزجاج والقماش</li>
                                <li>• مكرمية وسجاد خيوط الكليم</li>
                                <li>• حقائب يدوية وميداليات</li>
                                <li>• أعمال خشب ونجارة للطلاب</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Community Section -->
        <section id="community" class="border-b-2 border-midnight bg-midnight text-sand py-20">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    <div class="lg:col-span-6 space-y-6">
                        <span class="text-xs font-mono text-terracotta uppercase tracking-widest">بدل ما الطالب يروح مكان يضيع وقته</span>
                        <h2 class="text-3xl sm:text-4xl font-heading font-bold text-white">مجتمع متكامل يبني شخصية الطالب</h2>
                        <p class="text-sand/80 leading-relaxed font-medium">
                            في أكاديمية Shining Leaders، لا نقدم دروسًا فردية مجزأة، بل ندمج الطالب في مجتمع إيجابي يتلقى فيه الرعاية الشاملة:
                        </p>
                        <div class="grid grid-cols-2 gap-4 pt-2 font-bold text-sm">
                            <div class="p-3 border border-sand/20 bg-clay">• صحبة محترمة</div>
                            <div class="p-3 border border-sand/20 bg-clay">• مدرسون قدوة</div>
                            <div class="p-3 border border-sand/20 bg-clay">• مسابقات ورحلات</div>
                            <div class="p-3 border border-sand/20 bg-clay">• فرق عمل ومسابقات حفظ</div>
                            <div class="p-3 border border-sand/20 bg-clay">• أيام ترفيهية</div>
                            <div class="p-3 border border-sand/20 bg-clay">• متابعة أسرية مستمرة</div>
                        </div>
                    </div>

                    <div class="lg:col-span-6">
                        <div class="border-2 border-sand p-8 bg-sand text-midnight shadow-[10px_10px_0px_0px_#D97706]">
                            <h3 class="text-2xl font-heading font-bold mb-4 text-midnight">احجز مكاناً لطالبك اليوم</h3>
                            <p class="text-sm font-medium text-midnight/80 mb-6">
                                انضم إلى العائلات التي اختارت استثمار المستقبل في أبنائها. سجل معنا أو تواصل عبر الفيسبوك.
                            </p>

                            <a href="{{ route('register') }}" class="block w-full bg-terracotta hover:bg-amber-700 text-white font-bold text-center py-4 border-2 border-midnight shadow-[4px_4px_0px_0px_#0B132B] transition-all mb-3">
                                إنشاء حساب جديد وتأكيد الحجز
                            </a>

                            <a href="https://www.facebook.com/share/18gaCNmSHy/?mibextid=wwXIfr" target="_blank" rel="noopener noreferrer" class="block w-full bg-white hover:bg-slate-100 text-midnight font-bold text-center py-3 border-2 border-midnight transition-all">
                                الانتقال لصفحة الفيسبوك الرسمية
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-sand py-8 text-sm font-bold text-midnight">
        <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                © {{ date('Y') }} أكاديمية Shining Leaders. جميع الحقوق محفوظة.
            </div>
            <div>
                <a href="https://www.facebook.com/share/18gaCNmSHy/?mibextid=wwXIfr" target="_blank" rel="noopener noreferrer" class="text-terracotta underline hover:text-midnight">
                    متابعتنا على فيسبوك
                </a>
            </div>
        </div>
    </footer>

</body>

</html>