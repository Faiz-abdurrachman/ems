@extends('layouts.admin')

@section('title', 'Presensi: '.$event->title)

@section('content')
<div class="mx-auto max-w-4xl space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <a href="{{ route('admin.events.show', $event) }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-ink/70 font-bold hover:text-ink transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke detail event
            </a>
            <h2 class="mt-2 text-xl font-bold text-ink">Presensi: {{ $event->title }}</h2>
            <p class="mt-1 text-sm text-ink/70 font-bold">{{ $attended }} / {{ $total }} peserta telah hadir</p>
        </div>
        <div class="flex items-center gap-2">
            <div class="h-3 w-40 overflow-hidden rounded-none bg-gray-100">
                <div class="h-full rounded-none bg-mint/200 transition-all" style="width: {{ $total > 0 ? round($attended / $total * 100) : 0 }}%"></div>
            </div>
            <span class="text-sm font-extrabold text-ink">{{ $total > 0 ? round($attended / $total * 100) : 0 }}%</span>
        </div>
    </div>

    <div class="border-2 border-black bg-white shadow-[6px_6px_0px_0px_#000]">
        <div class="overflow-x-auto">
            @if($event->registrations->isNotEmpty())
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-black bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-extrabold uppercase tracking-wider text-ink/70 font-bold">#</th>
                            <th class="px-6 py-3 text-left text-xs font-extrabold uppercase tracking-wider text-ink/70 font-bold">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-extrabold uppercase tracking-wider text-ink/70 font-bold">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-extrabold uppercase tracking-wider text-ink/70 font-bold">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-extrabold uppercase tracking-wider text-ink/70 font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-black">
                        @foreach($event->registrations as $reg)
                            <tr class="hover:bg-mint/10 transition-colors">
                                <td class="whitespace-nowrap px-6 py-3 text-sm text-ink/70 font-bold">{{ $loop->iteration }}</td>
                                <td class="whitespace-nowrap px-6 py-3 text-sm font-bold text-ink">{{ $reg->participant->name ?? '—' }}</td>
                                <td class="whitespace-nowrap px-6 py-3 text-sm text-ink/70">{{ $reg->participant->email ?? '—' }}</td>
                                <td class="whitespace-nowrap px-6 py-3">
                                    @if($reg->attended_at)
                                        <span class="sticker inline-flex items-center border-2 border-black bg-gradient-to-r from-emerald-300 to-emerald-600 px-2.5 py-0.5 text-xs font-extrabold text-ink">
                                            HADIR
                                        </span>
                                    @else
                                        <span class="inline-flex items-center border-2 border-black bg-gray-200 px-2.5 py-0.5 text-xs font-extrabold text-ink/70">
                                            BELUM
                                        </span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-3 text-right">
                                    <form method="POST" action="{{ route('admin.registrations.toggle-attendance', $reg) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="sticker border-2 border-black px-3 py-1.5 text-xs font-extrabold {{ $reg->attended_at ? 'bg-coral text-ink hover:bg-coral/70' : 'bg-mint text-ink hover:bg-mint/70' }} transition-colors">
                                            {{ $reg->attended_at ? 'Batal' : 'Tandai Hadir' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <p class="text-sm text-ink/70 font-bold">Belum ada peserta terdaftar.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
