<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EMS — Event Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">
    <header class="bg-white border-b border-gray-200 sticky top-0 z-10">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-600">
                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <span class="text-lg font-semibold text-gray-900">EMS</span>
            </a>
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Admin</a>
            </div>
        </div>
    </header>

    <main class="py-8">
        @if (session('success'))
            <div class="mx-auto max-w-7xl px-6 mb-6">
                <div class="rounded-lg bg-emerald-50 border border-emerald-200 p-4 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600" aria-label="Tutup"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mx-auto max-w-7xl px-6 mb-6">
                <div class="rounded-lg bg-red-50 border border-red-200 p-4">
                    <div class="flex items-start gap-2">
                        <svg class="h-5 w-5 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <ul class="list-disc list-inside text-sm text-red-700">
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

    <footer class="border-t border-gray-200 py-8 text-center text-xs text-gray-400">
        EMS v1.0 — Laravel {{ app()->version() }}
    </footer>
</body>
</html>
