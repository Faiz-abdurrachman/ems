<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Participant;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicEventController extends Controller
{
    public function index(Request $request): View
    {
        $events = Event::where('status', 'upcoming')
            ->where('event_date', '>', now())
            ->withCount('registrations')
            ->when($request->search, fn($q) => $q->where('title', 'like', '%'.$request->search.'%'))
            ->when($request->category, fn($q) => $q->where('category_id', $request->category))
            ->orderBy('event_date')
            ->paginate(12);

        $categories = Category::orderBy('name')->get();

        return view('public.index', compact('events', 'categories'));
    }

    public function show(Event $event): View
    {
        $event->loadCount('registrations');

        return view('public.show', compact('event'));
    }

    public function register(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        if (now()->gt($event->event_date)) {
            return back()->withErrors(['event' => 'Event sudah berakhir.']);
        }

        if ($event->registrations()->count() >= $event->quota) {
            return back()->withErrors(['event' => 'Kuota event sudah penuh.']);
        }

        $participant = Participant::firstOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['name'],
                'phone' => $validated['phone'] ?? null,
            ]
        );

        $existing = Registration::where('event_id', $event->id)
            ->where('participant_id', $participant->id)
            ->exists();

        if ($existing) {
            return back()->withErrors(['email' => 'Anda sudah terdaftar di event ini.']);
        }

        Registration::create([
            'event_id' => $event->id,
            'participant_id' => $participant->id,
            'registration_date' => now(),
        ]);

        return redirect()
            ->route('home')
            ->with('success', 'Pendaftaran berhasil! Anda telah terdaftar di event "'.$event->title.'".');
    }
}
