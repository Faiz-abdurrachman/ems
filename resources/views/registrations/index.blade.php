@extends('layouts.admin')

@section('title', 'Registrations')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-ink">Registrations</h2>
            <p class="mt-1 text-sm text-ink/50 font-bold">Kelola pendaftaran peserta ke event</p>
        </div>
        <a href="{{ route('admin.registrations.create') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-black hover:text-white transition-colors">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Registrasi Baru
        </a>
    </div>

    <div class="mb-6">
        <form method="GET" action="{{ route('admin.registrations.index') }}" class="relative max-w-md">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-5 w-5 text-ink/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari peserta atau event..."
                   class="block w-full rounded-lg border border-black bg-white pl-10 pr-10 py-2 text-sm text-ink placeholder:text-ink/40 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
            @if(request('search'))
                <a href="{{ route('admin.registrations.index') }}" class="absolute inset-y-0 right-0 flex items-center pr-3 text-ink/40 hover:text-ink/70" aria-label="Hapus pencarian">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </a>
            @endif
        </form>
    </div>

    @if($registrations->isEmpty())
        <div class="flex flex-col items-center justify-center border-2 border-black bg-white py-16">
            <svg class="h-12 w-12 text-ink/20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
            <p class="mt-4 text-sm text-ink/40">Belum ada registrasi</p>
            <a href="{{ route('admin.registrations.create') }}"
               class="mt-4 inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-bold text-white hover:bg-black hover:text-white transition-colors">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Create First Registration
            </a>
        </div>
    @else
        <div class="overflow-hidden border-2 border-black bg-white shadow-[5px_5px_0px_0px_#000]">
            <table class="min-w-full divide-y-2 divide-black">
                <thead class="bg-gray-50 sticky top-0 z-10">
                    <tr>
                        <th scope="col" class="w-12 px-6 py-3.5 text-left text-xs font-extrabold uppercase tracking-wider text-ink/50 font-bold">#</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-extrabold uppercase tracking-wider text-ink/50 font-bold">Participant</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-extrabold uppercase tracking-wider text-ink/50 font-bold">Event</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-extrabold uppercase tracking-wider text-ink/50 font-bold">Registration Date</th>
                        <th scope="col" class="px-6 py-3.5 text-right text-xs font-extrabold uppercase tracking-wider text-ink/50 font-bold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-black">
                    @foreach($registrations as $registration)
                        <tr class="hover:bg-sun/20 transition-colors">
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-ink/40">{{ $loop->iteration + (($registrations->currentPage() - 1) * $registrations->perPage()) }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-bold text-ink">{{ $registration->participant->name ?? '—' }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-ink/70">{{ $registration->event->title ?? '—' }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-ink/70">{{ $registration->created_at->format('d M Y, H:i') }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.registrations.show', $registration) }}"
                                       class="rounded-lg p-1.5 text-ink/40 hover:bg-sun/20 hover:text-ink/70 transition-colors"
                                       aria-label="Lihat registrasi">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.registrations.edit', $registration) }}"
                                       class="rounded-lg p-1.5 text-ink/40 hover:bg-sun/20 hover:text-ink/70 transition-colors"
                                       aria-label="Edit registrasi">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.registrations.destroy', $registration) }}" class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                onclick="confirmDelete(this)"
                                                class="rounded-lg p-1.5 text-ink/40 hover:bg-coral/20 hover:text-red-600 transition-colors"
                                                aria-label="Hapus registrasi">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $registrations->links() }}
        </div>
    @endif
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
                <h3 class="text-lg font-extrabold text-ink">Delete Registration</h3>
                <p class="mt-0.5 text-sm text-ink/50 font-bold">Are you sure you want to delete this registration? This action cannot be undone.</p>
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
