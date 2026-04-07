<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - ScheduleAI Terminal</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo/logo-ico.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background-color: #f8fafc; font-family: 'Inter', sans-serif; }
        .sharp-border { border: 4px solid #0f172a; }
        .sharp-shadow { box-shadow: 12px 12px 0px #0f172a; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI4IiBoZWlnaHQ9IjgiPgo8cmVjdCB3aWR0aD0iOCIgaGVpZ2h0PSI4IiBmaWxsPSIjZjhmYWZjIi8+CjxyZWN0IHdpZHRoPSIxIiBoZWlnaHQ9IjEiIGZpbGw9IiNlMmU4ZjAiLz4KPC9zdmc+')]">
    
    <div class="relative w-full max-w-2xl bg-white sharp-border sharp-shadow p-8 md:p-16">
        
        {{-- DECORATION CORNERS --}}
        <div class="absolute top-0 left-0 w-4 h-4 bg-slate-900"></div>
        <div class="absolute top-0 right-0 w-4 h-4 bg-slate-900"></div>
        <div class="absolute bottom-0 left-0 w-4 h-4 bg-slate-900"></div>
        <div class="absolute bottom-0 right-0 w-4 h-4 bg-slate-900"></div>

        <div class="flex flex-col md:flex-row items-center gap-10">
            {{-- ERROR CODE --}}
            <div class="shrink-0 flex flex-col items-center justify-center border-b-4 md:border-b-0 md:border-r-4 border-slate-900 md:pr-10 pb-6 md:pb-0">
                <p class="text-[10px] font-black uppercase text-slate-400 tracking-[0.3em] mb-2">System Response</p>
                <h1 class="text-7xl md:text-8xl font-black text-slate-900 tracking-tighter leading-none">@yield('code')</h1>
            </div>

            {{-- ERROR MESSAGE --}}
            <div class="flex-1 text-center md:text-left">
                <h2 class="text-2xl font-black uppercase tracking-tighter text-slate-900 mb-2">@yield('title')</h2>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-widest leading-relaxed mb-8">@yield('message')</p>
                
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3 bg-blue-600 hover:bg-slate-900 text-white border-2 border-slate-900 px-6 py-3 text-xs font-black uppercase tracking-widest shadow-[4px_4px_0px_#000] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Terminal
                </a>
            </div>
        </div>

    </div>

</body>
</html>
