<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Event::withCount('registrations')
            ->when(request('search'), fn($q) => $q->where('title', 'like', '%'.request('search').'%')
                ->orWhere('location', 'like', '%'.request('search').'%'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('events.index', compact('events'));
    }

    public function create(): View
    {
        return view('events.create');
    }

    public function store(StoreEventRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        Event::create($data);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event berhasil dibuat.');
    }

    public function show(Event $event): View
    {
        $event->load(['registrations.participant']);
        $event->loadCount('registrations');

        return view('events.show', compact('event'));
    }

    public function edit(Event $event): View
    {
        return view('events.edit', compact('event'));
    }

    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $data = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($data);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event berhasil dihapus.');
    }
}
