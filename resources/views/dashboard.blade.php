@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="relative overflow-hidden border-2 border-black bg-white p-6 shadow-[5px_5px_0px_0px_#000] hover:shadow-[3px_3px_0px_0px_#000] hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
            <div class="absolute top-0 right-0 -mt-6 -mr-6 h-28 w-28 rounded-full bg-sun/20"></div>
            <div class="relative">
                <svg class="h-10 w-10 text-ink" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <div class="mt-4">
                    <p class="text-xs font-extrabold uppercase tracking-widest text-ink/50">Total Events</p>
                    <p class="mt-1 text-5xl font-black tracking-tighter text-ink">{{ $totalEvents ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="relative overflow-hidden border-2 border-black bg-white p-6 shadow-[5px_5px_0px_0px_#000] hover:shadow-[3px_3px_0px_0px_#000] hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
            <div class="absolute top-0 right-0 -mt-6 -mr-6 h-28 w-28 rounded-full bg-mint/20"></div>
            <div class="relative">
                <svg class="h-10 w-10 text-ink" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <div class="mt-4">
                    <p class="text-xs font-extrabold uppercase tracking-widest text-ink/50">Total Participants</p>
                    <p class="mt-1 text-5xl font-black tracking-tighter text-ink">{{ $totalParticipants ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="relative overflow-hidden border-2 border-black bg-white p-6 shadow-[5px_5px_0px_0px_#000] hover:shadow-[3px_3px_0px_0px_#000] hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
            <div class="absolute top-0 right-0 -mt-6 -mr-6 h-28 w-28 rounded-full bg-coral/20"></div>
            <div class="relative">
                <svg class="h-10 w-10 text-ink" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                <div class="mt-4">
                    <p class="text-xs font-extrabold uppercase tracking-widest text-ink/50">Total Registrations</p>
                    <p class="mt-1 text-5xl font-black tracking-tighter text-ink">{{ $totalRegistrations ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="relative overflow-hidden border-2 border-black bg-white p-6 shadow-[5px_5px_0px_0px_#000] hover:shadow-[3px_3px_0px_0px_#000] hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
            <div class="absolute top-0 right-0 -mt-6 -mr-6 h-28 w-28 rounded-full bg-sun/20"></div>
            <div class="relative">
                <svg class="h-10 w-10 text-ink" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <div class="mt-4">
                    <p class="text-xs font-extrabold uppercase tracking-widest text-ink/50">Active Events</p>
                    <p class="mt-1 text-5xl font-black tracking-tighter text-ink">{{ $activeEvents ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 border-2 border-black bg-white shadow-[5px_5px_0px_0px_#000]">
            <div class="flex items-center justify-between border-b-2 border-black px-6 py-4">
                <h2 class="text-base font-extrabold text-ink uppercase tracking-tighter">Recent Registrations</h2>
                <a href="{{ route('admin.registrations.index') }}" class="text-sm font-extrabold text-ink underline hover:opacity-60 transition-opacity">View all →</a>
            </div>
            <div class="overflow-x-auto">
                @if (isset($recentRegistrations) && count($recentRegistrations) > 0)
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-black bg-ink text-white">
                                <th class="px-6 py-3 text-left text-xs font-extrabold uppercase tracking-wider">Event</th>
                                <th class="px-6 py-3 text-left text-xs font-extrabold uppercase tracking-wider">Participant</th>
                                <th class="px-6 py-3 text-left text-xs font-extrabold uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2 divide-black">
                            @foreach ($recentRegistrations as $registration)
                                <tr class="hover:bg-sun/20 transition-colors">
                                    <td class="whitespace-nowrap px-6 py-3 text-sm font-bold text-ink">{{ $registration->event->title ?? '—' }}</td>
                                    <td class="whitespace-nowrap px-6 py-3 text-sm font-semibold text-ink/70">{{ $registration->participant->name ?? '—' }}</td>
                                    <td class="whitespace-nowrap px-6 py-3 text-sm font-semibold text-ink/50">{{ $registration->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <svg class="h-12 w-12 text-ink/20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        <p class="mt-3 text-sm font-extrabold text-ink/40 uppercase">Belum ada data</p>
                        <p class="mt-1 text-xs font-semibold text-ink/30">Registrasi akan muncul di sini</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="border-2 border-black bg-white shadow-[5px_5px_0px_0px_#000]">
            <div class="flex items-center justify-between border-b-2 border-black px-6 py-4">
                <h2 class="text-base font-extrabold text-ink uppercase tracking-tighter">Upcoming Events</h2>
                <a href="{{ route('admin.events.index') }}" class="text-sm font-extrabold text-ink underline hover:opacity-60 transition-opacity">View all →</a>
            </div>
            <div class="divide-y-2 divide-black">
                @if (isset($upcomingEvents) && count($upcomingEvents) > 0)
                    @foreach ($upcomingEvents as $event)
                        <div class="px-6 py-4 hover:bg-sun/10 transition-colors">
                            <a href="{{ route('admin.events.show', $event) }}" class="block">
                                <p class="text-sm font-extrabold text-ink truncate">{{ $event->title }}</p>
                                <div class="mt-1 flex items-center gap-3 text-xs font-bold text-ink/50">
                                    <span> {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</span>
                                    <span> {{ $event->registrations_count ?? 0 }}</span>
                                </div>
                                <div class="mt-2 flex items-center gap-2">
                                    <div class="h-2 flex-1 overflow-hidden border border-black bg-gray-200">
                                        <div class="h-full bg-sun transition-all" style="width: {{ $event->quota > 0 ? min(($event->registrations_count ?? 0) / $event->quota * 100, 100) : 0 }}%"></div>
                                    </div>
                                    <span class="text-xs font-extrabold text-ink/70">{{ $event->registrations_count ?? 0 }}/{{ $event->quota }}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <svg class="h-12 w-12 text-ink/20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        <p class="mt-3 text-sm font-extrabold text-ink/40 uppercase">Belum ada data</p>
                        <p class="mt-1 text-xs font-semibold text-ink/30">Event mendatang akan muncul di sini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
