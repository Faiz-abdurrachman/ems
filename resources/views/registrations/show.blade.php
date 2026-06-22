@extends('layouts.admin')

@section('title', 'Registration Detail')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.registrations.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 transition-colors">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Registration Detail</h2>
                <p class="mt-0.5 text-sm text-gray-500">Registration #{{ $registration->id }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.registrations.edit', $registration) }}"
                   class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <form method="POST" action="{{ route('admin.registrations.destroy', $registration) }}" class="inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                            onclick="confirmDelete(this)"
                            class="inline-flex items-center gap-1.5 rounded-lg border border-red-300 bg-white px-3 py-1.5 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="px-6 py-5">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="rounded-lg border border-gray-100 bg-gray-50/50 p-4">
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-3">Event</h3>
                    <a href="{{ route('admin.events.show', $registration->event) }}" class="block group">
                        <p class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">
                            {{ $registration->event->title ?? '—' }}
                        </p>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ optional($registration->event)->event_date ? \Carbon\Carbon::parse($registration->event->event_date)->format('d M Y') : '—' }}
                        </p>
                        <p class="mt-0.5 text-sm text-gray-500">
                            {{ $registration->event->location ?? '—' }}
                        </p>
                    </a>
                </div>

                <div class="rounded-lg border border-gray-100 bg-gray-50/50 p-4">
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-3">Participant</h3>
                    <a href="{{ route('admin.participants.show', $registration->participant) }}" class="block group">
                        <p class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">
                            {{ $registration->participant->name ?? '—' }}
                        </p>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ $registration->participant->email ?? '—' }}
                        </p>
                        <p class="mt-0.5 text-sm text-gray-500">
                            {{ $registration->participant->phone ?? '—' }}
                        </p>
                    </a>
                </div>
            </div>

            <div class="mt-6 rounded-lg border border-gray-100 bg-gray-50/50 p-4">
                <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Registration Date</h3>
                <p class="text-sm text-gray-900">{{ $registration->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>
    </div>
</div>

<div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-sm rounded-xl bg-white p-6 shadow-2xl">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-100">
                <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Delete Registration</h3>
                <p class="mt-0.5 text-sm text-gray-500">Are you sure you want to delete this registration? This action cannot be undone.</p>
            </div>
        </div>
        <div class="mt-6 flex justify-end gap-3">
            <button type="button" onclick="document.getElementById('delete-modal').classList.add('hidden')"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                Cancel
            </button>
            <button type="button" id="confirm-delete-btn"
                    class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 transition-colors">
                Delete
            </button>
        </div>
    </div>
</div>

<script>
    let deleteForm = null;

    function confirmDelete(button) {
        deleteForm = button.closest('form');
        document.getElementById('delete-modal').classList.remove('hidden');
        document.getElementById('delete-modal').classList.add('flex');
    }

    document.getElementById('confirm-delete-btn').addEventListener('click', () => {
        if (deleteForm) {
            deleteForm.submit();
        }
    });
</script>
@endsection
