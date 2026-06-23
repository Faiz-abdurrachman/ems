@extends('layouts.admin')

@section('title', $event->title)

@section('content')
<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('admin.events.index') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-ink/70 font-bold hover:text-ink transition-colors">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Events
        </a>

        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('admin.events.check-in', $event) }}"
                class="inline-flex items-center gap-1.5 rounded-none border border-emerald-300 bg-white px-3.5 py-2 text-sm font-bold text-emerald-700 shadow-[4px_4px_0px_0px_#000] hover:bg-mint/20 transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Presensi
            </a>
            <a href="{{ route('admin.events.export', $event) }}"
                class="inline-flex items-center gap-1.5 rounded-none border border-indigo-300 bg-white px-3.5 py-2 text-sm font-bold text-ink shadow-[4px_4px_0px_0px_#000] hover:bg-indigo-50 transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export CSV
            </a>
            <a href="{{ route('admin.events.edit', $event) }}"
                class="inline-flex items-center gap-1.5 rounded-none border border-black bg-white px-3.5 py-2 text-sm font-bold text-ink shadow-[4px_4px_0px_0px_#000] hover:bg-cyan/10 transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="inline delete-form">
                @csrf
                @method('DELETE')
                <button type="button" onclick="confirmDelete(this)"
                    class="inline-flex items-center gap-1.5 rounded-none border border-red-300 bg-white px-3.5 py-2 text-sm font-bold text-red-600 shadow-[4px_4px_0px_0px_#000] hover:bg-coral/20 transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="overflow-hidden border-2 border-black bg-white shadow-[6px_6px_0px_0px_#000]">
        <div class="px-6 py-5 border-b border-black">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <h2 class="text-xl font-bold text-ink">{{ $event->title }}</h2>
                    <div class="mt-1 flex items-center gap-2">
                        @php
                            $statusColors = [
                                'upcoming' => 'bg-cyan',
                                'ongoing' => 'bg-mint',
                                'completed' => 'bg-gray-300',
                                'cancelled' => 'bg-coral',
                            ];
                            $statusLabels = [
                                'upcoming' => 'Akan Datang',
                                'ongoing' => 'Berlangcyang',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                            ];
                            $color = $statusColors[$event->status] ?? $statusColors['upcoming'];
                            $label = $statusLabels[$event->status] ?? $event->status;
                        @endphp
                        <span class="sticker inline-flex items-center border-2 border-black px-2.5 py-0.5 text-xs font-extrabold text-ink {{ $color }}">
                            {{ $label }}
                        </span>
                        @if($event->category)
                            <span class="inline-flex items-center rounded-md px-2 py-0.5 text-xs font-bold ring-1 ring-inset bg-purple-50 text-purple-700 ring-purple-600/20">{{ $event->category->name }}</span>
                        @endif
                        <span class="text-sm text-ink/70 font-bold">
                            {{ $event->registrations_count ?? 0 }} / {{ $event->quota }} terdaftar
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 py-5">
            <dl class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wider text-ink/70 font-bold">Event Date</dt>
                    <dd class="mt-1 text-sm text-ink">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y, H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wider text-ink/70 font-bold">Location</dt>
                    <dd class="mt-1 text-sm text-ink">{{ $event->location }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wider text-ink/70 font-bold">Kuota</dt>
                    <dd class="mt-1 text-sm text-ink">{{ $event->quota }} peserta</dd>
                </div>
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wider text-ink/70 font-bold">Jumlah Registrasi</dt>
                    <dd class="mt-1 text-sm font-extrabold text-ink">{{ $event->registrations_count ?? 0 }} / {{ $event->quota }}</dd>
                </div>
                @if ($event->description)
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-bold uppercase tracking-wider text-ink/70 font-bold">Deskripsi</dt>
                        <dd class="mt-1 text-sm text-ink whitespace-pre-wrap">{{ $event->description }}</dd>
                    </div>
                @endif
            </dl>
        </div>

        @if ($event->quota > 0)
            <div class="border-t border-black px-6 py-3">
                <div class="flex items-center gap-3">
                    <span class="text-xs font-bold text-ink/70 font-bold">Progres registrasi</span>
                    <div class="h-2 flex-1 overflow-hidden rounded-none bg-gray-100">
                        <div class="h-full rounded-none bg-cyan transition-all"
                            style="width: {{ min((($event->registrations_count ?? 0) / $event->quota) * 100, 100) }}%"></div>
                    </div>
                    <span class="text-xs font-extrabold text-ink">{{ round(min((($event->registrations_count ?? 0) / $event->quota) * 100, 100)) }}%</span>
                </div>
            </div>
        @endif
    </div>

    <div class="border-2 border-black bg-white shadow-[6px_6px_0px_0px_#000]">
        <div class="flex items-center justify-between border-b border-black px-6 py-4">
            <h3 class="text-base font-extrabold text-ink">Peserta Terdaftar</h3>
            <span class="text-sm text-ink/70 font-bold">{{ $event->registrations->count() }} registered</span>
        </div>

        <div class="overflow-x-auto">
            @if ($event->registrations->count() > 0)
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-black">
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-ink/70 font-bold">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-ink/70 font-bold">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-ink/70 font-bold">Phone</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-ink/70 font-bold">Registration Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-black">
                        @foreach ($event->registrations as $reg)
                            <tr class="hover:bg-cyan/10 transition-colors">
                                <td class="whitespace-nowrap px-6 py-3 text-sm font-bold text-ink">{{ $reg->participant->name ?? '—' }}</td>
                                <td class="whitespace-nowrap px-6 py-3 text-sm text-ink/70">{{ $reg->participant->email ?? '—' }}</td>
                                <td class="whitespace-nowrap px-6 py-3 text-sm text-ink/70">{{ $reg->participant->phone ?? '—' }}</td>
                                <td class="whitespace-nowrap px-6 py-3 text-sm text-ink/70 font-bold">{{ $reg->registration_date->format('d M Y, H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <svg class="h-12 w-12 text-ink/20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <p class="mt-3 text-sm font-bold text-ink/70 font-bold">No participants registered yet</p>
                    <p class="mt-1 text-xs text-ink/60">Participants will appear here once they register</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
