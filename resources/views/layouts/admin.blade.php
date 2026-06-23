<!DOCTYPE html>
<html lang="en" class="h-full bg-warm">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EMS — Event Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">
    <div id="mobile-backdrop" class="fixed inset-0 z-10 bg-black/50 hidden lg:hidden" onclick="closeSidebar()"></div>
    <div class="flex h-full">
        <x-sidebar />

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <header class="sticky top-0 z-10 bg-white border-b-2 border-black">
                <div class="flex items-center justify-between px-6 py-3">
                    <div class="flex items-center gap-3">
                        <button id="mobile-menu-btn" class="lg:hidden font-bold text-ink hover:opacity-60">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <h1 class="text-xl font-extrabold text-ink uppercase tracking-tighter">@yield('title', 'Dashboard')</h1>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-sm font-bold text-ink/50 uppercase tracking-wider">Campus Event Management</span>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                @if (session('success'))
                    <div id="flash-message" class="mb-6 border-2 border-black bg-mint/20 p-4 shadow-[4px_4px_0px_0px_#000] flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-lg">✅</span>
                            <p class="text-sm font-bold text-ink">{{ session('success') }}</p>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" class="font-bold text-ink hover:opacity-60 shrink-0" aria-label="Tutup notifikasi">✕</button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 border-2 border-black bg-red-100 p-4 shadow-[4px_4px_0px_0px_#000]">
                        <div class="flex items-start gap-2">
                            <span class="text-lg shrink-0 mt-0.5">⚠️</span>
                            <div>
                                <p class="text-sm font-extrabold text-ink">Silakan perbaiki kesalahan berikut:</p>
                                <ul class="mt-1 list-disc list-inside text-sm font-semibold text-ink">
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
        </div>
    </div>

    <script>
        var backdrop = document.getElementById('mobile-backdrop');
        var sidebar = document.getElementById('sidebar');
        document.getElementById('mobile-menu-btn')?.addEventListener('click', () => {
            sidebar?.classList.toggle('-translate-x-full');
            sidebar?.classList.toggle('translate-x-0');
            backdrop?.classList.toggle('hidden');
        });
        function closeSidebar() {
            sidebar?.classList.add('-translate-x-full');
            sidebar?.classList.remove('translate-x-0');
            backdrop?.classList.add('hidden');
        }

        document.querySelectorAll('form[method="POST"]').forEach(function(form) {
            form.addEventListener('submit', function() {
                var btn = this.querySelector('button[type="submit"]');
                if (btn && !btn.dataset.loading) {
                    btn.dataset.loading = 'true';
                    btn.disabled = true;
                    var orig = btn.innerHTML;
                    btn.innerHTML = '<svg class="animate-spin h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>' + btn.textContent.replace(/\s+/g,' ').trim();
                }
                return true;
            });
        });
    </script>
</body>
</html>
