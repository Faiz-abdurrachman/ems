@extends('layouts.admin')

@section('title', 'Presensi: '.$event->title)

@section('content')
<div class="mx-auto max-w-4xl space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <a href="{{ route('admin.events.show', $event) }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke detail event
            </a>
            <h2 class="mt-2 text-xl font-bold text-gray-900">Presensi: {{ $event->title }}</h2>
            <p class="mt-1 text-sm text-gray-500">{{ $attended }} / {{ $total }} peserta telah hadir</p>
        </div>
        <div class="flex items-center gap-2">
            <div class="h-3 w-40 overflow-hidden rounded-full bg-gray-100">
                <div class="h-full rounded-full bg-emerald-500 transition-all" style="width: {{ $total > 0 ? round($attended / $total * 100) : 0 }}%"></div>
            </div>
            <span class="text-sm font-semibold text-gray-700">{{ $total > 0 ? round($attended / $total * 100) : 0 }}%</span>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            @if($event->registrations->isNotEmpty())
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">#</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($event->registrations as $reg)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="whitespace-nowrap px-6 py-3 text-sm text-gray-500">{{ $loop->iteration }}</td>
                                <td class="whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900">{{ $reg->participant->name ?? '—' }}</td>
                                <td class="whitespace-nowrap px-6 py-3 text-sm text-gray-600">{{ $reg->participant->email ?? '—' }}</td>
                                <td class="whitespace-nowrap px-6 py-3">
                                    @if($reg->attended_at)
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700">
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                            Hadir
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-500">
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Belum Hadir
                                        </span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-3 text-right">
                                    <form method="POST" action="{{ route('admin.registrations.toggle-attendance', $reg) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="rounded-lg px-3 py-1.5 text-xs font-medium {{ $reg->attended_at ? 'bg-red-50 text-red-600 hover:bg-red-100' : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-100' }} transition-colors">
                                            {{ $reg->attended_at ? 'Batalkan' : 'Tandai Hadir' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <p class="text-sm text-gray-500">Belum ada peserta terdaftar.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
