<aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-20 flex w-64 flex-col bg-ink bg-stripes text-white border-r-2 border-black transition-transform lg:translate-x-0 -translate-x-full">
    <div class="flex h-14 items-center gap-3 px-5 border-b-2 border-white/20">
        <div class="sticker flex h-9 w-9 items-center justify-center border-2 border-electric bg-electric">
            <span class="text-sm font-extrabold text-ink">E</span>
        </div>
        <span class="text-lg font-extrabold uppercase tracking-tighter text-white">EMS</span>
    </div>

    <nav class="flex-1 space-y-1 px-3 py-4">
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-3 py-2 text-sm font-extrabold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-flame text-white shadow-[3px_3px_0px_0px_#fff]' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1"/></svg>
            Dashboard
        </a>

        <a href="{{ route('admin.events.index') }}"
           class="flex items-center gap-3 px-3 py-2 text-sm font-extrabold transition-all {{ request()->routeIs('admin.events.*') ? 'bg-cyan text-ink shadow-[3px_3px_0px_0px_#fff]' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Events
        </a>

        <a href="{{ route('admin.participants.index') }}"
           class="flex items-center gap-3 px-3 py-2 text-sm font-extrabold transition-all {{ request()->routeIs('admin.participants.*') ? 'bg-lavender text-ink shadow-[3px_3px_0px_0px_#fff]' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            Participants
        </a>

        <a href="{{ route('admin.registrations.index') }}"
           class="flex items-center gap-3 px-3 py-2 text-sm font-extrabold transition-all {{ request()->routeIs('admin.registrations.*') ? 'bg-mint text-ink shadow-[3px_3px_0px_0px_#fff]' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            Registrations
        </a>
    </nav>

    <div class="border-t-2 border-white/20 px-3 py-3 space-y-3">
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" class="flex w-full items-center gap-3 border-2 border-coral px-3 py-2 text-sm font-extrabold text-coral hover:bg-coral hover:text-white transition-all">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Keluar
            </button>
        </form>
        <p class="px-3 text-xs font-bold text-white/40">{{ auth()->user()->name ?? 'Admin' }}</p>
    </div>
</aside>
