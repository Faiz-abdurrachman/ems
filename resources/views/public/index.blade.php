@extends('layouts.public')

@section('content')
<div class="mx-auto max-w-7xl px-6">
    <div class="text-center mb-10">
        <h1 class="text-3xl font-black tracking-tighter text-ink sm:text-4xl highlight inline-block px-2">Event Kampus</h1>
        <p class="mt-3 text-lg text-ink/70 font-bold">Daftar event mendatang yang bisa kamu ikuti</p>
        <form method="GET" action="{{ route('home') }}" class="mt-6 mx-auto max-w-md relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-5 w-5 text-ink/60" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari event..."
                class="block w-full rounded-none border-2 border-black pl-10 pr-4 py-2.5 text-sm font-bold shadow-[4px_4px_0px_0px_#000] focus:bg-blue-50 focus:outline-none">
            @if(request('search'))
                <a href="{{ route('home') }}" class="absolute inset-y-0 right-0 flex items-center pr-3 text-ink/60 hover:text-ink/70" aria-label="Hapus pencarian">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </a>
            @endif
        </form>
    </div>

    @if(isset($categories) && $categories->isNotEmpty())
        <div class="mx-auto max-w-7xl px-6 -mt-4 mb-6">
            <div class="flex flex-wrap justify-center gap-2">
                <a href="{{ route('home') }}" class="rounded-none px-4 py-1.5 text-xs font-bold {{ !request('category') ? 'bg-gradient-to-r from-cyan-300 to-cyan-500 text-ink' : 'bg-white border-2 border-black text-ink/70 hover:bg-gray-100' }} transition-colors">Semua</a>
                @foreach($categories as $cat)
                    <a href="{{ route('home', ['category' => $cat->id]) }}" class="rounded-none px-4 py-1.5 text-xs font-bold {{ request('category') == $cat->id ? 'bg-gradient-to-r from-cyan-300 to-cyan-500 text-ink' : 'bg-white border-2 border-black text-ink/70 hover:bg-gray-100' }} transition-colors">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>
    @endif

    @if($events->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <svg class="h-16 w-16 text-ink/20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <h3 class="mt-4 text-lg font-extrabold text-ink">Belum ada event</h3>
            <p class="mt-1 text-ink/70 font-bold">Event mendatang akan muncul di sini.</p>
        </div>
    @else
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($events as $event)
                <a href="{{ route('events.show', $event) }}" class="group block border-2 border-black bg-white shadow-[6px_6px_0px_0px_#000] hover:shadow-[3px_3px_0px_0px_#000] hover:translate-x-[3px] hover:translate-y-[3px] transition-all overflow-hidden">
                    @if($event->image)
                        <img src="{{ asset('storage/'.$event->image) }}" alt="{{ $event->title }}" class="h-48 w-full object-cover">
                    @else
                        <div class="flex h-48 w-full items-center justify-center bg-gradient-to-br from-cyan-100 to-cyan-200">
                            <svg class="h-12 w-12 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                    <div class="p-5">
                        <h3 class="text-base font-extrabold text-ink group-hover:text-ink transition-colors line-clamp-2">{{ $event->title }}</h3>
                        <div class="mt-3 flex items-center gap-4 text-xs text-ink/70 font-bold">
                            <span class="inline-flex items-center gap-1">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                            </span>
                            <span class="inline-flex items-center gap-1">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $event->location }}
                            </span>
                        </div>
                        <div class="mt-3 flex items-center gap-2">
                            <div class="h-2 flex-1 overflow-hidden border border-black bg-gray-200">
                                <div class="h-full {{ ($event->registrations_count >= $event->quota) ? 'bg-gradient-to-r from-red-300 to-red-500' : 'bg-gradient-to-r from-cyan-300 to-cyan-600' }} transition-all" style="width: {{ $event->quota > 0 ? min($event->registrations_count / $event->quota * 100, 100) : 0 }}%"></div>
                            </div>
                            <span class="text-xs font-bold {{ ($event->registrations_count >= $event->quota) ? 'text-red-600' : 'text-ink/70 font-bold' }}">{{ $event->registrations_count }}/{{ $event->quota }}</span>
                        </div>
                        @if($event->registrations_count >= $event->quota)
                            <span class="sticker mt-2 inline-flex items-center border-2 border-black bg-gradient-to-r from-red-300 to-red-500 px-2.5 py-0.5 text-xs font-extrabold text-white">Kuota Penuh</span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-8">
            {{ $events->links() }}
        </div>
    @endif
</div>
@endsection
