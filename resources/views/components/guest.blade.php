<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'أكاديمية Shining Leaders' }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@600;700&family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-sand text-midnight min-h-screen flex flex-col justify-between selection:bg-terracotta selection:text-white">

    <!-- Top Minimal Navigation -->
    <header class="border-b-2 border-midnight bg-sand py-4 px-6">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-midnight text-sand font-heading font-bold text-xl flex items-center justify-center border-2 border-midnight">
                    SL
                </div>
                <div class="flex flex-col">
                    <span class="font-heading font-bold text-xl leading-none text-midnight">Shining Leaders</span>
                    <span class="text-xs font-bold text-terracotta">الرئيسية</span>
                </div>
            </a>

            <a href="{{ url('/') }}" class="text-sm font-bold text-midnight hover:text-terracotta underline decoration-2">
                ← العودة للموقع
            </a>
        </div>
    </header>

    <!-- Main Content Box -->
    <main class="flex-grow flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">

            <!-- Auth Card -->
            <div class="bg-white border-2 border-midnight p-8 shadow-[10px_10px_0px_0px_#0B132B]">
                {{ $slot }}
            </div>

            <!-- Footer Badge -->
            <p class="text-center text-xs font-bold text-midnight/70 mt-6">
                أكاديمية Shining Leaders • بناء الإنسان والقائد
            </p>
        </div>
    </main>

    <!-- Simple Footer -->
    <footer class="border-t-2 border-midnight py-4 text-center text-xs font-bold text-midnight bg-sand">
        © {{ date('Y') }} جميع الحقوق محفوظة.
    </footer>

</body>

</html>