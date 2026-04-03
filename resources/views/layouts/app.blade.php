<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: true, darkMode: false }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ScheduleAI') }} – {{ $title ?? 'Dashboard' }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite assets (Tailwind + Alpine.js) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-nav a.active { @apply bg-indigo-700 text-white; }
        /* Smooth sidebar transition */
        aside { transition: width 0.3s ease; }
    </style>
</head>
<body class="bg-slate-100 dark:bg-slate-900 text-slate-800 dark:text-slate-200 antialiased">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="flex flex-col bg-gradient-to-b from-indigo-900 to-indigo-800 shadow-2xl z-20"
           :class="sidebarOpen ? 'w-64' : 'w-16'">

        <!-- Logo -->
        <div class="flex items-center gap-3 px-5 py-5 border-b border-indigo-700">
            <div class="shrink-0 w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="text-white font-bold text-lg tracking-tight" x-show="sidebarOpen" x-transition>ScheduleAI</span>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-2 py-4 space-y-1">
            @if(auth()->user()->role === 'admin')
                <x-sidebar-link href="{{ route('admin.profiles') }}"  icon="user-group"  label="Profil Mahasiswa" :active="request()->routeIs('admin.profiles')"  :open="$sidebarOpen ?? true"/>
                <x-sidebar-link href="{{ route('admin.dashboard') }}" icon="home"        label="Dashboard"        :active="request()->routeIs('admin.dashboard')" :open="$sidebarOpen ?? true"/>
                <x-sidebar-link href="{{ route('admin.courses') }}"   icon="book-open"   label="Mata Kuliah"      :active="request()->routeIs('admin.courses*')"  :open="$sidebarOpen ?? true"/>
                <x-sidebar-link href="{{ route('admin.schedules') }}" icon="calendar"    label="Jadwal"           :active="request()->routeIs('admin.schedules*')" :open="$sidebarOpen ?? true"/>
                <x-sidebar-link href="{{ route('admin.students') }}"  icon="users"       label="Mahasiswa"        :active="request()->routeIs('admin.students')"  :open="$sidebarOpen ?? true"/>
            @else
                <x-sidebar-link href="{{ route('student.dashboard') }}" icon="home"   label="Dashboard"     :active="request()->routeIs('student.dashboard')" :open="$sidebarOpen ?? true"/>
                <x-sidebar-link href="{{ route('student.upload') }}"    icon="upload" label="Unggah Jadwal"  :active="request()->routeIs('student.upload')"    :open="$sidebarOpen ?? true"/>
            @endif
        </nav>

        <!-- User info + logout -->
        <div class="border-t border-indigo-700 p-3">
            <div class="flex items-center gap-3">
                <div class="shrink-0 w-9 h-9 rounded-full bg-indigo-500 flex items-center justify-center text-white font-semibold text-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div x-show="sidebarOpen" x-transition class="flex-1 min-w-0">
                    <p class="text-white text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                    <p class="text-indigo-300 text-xs capitalize">{{ auth()->user()->role }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" x-show="sidebarOpen" x-transition>
                    @csrf
                    <button type="submit" class="text-indigo-300 hover:text-white transition-colors" title="Logout">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main content area -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- Top bar -->
        <header class="bg-white dark:bg-slate-800 shadow-sm border-b border-slate-200 dark:border-slate-700 flex items-center gap-4 px-6 py-4">
            <!-- Toggle sidebar -->
            <button @click="sidebarOpen = !sidebarOpen" class="text-slate-500 hover:text-indigo-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <!-- Page title slot -->
            <h1 class="text-lg font-semibold text-slate-700 dark:text-slate-200 flex-1">
                {{ $title ?? 'Dashboard' }}
            </h1>

            <!-- Dark mode toggle -->
            <button @click="darkMode = !darkMode"
                    class="w-9 h-9 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center hover:ring-2 ring-indigo-400 transition-all">
                <svg x-show="!darkMode" class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
                <svg x-show="darkMode" class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2a1 1 0 011 1v1a1 1 0 01-2 0V3a1 1 0 011-1zm0 17a1 1 0 011 1v1a1 1 0 01-2 0v-1a1 1 0 011-1zM4.22 4.22a1 1 0 011.42 0l.7.7a1 1 0 01-1.42 1.42l-.7-.7a1 1 0 010-1.42zm13.44 13.44a1 1 0 011.42 0l.7.7a1 1 0 01-1.42 1.42l-.7-.7a1 1 0 010-1.42zM2 12a1 1 0 011-1h1a1 1 0 010 2H3a1 1 0 01-1-1zm17 0a1 1 0 011-1h1a1 1 0 010 2h-1a1 1 0 01-1-1zM4.22 19.78a1 1 0 010-1.42l.7-.7a1 1 0 011.42 1.42l-.7.7a1 1 0 01-1.42 0zm13.44-13.44a1 1 0 010-1.42l.7-.7a1 1 0 011.42 1.42l-.7.7a1 1 0 01-1.42 0zM12 7a5 5 0 100 10A5 5 0 0012 7z"/>
                </svg>
            </button>
        </header>

        <!-- Flash messages -->
        <div class="px-6 pt-4 space-y-2">
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)"
                     class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-4 py-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('warning'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                     class="flex items-center gap-3 bg-amber-50 border border-amber-200 text-amber-700 rounded-xl px-4 py-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                    {{ session('warning') }}
                </div>
            @endif
            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                     class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <!-- Page content -->
        <main class="flex-1 overflow-y-auto px-6 py-6">
            {{ $slot }}
        </main>
    </div>
</div>
</body>
</html>
