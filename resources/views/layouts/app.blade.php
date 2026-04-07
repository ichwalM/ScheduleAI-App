<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: true, darkMode: false }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ScheduleAI') }} – {{ $title ?? 'Dashboard' }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo/logo-ico.ico') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite assets (Tailwind + Alpine.js) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-nav a.active { @apply bg-blue-700 text-white; }
        aside { transition: width 0.3s ease; border-right: 2px solid #000; }
        * { border-radius: 0 !important; }
        .sharp-border { border: 2px solid #000; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-200 antialiased">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="flex flex-col bg-slate-900 z-20 sticky top-0 h-screen overflow-y-auto"
           :class="sidebarOpen ? 'w-64' : 'w-16'">

        <!-- Logo / Profile -->
        <div class="flex items-center gap-3 px-5 py-6 border-b-2 border-slate-800">
            @php
                $user = auth()->user();
                $avatar = $user?->profile?->avatar_path ? Storage::url($user->profile->avatar_path) : null;
            @endphp
            @if($avatar)
                <img src="{{ $avatar }}" alt="Avatar" class="w-10 h-10 object-cover shrink-0 border-2 border-white/20">
            @else
                <div class="shrink-0 w-10 h-10 bg-blue-600 flex items-center justify-center font-black text-white shadow-[2px_2px_0px_#1e40af]">
                    {{ strtoupper(substr($user->name ?? 'G', 0, 1)) }}
                </div>
            @endif
            <div class="overflow-hidden flex flex-col justify-center" x-show="sidebarOpen" x-transition>
                <span class="text-white font-black text-sm uppercase tracking-tighter truncate">{{ $user->name ?? 'GUEST' }}</span>
                <span class="text-blue-400 font-bold text-[10px] uppercase tracking-widest truncate">{{ $user->role ?? 'VISITOR' }}</span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-2 py-4 space-y-1">
            @auth
                @if(auth()->user()->role === 'admin')
                    <x-sidebar-link href="{{ route('admin.profiles') }}"  icon="user-group"  label="Profil Mahasiswa" :active="request()->routeIs('admin.profiles')"  :open="$sidebarOpen ?? true"/>
                    <x-sidebar-link href="{{ route('admin.dashboard') }}" icon="home"        label="Dashboard"        :active="request()->routeIs('admin.dashboard')" :open="$sidebarOpen ?? true"/>
                    <x-sidebar-link href="{{ route('admin.courses') }}"   icon="book-open"   label="Mata Kuliah"      :active="request()->routeIs('admin.courses*')"  :open="$sidebarOpen ?? true"/>
                    <x-sidebar-link href="{{ route('admin.schedules') }}" icon="calendar"    label="Jadwal"           :active="request()->routeIs('admin.schedules*')" :open="$sidebarOpen ?? true"/>
                    <x-sidebar-link href="{{ route('admin.students') }}"  icon="users"       label="Mahasiswa"        :active="request()->routeIs('admin.students')"  :open="$sidebarOpen ?? true"/>
                @else
                    <x-sidebar-link href="{{ route('student.dashboard') }}" icon="home"      label="Dashboard"          :active="request()->routeIs('student.dashboard')"   :open="$sidebarOpen ?? true"/>
                    <x-sidebar-link href="{{ route('student.upload') }}"    icon="upload"    label="Unggah Jadwal"      :active="request()->routeIs('student.upload')"       :open="$sidebarOpen ?? true"/>
                    <x-sidebar-link href="{{ route('student.courses.index') }}" icon="book-open" label="Mata Kuliah"    :active="request()->routeIs('student.courses.*')"    :open="$sidebarOpen ?? true"/>
                    <x-sidebar-link href="{{ route('student.activities.index') }}" icon="briefcase" label="Manajemen Jadwal" :active="request()->routeIs('student.activities.*')" :open="$sidebarOpen ?? true"/>
                @endif
                
                {{-- Spacer --}}
                <div class="h-4"></div>
                {{-- Global Settings --}}
                <x-sidebar-link href="{{ route('profile.edit') }}" icon="cog" label="Pengaturan Profil" :active="request()->routeIs('profile.edit')" :open="$sidebarOpen ?? true"/>
            @else
                <x-sidebar-link href="{{ route('register') }}" icon="upload" label="Registrasi" :active="false" :open="$sidebarOpen ?? true"/>
                <x-sidebar-link href="{{ route('login') }}" icon="users" label="Login" :active="false" :open="$sidebarOpen ?? true"/>
            @endauth
        </nav>

        <!-- User info + logout -->
        @auth
        <div class="border-t-2 border-slate-800 p-4">
            <div class="flex items-center gap-3">
                <div class="shrink-0 w-10 h-10 bg-slate-700 flex items-center justify-center text-white font-bold text-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div x-show="sidebarOpen" x-transition class="flex-1 min-w-0">
                    <p class="text-white text-xs font-black uppercase truncate">{{ auth()->user()->name }}</p>
                    <p class="text-slate-500 text-[10px] uppercase font-bold">{{ auth()->user()->role }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" x-show="sidebarOpen" x-transition>
                    @csrf
                    <button type="submit" class="text-slate-500 hover:text-white" title="Logout">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @endauth
    </aside>

    <!-- Main content area -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- Top bar -->
        <header class="bg-white dark:bg-slate-800 border-b-2 border-slate-900 flex items-center gap-4 px-6 py-4">
            <!-- Toggle sidebar -->
            <button @click="sidebarOpen = !sidebarOpen" class="text-slate-900 dark:text-white hover:text-blue-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <!-- Page title slot -->
            <h1 class="text-xl font-black uppercase tracking-tighter text-slate-900 dark:text-white flex-1">
                {{ $title ?? 'Dashboard' }}
            </h1>

            <!-- Dark mode toggle -->
            <button @click="darkMode = !darkMode"
                    class="w-10 h-10 border-2 border-slate-900 bg-white dark:bg-slate-700 flex items-center justify-center hover:bg-slate-100 transition-all">
                <svg x-show="!darkMode" class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
                <svg x-show="darkMode" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2a1 1 0 011 1v1a1 1 0 01-2 0V3a1 1 0 011-1zm0 17a1 1 0 011 1v1a1 1 0 01-2 0v-1a1 1 0 011-1zM4.22 4.22a1 1 0 011.42 0l.7.7a1 1 0 01-1.42 1.42l-.7-.7a1 1 0 010-1.42zm13.44 13.44a1 1 0 011.42 0l.7.7a1 1 0 01-1.42 1.42l-.7-.7a1 1 0 010-1.42zM2 12a1 1 0 011-1h1a1 1 0 010 2H3a1 1 0 01-1-1zm17 0a1 1 0 011-1h1a1 1 0 010 2h-1a1 1 0 01-1-1zM4.22 19.78a1 1 0 010-1.42l.7-.7a1 1 0 011.42 1.42l-.7.7a1 1 0 01-1.42 0zm13.44-13.44a1 1 0 010-1.42l.7-.7a1 1 0 011.42 1.42l-.7.7a1 1 0 01-1.42 0zM12 7a5 5 0 100 10A5 5 0 0012 7z"/>
                </svg>
            </button>
        </header>

        <!-- Flash messages -->
        <div class="px-6 pt-4 space-y-2">
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)"
                     class="flex items-center gap-3 bg-white border-2 border-emerald-600 text-emerald-700 font-bold px-4 py-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('warning'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                     class="flex items-center gap-3 bg-white border-2 border-amber-600 text-amber-700 font-bold px-4 py-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                    {{ session('warning') }}
                </div>
            @endif
            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                     class="flex items-center gap-3 bg-white border-2 border-red-600 text-red-700 font-bold px-4 py-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
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
