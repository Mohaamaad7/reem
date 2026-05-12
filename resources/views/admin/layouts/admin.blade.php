<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة التحكم') — Rawnaq Reem</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter + Noto Sans Arabic -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+Arabic:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Summernote Lite -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Noto Sans Arabic', 'Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50:  '#fdf8eb',
                            100: '#f9ecc6',
                            200: '#f3d88d',
                            300: '#edc454',
                            400: '#d4a932',
                            500: '#8B6914',
                            600: '#745810',
                            700: '#5d460d',
                            800: '#46350a',
                            900: '#2f2306',
                        },
                        secondary: {
                            50:  '#eef5eb',
                            100: '#d5e6cf',
                            200: '#a8ce99',
                            300: '#7ab563',
                            400: '#4d9d2d',
                            500: '#2E5B1E',
                            600: '#264c19',
                            700: '#1e3d14',
                            800: '#172e0f',
                            900: '#0f1f0a',
                        },
                    }
                }
            }
        }
    </script>

    <style>
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>

    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside id="admin-sidebar" class="w-64 bg-white border-l border-slate-100 flex-col hidden md:flex flex-shrink-0 transition-all duration-300">
        <!-- Logo -->
        <div class="h-16 flex items-center px-6 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-primary-500 flex items-center justify-center">
                    <i data-lucide="hexagon" class="w-5 h-5 text-white"></i>
                </div>
                <span class="text-xl font-bold tracking-tight text-slate-900">نقش<span class="text-primary-500">ويف</span></span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">

            {{-- الرئيسية --}}
            <p class="px-3 text-xs font-semibold text-slate-400 tracking-wider mb-2 mt-2">الرئيسية</p>
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-colors
                      {{ request()->routeIs('admin.dashboard') ? 'bg-amber-50 text-amber-800 border-r-2 border-amber-600' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                لوحة التحكم
            </a>

            {{-- إدارة الأصول --}}
            <p class="px-3 text-xs font-semibold text-slate-400 tracking-wider mb-2 mt-6">إدارة الأصول</p>
            <a href="{{ route('admin.assets.fabrics') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-colors
                      {{ request()->routeIs('admin.assets.fabrics') ? 'bg-amber-50 text-amber-800 border-r-2 border-amber-600' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <i data-lucide="layers" class="w-5 h-5"></i>
                الأقمشة
            </a>
            <a href="{{ route('admin.assets.patterns') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-colors
                      {{ request()->routeIs('admin.assets.patterns') ? 'bg-amber-50 text-amber-800 border-r-2 border-amber-600' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <i data-lucide="grid-2x2" class="w-5 h-5"></i>
                النقشات
            </a>

            {{-- المحتوى التعليمي --}}
            <p class="px-3 text-xs font-semibold text-slate-400 tracking-wider mb-2 mt-6">المحتوى التعليمي</p>
            <a href="{{ route('admin.content.show', 'morris') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-colors
                      {{ request()->is('admin/content/morris') ? 'bg-amber-50 text-amber-800 border-r-2 border-amber-600' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <i data-lucide="palette" class="w-5 h-5"></i>
                وليام موريس
            </a>
            <a href="{{ route('admin.content.show', 'fabrics') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-colors
                      {{ request()->is('admin/content/fabrics') ? 'bg-amber-50 text-amber-800 border-r-2 border-amber-600' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <i data-lucide="leaf" class="w-5 h-5"></i>
                الأقمشة الصديقة
            </a>
            <a href="{{ route('admin.content.show', 'extra-weft') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-colors
                      {{ request()->is('admin/content/extra-weft') ? 'bg-amber-50 text-amber-800 border-r-2 border-amber-600' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <i data-lucide="waves" class="w-5 h-5"></i>
                النقشة الزائدة
            </a>

            {{-- البيانات --}}
            <p class="px-3 text-xs font-semibold text-slate-400 tracking-wider mb-2 mt-6">البيانات</p>
            <a href="{{ route('admin.participants.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-colors
                      {{ request()->routeIs('admin.participants.*') ? 'bg-amber-50 text-amber-800 border-r-2 border-amber-600' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <i data-lucide="users" class="w-5 h-5"></i>
                المشاركون
            </a>
            <a href="{{ route('admin.designs.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-colors
                      {{ request()->routeIs('admin.designs.*') ? 'bg-amber-50 text-amber-800 border-r-2 border-amber-600' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <i data-lucide="image" class="w-5 h-5"></i>
                التصاميم المحفوظة
            </a>
        </nav>

        <!-- Logout -->
        <div class="p-4 border-t border-slate-100">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 w-full px-3 py-2.5 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg font-medium transition-colors">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    تسجيل الخروج
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col min-w-0">
        <!-- Top Header -->
        <header class="h-16 bg-white border-b border-slate-100 flex items-center justify-between px-6 z-10 flex-shrink-0">
            <div class="flex items-center gap-4">
                <button id="sidebar-toggle" class="md:hidden text-slate-500 hover:text-slate-900">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
                <h1 class="text-xl font-semibold text-slate-800">@yield('page_title', 'لوحة التحكم')</h1>
            </div>

            <div class="flex items-center gap-3">
                <span class="text-sm text-slate-500">{{ Auth::guard('admin')->user()->username ?? 'المدير' }}</span>
                <div class="w-8 h-8 rounded-full bg-primary-50 flex items-center justify-center text-primary-600">
                    <i data-lucide="user" class="w-4 h-4"></i>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="flex-1 overflow-y-auto p-6 space-y-6">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-4 py-3 text-sm">
                    {{ is_string(session('success')) ? session('success') : 'تمت العملية بنجاح' }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Mobile sidebar overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/30 z-40 hidden md:hidden"></div>

    <script>
        lucide.createIcons();

        // Mobile sidebar toggle
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('hidden');
                sidebar.classList.toggle('fixed');
                sidebar.classList.toggle('inset-y-0');
                sidebar.classList.toggle('right-0');
                sidebar.classList.toggle('z-50');
                overlay.classList.toggle('hidden');
            });
        }

        if (overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('fixed', 'inset-y-0', 'right-0', 'z-50');
                overlay.classList.add('hidden');
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    @stack('scripts')
</body>
</html>
