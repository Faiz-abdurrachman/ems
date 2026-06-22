<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use App\Models\Registration;
use App\Http\Requests\StoreRegistrationRequest;
use App\Http\Requests\UpdateRegistrationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
        $events = Event::where('status', 'upcoming')
            ->where('event_date', '>', now())
            ->withCount('registrations')
            ->orderBy('event_date')->get();
        $participants = Participant::orderBy('name')->get();

        return view('registrations.create', compact('events', 'participants'));
    }

    public function store(StoreRegistrationRequest $request): RedirectResponse
    {
        $event = Event::findOrFail($request->event_id);

        if (now()->gt($event->event_date)) {
            return back()->withErrors(['event_id' => 'Event sudah berakhir.'])->withInput();
        }

        if ($event->registrations()->count() >= $event->quota) {
            return back()->withErrors(['event_id' => 'Kuota event sudah penuh.'])->withInput();
        }

        Registration::create([
            'event_id' => $request->event_id,
            'participant_id' => $request->participant_id,
            'registration_date' => now(),
        ]);

        return redirect()
            ->route('admin.registrations.index')
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
            ->route('admin.registrations.index')
            ->with('success', 'Registrasi berhasil diperbarui.');
    }

    public function destroy(Registration $registration): RedirectResponse
    {
        $registration->delete();

        return redirect()
            ->route('admin.registrations.index')
            ->with('success', 'Registrasi berhasil dihapus.');
    }

    public function toggleAttendance(Registration $registration): RedirectResponse
    {
        $registration->update([
            'attended_at' => $registration->attended_at ? null : now(),
        ]);

        $status = $registration->attended_at ? 'Hadir' : 'Batal hadir';

        return back()->with('success', 'Status kehadiran diperbarui: '.$status.'.');
    }

    public function checkIn(Event $event): View
    {
        $event->load(['registrations' => fn($q) => $q->with('participant')->orderBy('created_at')]);

        $attended = $event->registrations->whereNotNull('attended_at')->count();
        $total = $event->registrations->count();

        return view('registrations.check-in', compact('event', 'attended', 'total'));
    }

    public function export(Event $event): StreamedResponse
    {
        $event->load(['registrations.participant']);

        $fileName = 'daftar-peserta-'.str($event->title)->slug().'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
        ];

        $callback = function () use ($event) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Nama', 'Email', 'Telepon', 'Tanggal Daftar', 'Kehadiran']);

            foreach ($event->registrations as $i => $reg) {
                fputcsv($file, [
                    $i + 1,
                    $reg->participant->name ?? '—',
                    $reg->participant->email ?? '—',
                    $reg->participant->phone ?? '—',
                    $reg->registration_date->format('d M Y, H:i'),
                    $reg->attended_at ? 'Hadir ('.$reg->attended_at->format('d M Y, H:i').')' : 'Belum hadir',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
