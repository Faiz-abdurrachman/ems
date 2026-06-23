<!DOCTYPE html>
<html lang="en" class="h-full bg-warm">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EMS — Event Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">
    <header class="bg-white border-b-2 border-black sticky top-0 z-10">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-3">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center border-2 border-black bg-sun font-extrabold text-ink text-sm shadow-[2px_2px_0px_0px_#000]">
                    E
                </div>
                <span class="text-xl font-extrabold uppercase tracking-tighter text-ink">EMS</span>
            </a>
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}"
                   class="inline-flex items-center gap-2 border-2 border-black bg-sun px-5 py-2 text-sm font-extrabold text-ink uppercase tracking-wider shadow-[3px_3px_0px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all">
                    Admin Login
                </a>
            </div>
        </div>
    </header>

    <main class="py-8">
        @if (session('success'))
            <div class="mx-auto max-w-7xl px-6 mb-6">
                <div class="border-2 border-black bg-mint/20 p-4 shadow-[4px_4px_0px_0px_#000] flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5 text-ink" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm font-bold text-ink">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="font-bold text-ink hover:opacity-60" aria-label="Tutup">X</button>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mx-auto max-w-7xl px-6 mb-6">
                <div class="border-2 border-black bg-red-100 p-4 shadow-[4px_4px_0px_0px_#000]">
                    <div class="flex items-start gap-2">
                        <span class="text-lg shrink-0 mt-0.5">⚠️</span>
                        <ul class="list-disc list-inside text-sm font-semibold text-ink">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="border-t-2 border-black py-8 text-center text-xs font-semibold text-ink/40">
        EMS v1.0 — Laravel {{ app()->version() }}
    </footer>
</body>
</html>
