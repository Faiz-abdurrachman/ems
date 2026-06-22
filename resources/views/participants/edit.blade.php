@extends('layouts.admin')

@section('title', 'Edit Participant: ' . $participant->name)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.participants.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 transition-colors">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="border-b border-gray-200 px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-900">Edit Participant</h2>
            <p class="mt-0.5 text-sm text-gray-500">Update participant information.</p>
        </div>

        <form action="{{ route('admin.participants.update', $participant) }}" method="POST" class="px-6 py-5 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $participant->name) }}"
                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-sm @error('name') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                       placeholder="Enter participant name">
                @error('name')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $participant->email) }}"
                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-sm @error('email') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                       placeholder="email@example.com">
                @error('email')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">Phone</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $participant->phone) }}"
                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-sm @error('phone') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                       placeholder="Enter phone number">
                @error('phone')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.participants.index') }}"
                   class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 transition-colors">
                    Update Participant
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
