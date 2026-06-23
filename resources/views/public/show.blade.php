@extends('layouts.public')

@section('content')
<div class="mx-auto max-w-4xl px-6">
    <div class="mb-6">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-ink/50 font-bold hover:text-ink transition-colors">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke daftar event
        </a>
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            @if($event->image)
                <img src="{{ asset('storage/'.$event->image) }}" alt="{{ $event->title }}" class="w-full rounded-none object-cover max-h-96">
            @else
                <div class="flex h-64 w-full items-center justify-center rounded-none bg-gradient-to-br from-indigo-50 to-indigo-100">
                    <svg class="h-16 w-16 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            @endif

            <h1 class="text-2xl font-bold text-ink">{{ $event->title }}</h1>

            <div class="flex flex-wrap gap-3">
                <span class="inline-flex items-center gap-1.5 rounded-none bg-blue-50 px-3 py-1.5 text-sm font-bold text-blue-700">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y, H:i') }}
                </span>
                <span class="inline-flex items-center gap-1.5 rounded-none bg-gray-100 px-3 py-1.5 text-sm font-bold text-ink">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $event->location }}
                </span>
                <span class="inline-flex items-center gap-1.5 rounded-none px-3 py-1.5 text-sm font-bold {{ $event->registrations_count >= $event->quota ? 'bg-coral/20 text-ink' : 'bg-mint/20 text-emerald-700' }}">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    {{ $event->registrations_count }} / {{ $event->quota }} Terdaftar
                </span>
            </div>

            @if($event->description)
                <div class="prose prose-sm max-w-none text-ink/70">
                    <p>{{ $event->description }}</p>
                </div>
            @endif
        </div>

        <div>
            <div class="sticky top-24 rounded-none border border-black bg-white p-6 shadow-[4px_4px_0px_0px_#000]">
                <h2 class="text-lg font-extrabold text-ink">Daftar Event Ini</h2>

                @if(now()->gt($event->event_date))
                    <div class="mt-4 rounded-none bg-gray-50 p-4 text-center text-sm text-ink/50 font-bold">Event telah berakhir</div>
                @elseif($event->registrations_count >= $event->quota)
                    <div class="mt-4 rounded-none bg-coral/20 p-4 text-center text-sm font-bold text-ink">Kuota sudah penuh</div>
                @else
                    <form method="POST" action="{{ route('events.register', $event) }}" class="mt-4 space-y-4">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-bold text-ink">Nama Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="mt-1 block w-full rounded-none border-black shadow-[4px_4px_0px_0px_#000] focus:bg-sun/20 focus:outline-none sm:text-sm {{ $errors->has('name') ? 'border-red-300' : '' }}"
                                placeholder="Masukkan nama Anda">
                            @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-bold text-ink">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                class="mt-1 block w-full rounded-none border-black shadow-[4px_4px_0px_0px_#000] focus:bg-sun/20 focus:outline-none sm:text-sm {{ $errors->has('email') ? 'border-red-300' : '' }}"
                                placeholder="Masukkan email Anda">
                            @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-bold text-ink">Telepon <span class="text-ink/40 font-normal">(opsional)</span></label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                class="mt-1 block w-full rounded-none border-black shadow-[4px_4px_0px_0px_#000] focus:bg-sun/20 focus:outline-none sm:text-sm {{ $errors->has('phone') ? 'border-red-300' : '' }}"
                                placeholder="08xxxxxxxxxx">
                            @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        @error('event')<p class="text-sm text-red-600 font-bold">{{ $message }}</p>@enderror
                        <button type="submit" class="w-full rounded-none bg-indigo-600 px-4 py-2.5 text-sm font-extrabold text-white shadow-[4px_4px_0px_0px_#000] hover:bg-black hover:text-white transition-colors">Daftar Sekarang</button>
                    </form>
                @endif

                <div class="mt-4 space-y-1 text-xs text-ink/40 text-center">
                    <p>Gratis & terbuka untuk umum</p>
                    <p>Data Anda aman bersama kami</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
