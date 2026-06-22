@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="relative overflow-hidden rounded-xl border border-gray-200 bg-white p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-indigo-50 opacity-50"></div>
            <div class="relative">
                <div class="flex items-center justify-between">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100">
                        <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm font-medium text-gray-500">Total Events</p>
                    <p class="mt-1 text-3xl font-bold tracking-tight text-gray-900">{{ $totalEvents ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="relative overflow-hidden rounded-xl border border-gray-200 bg-white p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-emerald-50 opacity-50"></div>
            <div class="relative">
                <div class="flex items-center justify-between">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100">
                        <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm font-medium text-gray-500">Total Participants</p>
                    <p class="mt-1 text-3xl font-bold tracking-tight text-gray-900">{{ $totalParticipants ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="relative overflow-hidden rounded-xl border border-gray-200 bg-white p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-amber-50 opacity-50"></div>
            <div class="relative">
                <div class="flex items-center justify-between">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100">
                        <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm font-medium text-gray-500">Total Registrations</p>
                    <p class="mt-1 text-3xl font-bold tracking-tight text-gray-900">{{ $totalRegistrations ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="relative overflow-hidden rounded-xl border border-gray-200 bg-white p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-rose-50 opacity-50"></div>
            <div class="relative">
                <div class="flex items-center justify-between">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-rose-100">
                        <svg class="h-6 w-6 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm font-medium text-gray-500">Active Events</p>
                    <p class="mt-1 text-3xl font-bold tracking-tight text-gray-900">{{ $activeEvents ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                <h2 class="text-base font-semibold text-gray-900">Recent Registrations</h2>
                <a href="{{ route('admin.registrations.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors">View all</a>
            </div>
            <div class="overflow-x-auto">
                @if (isset($recentRegistrations) && count($recentRegistrations) > 0)
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Event</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Participant</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($recentRegistrations as $registration)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900">{{ $registration->event->title ?? '—' }}</td>
                                    <td class="whitespace-nowrap px-6 py-3 text-sm text-gray-600">{{ $registration->participant->name ?? '—' }}</td>
                                    <td class="whitespace-nowrap px-6 py-3 text-sm text-gray-500">{{ $registration->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <svg class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p class="mt-3 text-sm font-medium text-gray-500">Belum ada data</p>
                        <p class="mt-1 text-xs text-gray-400">Registrasi akan muncul di sini</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                <h2 class="text-base font-semibold text-gray-900">Upcoming Events</h2>
                <a href="{{ route('admin.events.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors">View all</a>
            </div>
            <div class="divide-y divide-gray-50">
                @if (isset($upcomingEvents) && count($upcomingEvents) > 0)
                    @foreach ($upcomingEvents as $event)
                        <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                            <a href="{{ route('admin.events.show', $event) }}" class="block">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $event->title }}</p>
                                <div class="mt-1 flex items-center gap-3 text-xs text-gray-500">
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                                    </span>
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        {{ $event->registrations_count ?? 0 }}
                                    </span>
                                </div>
                                <div class="mt-2 flex items-center gap-2">
                                    <div class="h-1.5 flex-1 overflow-hidden rounded-full bg-gray-100">
                                        <div class="h-full rounded-full bg-indigo-500 transition-all" style="width: {{ $event->quota > 0 ? min(($event->registrations_count ?? 0) / $event->quota * 100, 100) : 0 }}%"></div>
                                    </div>
                                    <span class="text-xs font-medium text-gray-500">{{ $event->registrations_count ?? 0 }}/{{ $event->quota }}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <svg class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="mt-3 text-sm font-medium text-gray-500">Belum ada data</p>
                        <p class="mt-1 text-xs text-gray-400">Event mendatang akan muncul di sini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
