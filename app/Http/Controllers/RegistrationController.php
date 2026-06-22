<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use App\Models\Registration;
use App\Http\Requests\StoreRegistrationRequest;
use App\Http\Requests\UpdateRegistrationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function index(): View
    {
        $registrations = Registration::with(['event', 'participant'])
            ->when(request('search'), function ($q) {
                $q->whereHas('participant', fn($sub) => $sub->where('name', 'like', '%'.request('search').'%'))
                  ->orWhereHas('event', fn($sub) => $sub->where('title', 'like', '%'.request('search').'%'));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('registrations.index', compact('registrations'));
    }

    public function create(): View
    {
        $events = Event::where('status', 'upcoming')->orderBy('event_date')->get();
        $participants = Participant::orderBy('name')->get();

        return view('registrations.create', compact('events', 'participants'));
    }

    public function store(StoreRegistrationRequest $request): RedirectResponse
    {
        Registration::create([
            'event_id' => $request->event_id,
            'participant_id' => $request->participant_id,
            'registration_date' => now(),
        ]);

        return redirect()
            ->route('registrations.index')
            ->with('success', 'Peserta berhasil didaftarkan ke event.');
    }

    public function show(Registration $registration): View
    {
        $registration->load(['event', 'participant']);

        return view('registrations.show', compact('registration'));
    }

    public function edit(Registration $registration): View
    {
        $events = Event::orderBy('event_date')->get();
        $participants = Participant::orderBy('name')->get();

        return view('registrations.edit', compact('registration', 'events', 'participants'));
    }

    public function update(UpdateRegistrationRequest $request, Registration $registration): RedirectResponse
    {
        $registration->update([
            'event_id' => $request->event_id,
            'participant_id' => $request->participant_id,
        ]);

        return redirect()
            ->route('registrations.index')
            ->with('success', 'Registrasi berhasil diperbarui.');
    }

    public function destroy(Registration $registration): RedirectResponse
    {
        $registration->delete();

        return redirect()
            ->route('registrations.index')
            ->with('success', 'Registrasi berhasil dihapus.');
    }
}
