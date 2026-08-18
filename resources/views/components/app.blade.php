<!DOCTYPE html>
<html lang="ar" dir="rtl" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Shining Leaders | لوحة التحكم' }}</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@600;700&family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    
    @include('partials.lang-boot')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body { font-family: 'Tajawal', sans-serif; }
        h1, h2, h3, .font-heading { font-family: 'El Messiri', serif; }
    </style>
</head>

<body class="bg-sand text-midnight antialiased overflow-hidden" x-data="{ sidebarOpen: false }">

    <div class="h-screen flex overflow-hidden">
        
        <!-- Mobile Overlay -->
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false" 
             class="fixed inset-0 bg-midnight/50 z-40 md:hidden backdrop-blur-sm">
        </div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full'" 
               class="fixed top-0 right-0 z-50 h-full w-72 bg-midnight text-sand transition-transform duration-300 ease-in-out md:sticky md:translate-x-0 flex flex-col border-l-2 border-midnight shadow-[10px_0px_0px_0px_#D97706]">
            
            <div class="p-6 border-b-2 border-midnight flex justify-between items-center">
                <div class="flex flex-col">
                    <span class="font-heading font-bold text-xl text-white">Shining Leaders</span>
                    <span class="text-[10px] font-bold text-terracotta">لوحة تحكم ولي الأمر</span>
                </div>
                <button @click="sidebarOpen = false" class="md:hidden text-2xl text-terracotta">✕</button>
            </div>
            
            <nav class="mt-6 flex-1 px-4 space-y-2 overflow-y-auto">
                @php
                    if (auth()->check() && auth()->user()->role === 'parent') {
                        $links = [
                            ['route' => 'parent.dashboard', 'label' => 'الرئيسية', 'icon' => '🏠'],
                            ['route' => 'add-student', 'label' => 'إضافة ابن', 'icon' => '➕'],
                            // ['route' => 'parent.courses', 'label' => 'الدورات', 'icon' => '🎓'],
                            // ['route' => 'parent.payments', 'label' => 'المدفوعات', 'icon' => '💳'],
                            // ['route' => 'parent.settings', 'label' => 'الإعدادات', 'icon' => '⚙️'],
                        ];
                    } else {
                        $links = [
                            ['route' => 'parent.dashboard', 'label' => 'الرئيسية', 'icon' => '🏠'],
                        ];
                    }
                @endphp

                @foreach($links as $link)
                    <a href="{{ route($link['route']) }}" 
                       class="flex items-center gap-3 py-3 px-4 border-2 border-transparent transition-all font-bold {{ request()->routeIs($link['route']) ? 'bg-terracotta text-white border-midnight shadow-[4px_4px_0px_0px_#0B132B]' : 'hover:bg-clay hover:border-midnight text-sand' }}">
                        <span>{{ $link['icon'] }}</span>
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="p-6 border-t-2 border-midnight">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-right font-bold text-terracotta hover:text-white transition flex items-center gap-2">
                        <span>🚪</span> تسجيل الخروج
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 bg-sand overflow-y-auto">
            
            <!-- Top Navbar -->
            <header class="bg-sand border-b-2 border-midnight py-4 px-6 flex items-center justify-between sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="md:hidden p-2 bg-midnight text-sand border-2 border-midnight font-bold">
                        ☰ القائمة
                    </button>
                    <h1 class="text-xl font-bold font-heading">مرحباً، {{ auth()->user()->name ?? 'ولي الأمر' }}</h1>
                </div>
                @include('partials.lang-switcher')
            </header>

            <!-- Page Content -->
            <main class="p-6 md:p-10">
                <div class="max-w-5xl mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

</body>
</html>