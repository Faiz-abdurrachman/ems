@extends('layouts.admin')

@section('title', 'Create Event')

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('admin.events.index') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-ink/50 font-bold hover:text-ink transition-colors">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Events
        </a>
    </div>

    <div class="border-2 border-black bg-white shadow-[6px_6px_0px_0px_#000]">
        <div class="border-b border-black px-6 py-5">
            <h2 class="text-lg font-extrabold text-ink">Create New Event</h2>
            <p class="mt-1 text-sm text-ink/50 font-bold">Fill in the details below to create a new event.</p>
        </div>

        <form action="{{ route('admin.events.store') }}" method="POST" class="px-6 py-5 space-y-5" enctype="multipart/form-data">
            @csrf

            <div>
                <label for="image" class="block text-sm font-bold text-ink">Poster Event <span class="text-ink/40 font-normal">(opsional)</span></label>
                <input type="file" name="image" id="image" accept="image/*"
                    class="mt-1 block w-full text-sm text-ink/50 font-bold file:mr-4 file:py-2 file:px-4 file:rounded-none file:border-0 file:text-sm file:font-extrabold file:bg-sun file:text-ink file:text-ink hover:file:bg-black hover:file:text-white {{ $errors->has('image') ? 'border-red-300' : '' }}">
                @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="title" class="block text-sm font-bold text-ink">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                    class="mt-1 block w-full rounded-none border-black shadow-[4px_4px_0px_0px_#000] focus:bg-sun/20 focus:outline-none sm:text-sm {{ $errors->has('title') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : '' }}"
                    placeholder="Enter event title" required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-bold text-ink">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="mt-1 block w-full rounded-none border-black shadow-[4px_4px_0px_0px_#000] focus:bg-sun/20 focus:outline-none sm:text-sm {{ $errors->has('description') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : '' }}"
                    placeholder="Enter event description">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="event_date" class="block text-sm font-bold text-ink">Event Date</label>
                <input type="datetime-local" name="event_date" id="event_date" value="{{ old('event_date') }}"
                    class="mt-1 block w-full rounded-none border-black shadow-[4px_4px_0px_0px_#000] focus:bg-sun/20 focus:outline-none sm:text-sm {{ $errors->has('event_date') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : '' }}"
                    required>
                @error('event_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="location" class="block text-sm font-bold text-ink">Location</label>
                <input type="text" name="location" id="location" value="{{ old('location') }}"
                    class="mt-1 block w-full rounded-none border-black shadow-[4px_4px_0px_0px_#000] focus:bg-sun/20 focus:outline-none sm:text-sm {{ $errors->has('location') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : '' }}"
                    placeholder="Enter event location" required>
                @error('location')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="quota" class="block text-sm font-bold text-ink">Quota</label>
                <input type="number" name="quota" id="quota" value="{{ old('quota') }}" min="1"
                    class="mt-1 block w-full rounded-none border-black shadow-[4px_4px_0px_0px_#000] focus:bg-sun/20 focus:outline-none sm:text-sm {{ $errors->has('quota') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : '' }}"
                    placeholder="Enter maximum participants" required>
                @error('quota')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category_id" class="block text-sm font-bold text-ink">Kategori</label>
                <select name="category_id" id="category_id"
                    class="mt-1 block w-full rounded-none border-black shadow-[4px_4px_0px_0px_#000] focus:bg-sun/20 focus:outline-none sm:text-sm">
                    <option value="">Tanpa Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-bold text-ink">Status</label>
                <select name="status" id="status"
                    class="mt-1 block w-full rounded-none border-black shadow-[4px_4px_0px_0px_#000] focus:bg-sun/20 focus:outline-none sm:text-sm {{ $errors->has('status') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : '' }}">
                    <option value="upcoming" {{ old('status') == 'upcoming' ? 'selected' : '' }}>Akan Datang</option>
                    <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Berlangsung</option>
                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 border-t border-black pt-5">
                <a href="{{ route('admin.events.index') }}" class="inline-flex items-center justify-center rounded-none border border-black bg-white px-4 py-2.5 text-sm font-bold text-ink shadow-[4px_4px_0px_0px_#000] hover:bg-sun/10 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-none bg-indigo-600 px-4 py-2.5 text-sm font-extrabold text-white shadow-[4px_4px_0px_0px_#000] hover:bg-black hover:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                    Create Event
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
