<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Http\Requests\StoreParticipantRequest;
use App\Http\Requests\UpdateParticipantRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ParticipantController extends Controller
{
    public function index(): View
    {
        $participants = Participant::withCount('registrations')
            ->when(request('search'), fn($q) => $q->where('name', 'like', '%'.request('search').'%')
                ->orWhere('email', 'like', '%'.request('search').'%'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('participants.index', compact('participants'));
    }

    public function create(): View
    {
        return view('participants.create');
    }

    public function store(StoreParticipantRequest $request): RedirectResponse
    {
        Participant::create($request->validated());

        return redirect()
            ->route('participants.index')
            ->with('success', 'Peserta berhasil ditambahkan.');
    }

    public function show(Participant $participant): View
    {
        $participant->load(['registrations.event']);

        return view('participants.show', compact('participant'));
    }

    public function edit(Participant $participant): View
    {
        return view('participants.edit', compact('participant'));
    }

    public function update(UpdateParticipantRequest $request, Participant $participant): RedirectResponse
    {
        $participant->update($request->validated());

        return redirect()
            ->route('participants.index')
            ->with('success', 'Data peserta berhasil diperbarui.');
    }

    public function destroy(Participant $participant): RedirectResponse
    {
        $participant->delete();

        return redirect()
            ->route('participants.index')
            ->with('success', 'Peserta berhasil dihapus.');
    }
}
