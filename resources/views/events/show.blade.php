@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('events.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Events
        </a>

        <div class="flex items-center gap-2">
            <a href="{{ route('events.edit', $event) }}"
                class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3.5 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            <form action="{{ route('events.destroy', $event) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this event? This action cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center gap-1.5 rounded-lg border border-red-300 bg-white px-3.5 py-2 text-sm font-medium text-red-600 shadow-sm hover:bg-red-50 transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="px-6 py-5 border-b border-gray-100">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $event->title }}</h2>
                    <div class="mt-1 flex items-center gap-2">
                        @php
                            $statusColors = [
                                'upcoming' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
                                'ongoing' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                                'completed' => 'bg-gray-100 text-gray-700 ring-gray-500/20',
                                'cancelled' => 'bg-red-50 text-red-700 ring-red-600/20',
                            ];
                            $statusLabels = [
                                'upcoming' => 'Akan Datang',
                                'ongoing' => 'Berlangsung',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                            ];
                            $color = $statusColors[$event->status] ?? $statusColors['upcoming'];
                            $label = $statusLabels[$event->status] ?? $event->status;
                        @endphp
                        <span class="inline-flex items-center rounded-md px-2 py-0.5 text-xs font-medium ring-1 ring-inset {{ $color }}">
                            {{ $label }}
                        </span>
                        <span class="text-sm text-gray-500">
                            {{ $event->registrations_count ?? 0 }} / {{ $event->quota }} terdaftar
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 py-5">
            <dl class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wider text-gray-500">Event Date</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y, H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wider text-gray-500">Location</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $event->location }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wider text-gray-500">Kuota</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $event->quota }} peserta</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wider text-gray-500">Jumlah Registrasi</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $event->registrations_count ?? 0 }} / {{ $event->quota }}</dd>
                </div>
                @if ($event->description)
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-medium uppercase tracking-wider text-gray-500">Deskripsi</dt>
                        <dd class="mt-1 text-sm text-gray-700 whitespace-pre-wrap">{{ $event->description }}</dd>
                    </div>
                @endif
            </dl>
        </div>

        @if ($event->quota > 0)
            <div class="border-t border-gray-100 px-6 py-3">
                <div class="flex items-center gap-3">
                    <span class="text-xs font-medium text-gray-500">Progres registrasi</span>
                    <div class="h-2 flex-1 overflow-hidden rounded-full bg-gray-100">
                        <div class="h-full rounded-full bg-indigo-500 transition-all"
                            style="width: {{ min((($event->registrations_count ?? 0) / $event->quota) * 100, 100) }}%"></div>
                    </div>
                    <span class="text-xs font-semibold text-gray-700">{{ round(min((($event->registrations_count ?? 0) / $event->quota) * 100, 100)) }}%</span>
                </div>
            </div>
        @endif
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
            <h3 class="text-base font-semibold text-gray-900">Peserta Terdaftar</h3>
            <span class="text-sm text-gray-500">{{ $event->registrations->count() }} registered</span>
        </div>

        <div class="overflow-x-auto">
            @if ($event->registrations->count() > 0)
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Phone</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Registration Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($event->registrations as $reg)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900">{{ $reg->participant->name ?? '—' }}</td>
                                <td class="whitespace-nowrap px-6 py-3 text-sm text-gray-600">{{ $reg->participant->email ?? '—' }}</td>
                                <td class="whitespace-nowrap px-6 py-3 text-sm text-gray-600">{{ $reg->participant->phone ?? '—' }}</td>
                                <td class="whitespace-nowrap px-6 py-3 text-sm text-gray-500">{{ $reg->registration_date->format('d M Y, H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <svg class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <p class="mt-3 text-sm font-medium text-gray-500">No participants registered yet</p>
                    <p class="mt-1 text-xs text-gray-400">Participants will appear here once they register</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
