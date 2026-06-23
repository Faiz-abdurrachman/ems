@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="relative border-2 border-black bg-white shadow-[6px_6px_0px_0px_#000] hover:scale-[1.02] hover:shadow-[3px_3px_0px_0px_#000] transition-all cursor-default sticker">
            <div class="absolute -top-3 -right-3 text-lg font-black text-cyan">✦</div>
            <div class="absolute top-0 left-0 w-full h-2 bg-cyan"></div>
            <div class="p-6 pt-7">
                <svg class="h-10 w-10 text-ink" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="mt-3 text-xs font-extrabold uppercase tracking-widest text-ink/60">Total Events</p>
                <p class="mt-1 text-6xl font-black tracking-tighter text-ink highlight inline-block">{{ $totalEvents ?? 0 }}</p>
            </div>
        </div>

        <div class="relative border-2 border-black bg-white shadow-[6px_6px_0px_0px_#000] hover:scale-[1.02] hover:shadow-[3px_3px_0px_0px_#000] transition-all cursor-default">
            <div class="absolute top-0 left-0 w-full h-2 bg-mint"></div>
            <div class="p-6 pt-7">
                <svg class="h-10 w-10 text-ink" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <p class="mt-3 text-xs font-extrabold uppercase tracking-widest text-ink/60">Total Participants</p>
                <p class="mt-1 text-6xl font-black tracking-tighter text-ink">{{ $totalParticipants ?? 0 }}</p>
            </div>
        </div>

        <div class="relative border-2 border-black bg-white shadow-[6px_6px_0px_0px_#000] hover:scale-[1.02] hover:shadow-[3px_3px_0px_0px_#000] transition-all cursor-default">
            <div class="absolute top-0 left-0 w-full h-2 bg-coral"></div>
            <div class="p-6 pt-7">
                <svg class="h-10 w-10 text-ink" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                <p class="mt-3 text-xs font-extrabold uppercase tracking-widest text-ink/60">Total Registrations</p>
                <p class="mt-1 text-6xl font-black tracking-tighter text-ink">{{ $totalRegistrations ?? 0 }}</p>
            </div>
        </div>

        <div class="relative border-2 border-black bg-white shadow-[6px_6px_0px_0px_#000] hover:scale-[1.02] hover:shadow-[3px_3px_0px_0px_#000] transition-all cursor-default">
            <div class="absolute top-0 left-0 w-full h-2 bg-lavender"></div>
            <div class="p-6 pt-7">
                <svg class="h-10 w-10 text-ink" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <p class="mt-3 text-xs font-extrabold uppercase tracking-widest text-ink/60">Active Events</p>
                <p class="mt-1 text-6xl font-black tracking-tighter text-ink">{{ $activeEvents ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 border-2 border-black bg-white shadow-[6px_6px_0px_0px_#000]">
            <div class="line-through-accent px-6 py-4 border-b-2 border-black">
                <h2 class="text-base font-extrabold text-ink uppercase tracking-tighter whitespace-nowrap">Recent Registrations</h2>
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
                        <tbody>
                            @foreach ($recentRegistrations as $i => $registration)
                                <tr class="border-b border-black {{ $i % 2 == 0 ? 'bg-white' : 'bg-flame/10' }} hover:bg-flame/30 transition-colors">
                                    <td class="whitespace-nowrap px-6 py-3 text-sm font-extrabold text-ink">{{ $registration->event->title ?? '&mdash;' }}</td>
                                    <td class="whitespace-nowrap px-6 py-3 text-sm font-bold text-ink/70">{{ $registration->participant->name ?? '&mdash;' }}</td>
                                    <td class="whitespace-nowrap px-6 py-3 text-sm font-bold text-ink/70">{{ $registration->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="flex flex-col items-center justify-center py-14 text-center">
                        <svg class="h-12 w-12 text-ink/20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        <p class="mt-3 text-sm font-extrabold text-ink/50 uppercase">Belum ada data</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="border-2 border-black bg-white shadow-[6px_6px_0px_0px_#000]">
            <div class="line-through-accent px-6 py-4 border-b-2 border-black">
                <h2 class="text-base font-extrabold text-ink uppercase tracking-tighter whitespace-nowrap">Upcoming</h2>
            </div>
            <div>
                @if (isset($upcomingEvents) && count($upcomingEvents) > 0)
                    @foreach ($upcomingEvents as $event)
                        <div class="px-6 py-4 border-b border-black hover:bg-flame/10 transition-colors">
                            <a href="{{ route('admin.events.show', $event) }}" class="block">
                                <p class="text-sm font-extrabold text-ink truncate">{{ $event->title }}</p>
                                <div class="mt-1 flex items-center gap-3 text-xs font-bold text-ink/70">
                                    <span>{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</span>
                                    <span>{{ $event->registrations_count ?? 0 }} peserta</span>
                                </div>
                                <div class="mt-2 h-2 border border-black bg-gray-100">
                                    <div class="h-full bg-flame" style="width: {{ $event->quota > 0 ? min(($event->registrations_count ?? 0) / $event->quota * 100, 100) : 0 }}%"></div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="flex flex-col items-center justify-center py-14 text-center">
                        <p class="text-sm font-extrabold text-ink/50 uppercase">Belum ada event</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
