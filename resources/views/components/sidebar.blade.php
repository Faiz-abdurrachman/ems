<aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-20 flex w-64 flex-col bg-ink text-white border-r-2 border-black transition-transform lg:translate-x-0 -translate-x-full">
    <div class="flex h-14 items-center gap-3 px-5 border-b-2 border-white/20">
        <div class="flex h-9 w-9 items-center justify-center border-2 border-sun bg-sun">
            <span class="text-sm font-extrabold text-ink">E</span>
        </div>
        <span class="text-lg font-extrabold uppercase tracking-tighter text-white">EMS</span>
    </div>

    <nav class="flex-1 space-y-1 px-3 py-4">
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-bold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-sun text-ink border-2 border-sun shadow-[2px_2px_0px_0px_#fff]' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <span class="text-lg">📊</span>
            Dashboard
        </a>

        <a href="{{ route('admin.events.index') }}"
           class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-bold transition-all {{ request()->routeIs('admin.events.*') ? 'bg-sun text-ink border-2 border-sun shadow-[2px_2px_0px_0px_#fff]' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <span class="text-lg">📅</span>
            Events
        </a>

        <a href="{{ route('admin.participants.index') }}"
           class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-bold transition-all {{ request()->routeIs('admin.participants.*') ? 'bg-sun text-ink border-2 border-sun shadow-[2px_2px_0px_0px_#fff]' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <span class="text-lg">👥</span>
            Participants
        </a>

        <a href="{{ route('admin.registrations.index') }}"
           class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-bold transition-all {{ request()->routeIs('admin.registrations.*') ? 'bg-sun text-ink border-2 border-sun shadow-[2px_2px_0px_0px_#fff]' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <span class="text-lg">✅</span>
            Registrations
        </a>
    </nav>

    <div class="border-t-2 border-white/20 px-3 py-3 space-y-3">
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" class="flex w-full items-center gap-3 rounded-lg border-2 border-coral px-3 py-2 text-sm font-bold text-coral hover:bg-coral hover:text-white transition-all">
                <span class="text-lg">🚪</span>
                Keluar
            </button>
        </form>
        <p class="px-3 text-xs font-semibold text-white/40">{{ auth()->user()->name ?? 'Admin' }}</p>
    </div>
</aside>
