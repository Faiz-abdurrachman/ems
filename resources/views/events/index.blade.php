@extends('layouts.admin')

@section('title', 'Events')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Events</h2>
            <p class="mt-1 text-sm text-gray-500">Kelola semua event dan pantau pendaftaran</p>
        </div>
        <a href="{{ route('admin.events.create') }}"
            class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Event
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="flex flex-col gap-3 border-b border-gray-100 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
            <form method="GET" action="{{ route('admin.events.index') }}" class="relative w-full sm:max-w-xs">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari event..."
                    class="block w-full rounded-lg border-gray-300 pl-10 pr-10 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    autocomplete="off">
                @if(request('search'))
                    <a href="{{ route('admin.events.index') }}" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600" aria-label="Hapus pencarian">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </a>
                @endif
            </form>
            @if(isset($categories) && $categories->isNotEmpty())
                <div class="flex flex-wrap gap-1.5">
                    <a href="{{ route('admin.events.index') }}" class="rounded-full px-3 py-1 text-xs font-medium {{ !request('category') ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition-colors">Semua</a>
                    @foreach($categories as $cat)
                        <a href="{{ route('admin.events.index', ['category' => $cat->id]) }}" class="rounded-full px-3 py-1 text-xs font-medium {{ request('category') == $cat->id ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition-colors">{{ $cat->name }}</a>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="overflow-x-auto">
            @if (isset($events) && count($events) > 0)
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/50 sticky top-0 z-10">
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Location</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Quota</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Registrations</th>
                            <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($events as $event)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $loop->iteration + (($events->currentPage() ?? 1) - 1) * ($events->perPage() ?? 10) }}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <a href="{{ route('admin.events.show', $event) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">
                                        {{ $event->title }}
                                    </a>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                    {{ $event->event_date ? \Carbon\Carbon::parse($event->event_date)->format('d M Y, H:i') : '—' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 max-w-[160px] truncate" title="{{ $event->location }}">{{ $event->location }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $event->quota }}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'upcoming' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
                                            'ongoing' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                                            'completed' => 'bg-gray-100 text-gray-700 ring-gray-500/20',
                                            'cancelled' => 'bg-red-50 text-red-700 ring-red-600/20',
                                        ];
                                        $statusLabels = [
                                            'upcoming' => 'Akan Datang',
                                            'ongoing' => 'Berlangsung',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan',
                                        ];
                                        $color = $statusColors[$event->status] ?? $statusColors['upcoming'];
                                        $label = $statusLabels[$event->status] ?? $event->status;
                                    @endphp
                                    <span class="inline-flex items-center rounded-md px-2 py-0.5 text-xs font-medium ring-1 ring-inset {{ $color }}">
                                        {{ $label }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                    <span class="{{ ($event->registrations_count ?? 0) >= $event->quota ? 'text-red-600' : 'text-gray-900' }}">
                                        {{ $event->registrations_count ?? 0 }} / {{ $event->quota }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.events.show', $event) }}"
                                            class="inline-flex items-center justify-center rounded-md p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors"
                                            aria-label="Lihat event">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.events.edit', $event) }}"
                                            class="inline-flex items-center justify-center rounded-md p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors"
                                            aria-label="Edit event">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                onclick="confirmDelete(this)"
                                                class="inline-flex items-center justify-center rounded-md p-1.5 text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors"
                                                aria-label="Hapus event">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
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
            @else
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <svg class="h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h3 class="mt-4 text-sm font-semibold text-gray-900">Event tidak ditemukan</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ request('search') ? 'Tidak ada event yang cocok dengan pencarian Anda.' : 'Mulai dengan membuat event pertama Anda.' }}
                    </p>
                    @if (!request('search'))
                        <a href="{{ route('admin.events.create') }}"
                            class="mt-4 inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition-colors">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Event
                        </a>
                    @endif
                </div>
            @endif
        </div>

        @if (isset($events) && method_exists($events, 'links'))
            <div class="border-t border-gray-100 px-6 py-3">
                {{ $events->links() }}
            </div>
        @endif
    </div>
</div>

<div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-sm rounded-xl bg-white p-6 shadow-2xl">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-100">
                <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Hapus Event</h3>
                <p class="mt-0.5 text-sm text-gray-500">Anda yakin ingin menghapus event ini? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
        </div>
        <div class="mt-6 flex justify-end gap-3">
            <button type="button" onclick="document.getElementById('delete-modal').classList.add('hidden')"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                Batal
            </button>
            <button type="button" id="confirm-delete-btn"
                class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 transition-colors">
                Hapus
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
        if (deleteForm) deleteForm.submit();
    });
</script>
@endsection
