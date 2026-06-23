@extends('layouts.admin')

@section('title', $participant->name)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.participants.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-ink/50 font-bold hover:text-ink transition-colors">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>
    </div>

    <div class="border-2 border-black bg-white shadow-[5px_5px_0px_0px_#000] mb-6">
        <div class="border-b border-black px-6 py-4 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-extrabold text-ink">{{ $participant->name }}</h2>
                <p class="mt-0.5 text-sm text-ink/50 font-bold">Participant Details</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.participants.edit', $participant) }}"
                   class="inline-flex items-center gap-1.5 rounded-lg border border-black bg-white px-3 py-1.5 text-sm font-bold text-ink hover:bg-sun/20 transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <form method="POST" action="{{ route('admin.participants.destroy', $participant) }}" class="inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                            onclick="confirmDelete(this)"
                            class="inline-flex items-center gap-1.5 rounded-lg border border-red-300 bg-white px-3 py-1.5 text-sm font-bold text-red-600 hover:bg-coral/20 transition-colors">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="px-6 py-5">
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wider text-ink/40">Name</dt>
                    <dd class="mt-1 text-sm font-bold text-ink">{{ $participant->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wider text-ink/40">Email</dt>
                    <dd class="mt-1 text-sm text-ink">{{ $participant->email }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wider text-ink/40">NIM</dt>
                    <dd class="mt-1 text-sm font-mono text-ink">{{ $participant->nim ?: '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wider text-ink/40">Jurusan</dt>
                    <dd class="mt-1 text-sm text-ink">{{ $participant->jurusan ?: '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wider text-ink/40">Phone</dt>
                    <dd class="mt-1 text-sm text-ink">{{ $participant->phone ?: '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wider text-ink/40">Registered Since</dt>
                    <dd class="mt-1 text-sm text-ink">{{ $participant->created_at->format('d M Y, H:i') }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <div class="border-2 border-black bg-white shadow-[5px_5px_0px_0px_#000]">
        <div class="border-b border-black px-6 py-4">
            <h3 class="text-base font-extrabold text-ink">Registered Events</h3>
        </div>

        @php
            $registeredEvents = $participant->registrations ?? collect();
        @endphp

        @if($registeredEvents->isEmpty())
            <div class="flex flex-col items-center justify-center py-12">
                <svg class="h-12 w-12 text-ink/20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="mt-3 text-sm text-ink/40">No registered events yet</p>
            </div>
        @else
            <div class="overflow-hidden">
                <table class="min-w-full divide-y-2 divide-black">
                    <thead class="bg-ink text-white">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-extrabold uppercase tracking-wider text-ink/50 font-bold">Event</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-extrabold uppercase tracking-wider text-ink/50 font-bold">Date</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-extrabold uppercase tracking-wider text-ink/50 font-bold">Location</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-extrabold uppercase tracking-wider text-ink/50 font-bold">Status</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-extrabold uppercase tracking-wider text-ink/50 font-bold">Registered</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-black">
                        @foreach($registeredEvents as $registration)
                            <tr class="hover:bg-sun/20 transition-colors">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-bold text-ink">
                                    {{ $registration->event->title ?? '—' }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-ink/70">
                                    {{ optional($registration->event)->event_date ? \Carbon\Carbon::parse($registration->event->event_date)->format('d M Y') : '—' }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-ink/70">
                                    {{ $registration->event->location ?? '—' }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @php
                                        $status = optional($registration->event)->status ?? '—';
                                    @endphp
                                    @if($status === 'upcoming')
                                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-bold text-blue-700">Upcoming</span>
                                    @elseif($status === 'ongoing')
                                        <span class="inline-flex items-center rounded-full bg-mint/20 px-2.5 py-0.5 text-xs font-bold text-emerald-700">Ongoing</span>
                                    @elseif($status === 'completed')
                                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-bold text-ink/70">Completed</span>
                                    @elseif($status === 'cancelled')
                                        <span class="inline-flex items-center rounded-full bg-coral/20 px-2.5 py-0.5 text-xs font-bold text-ink">Cancelled</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-bold text-ink/70">{{ $status }}</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-ink/70">
                                    {{ $registration->created_at->format('d M Y, H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
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
                <h3 class="text-lg font-extrabold text-ink">Delete Participant</h3>
                <p class="mt-0.5 text-sm text-ink/50 font-bold">Are you sure you want to delete this participant? This action cannot be undone.</p>
            </div>
        </div>
        <div class="mt-6 flex justify-end gap-3">
            <button type="button" onclick="document.getElementById('delete-modal').classList.add('hidden')"
                    class="rounded-lg border border-black bg-white px-4 py-2 text-sm font-bold text-ink hover:bg-sun/20 transition-colors">
                Cancel
            </button>
            <button type="button" id="confirm-delete-btn"
                    class="rounded-lg bg-red-600 px-4 py-2 text-sm font-bold text-white hover:bg-red-700 transition-colors">
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
