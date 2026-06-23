@extends('layouts.admin')

@section('title', 'New Registration')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.registrations.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-ink/50 font-bold hover:text-ink transition-colors">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>
    </div>

    <div class="border-2 border-black bg-white shadow-[6px_6px_0px_0px_#000]">
        <div class="border-b border-black px-6 py-4">
            <h2 class="text-lg font-extrabold text-ink">New Registration</h2>
            <p class="mt-0.5 text-sm text-ink/50 font-bold">Register a participant to an event.</p>
        </div>

        <form action="{{ route('admin.registrations.store') }}" method="POST" class="px-6 py-5 space-y-5">
            @csrf

            <div>
                <label for="event_id" class="block text-sm font-bold text-ink mb-1.5">Event</label>
                <select name="event_id" id="event_id"
                        class="block w-full rounded-none border-black shadow-[4px_4px_0px_0px_#000] focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-sm @error('event_id') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror">
                    <option value="">Select an event</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                            {{ $event->title }} — {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                        </option>
                    @endforeach
                </select>
                @error('event_id')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="participant_id" class="block text-sm font-bold text-ink mb-1.5">Participant</label>
                <select name="participant_id" id="participant_id"
                        class="block w-full rounded-none border-black shadow-[4px_4px_0px_0px_#000] focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-sm @error('participant_id') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror">
                    <option value="">Select a participant</option>
                    @foreach($participants as $participant)
                        <option value="{{ $participant->id }}" {{ old('participant_id') == $participant->id ? 'selected' : '' }}>
                            {{ $participant->name }} — {{ $participant->email }}
                        </option>
                    @endforeach
                </select>
                @error('participant_id')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.registrations.index') }}"
                   class="rounded-none border border-black bg-white px-4 py-2 text-sm font-bold text-ink hover:bg-sun/10 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="rounded-none bg-indigo-600 px-4 py-2 text-sm font-bold text-white hover:bg-black hover:text-white transition-colors">
                    Save Registration
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
