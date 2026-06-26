<!DOCTYPE html>
<html lang="en" class="h-full bg-dots">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EMS — Event Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">
    <header class="bg-ink text-white border-b-2 border-black sticky top-0 z-10">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-3">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="sticker flex h-10 w-10 items-center justify-center border-2 border-blue-600 bg-gradient-to-br from-blue-400 to-blue-700">
                    <span class="text-sm font-extrabold text-ink">E</span>
                </div>
                <span class="text-xl font-extrabold uppercase tracking-tighter text-white">EMS</span>
            </a>
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}"
                   class="sticker inline-flex items-center gap-2 border-2 border-blue-600 bg-gradient-to-r from-blue-400 to-blue-700 px-5 py-2 text-sm font-extrabold text-white uppercase tracking-wider shadow-[4px_4px_0px_0px_#fff] hover:shadow-[2px_2px_0px_0px_#fff] hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                    Admin Login
                </a>
            </div>
        </div>
    </header>

    <main class="py-8">
        @if (session('success'))
            <div class="mx-auto max-w-7xl px-6 mb-6">
                <div class="torn-edge border-2 border-black bg-emerald-300 p-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg class="h-5 w-5 text-ink" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            <p class="text-sm font-extrabold text-ink">{{ session('success') }}</p>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="font-extrabold text-ink hover:opacity-60" aria-label="Tutup">X</button>
                    </div>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mx-auto max-w-7xl px-6 mb-6">
                <div class="border-2 border-black bg-coral/30 px-5 py-4 shadow-[5px_5px_0px_0px_#000]">
                    <div class="flex items-start gap-3">
                        <svg class="h-5 w-5 text-ink shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        <ul class="list-disc list-inside text-sm font-bold text-ink">
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

    <footer class="border-t-2 border-black border-dashed py-8 text-center text-xs font-bold text-ink/60">
        EMS v1.0 — Laravel {{ app()->version() }}
    </footer>
</body>
</html>
