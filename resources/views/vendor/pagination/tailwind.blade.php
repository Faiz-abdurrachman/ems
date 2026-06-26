@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-bold text-ink/70">
                    Showing
                    @if ($paginator->firstItem())
                        <span class="font-extrabold text-ink">{{ $paginator->firstItem() }}</span>
                        to
                        <span class="font-extrabold text-ink">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    of
                    <span class="font-extrabold text-ink">{{ $paginator->total() }}</span>
                    results
                </p>
            </div>
        </div>

        <div class="flex flex-1 justify-between sm:justify-end gap-3">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-4 py-2 text-sm font-extrabold text-gray-500 bg-gray-200 border-2 border-gray-400 cursor-not-allowed uppercase tracking-wider">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-4 py-2 text-sm font-extrabold text-ink bg-white border-2 border-black shadow-[4px_4px_0px_0px_#000] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-[2px_2px_0px_0px_#000] transition-all uppercase tracking-wider">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-4 py-2 text-sm font-extrabold text-ink bg-white border-2 border-black shadow-[4px_4px_0px_0px_#000] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-[2px_2px_0px_0px_#000] transition-all uppercase tracking-wider">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="inline-flex items-center px-4 py-2 text-sm font-extrabold text-gray-500 bg-gray-200 border-2 border-gray-400 cursor-not-allowed uppercase tracking-wider">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>
    </nav>
@endif
