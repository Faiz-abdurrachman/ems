<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Event::with(['category'])
            ->withCount('registrations')
            ->when(request('search'), fn($q) => $q->where('title', 'like', '%'.request('search').'%')
                ->orWhere('location', 'like', '%'.request('search').'%'))
            ->when(request('category'), fn($q) => $q->where('category_id', request('category')))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('events.index', compact('events', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('events.create', compact('categories'));
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
        $event->load(['registrations.participant', 'category']);
        $event->loadCount('registrations');

        return view('events.show', compact('event'));
    }

    public function edit(Event $event): View
    {
        $categories = Category::orderBy('name')->get();

        return view('events.edit', compact('event', 'categories'));
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
