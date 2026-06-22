<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use App\Models\Registration;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $totalEvents = Event::count();
        $totalParticipants = Participant::count();
        $totalRegistrations = Registration::count();
        $activeEvents = Event::where('status', 'upcoming')
            ->where('event_date', '>', now())
            ->count();

        $recentRegistrations = Registration::with(['event', 'participant'])
            ->latest()
            ->take(5)
            ->get();

        $upcomingEvents = Event::where('status', 'upcoming')
            ->where('event_date', '>', now())
            ->withCount('registrations')
            ->orderBy('event_date')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalEvents',
            'totalParticipants',
            'totalRegistrations',
            'activeEvents',
            'recentRegistrations',
            'upcomingEvents'
        ));
    }
}
