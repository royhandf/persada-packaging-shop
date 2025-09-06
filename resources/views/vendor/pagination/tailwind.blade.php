@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-600">
                    Showing
                    <span class="font-medium">{{ $paginator->firstItem() }}</span>
                    to
                    <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    of
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    results
                </p>
            </div>

            <div>
                <span class="inline-flex items-center space-x-1">
                    {{-- Previous --}}
                    @if ($paginator->onFirstPage())
                        <span
                            class="w-9 h-9 flex items-center justify-center text-gray-400 bg-gray-200 rounded-md cursor-not-allowed">
                            <x-heroicon-s-chevron-left class="w-4 h-4" />
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}"
                            class="w-9 h-9 flex items-center justify-center text-gray-600 bg-white rounded-md hover:bg-gray-100 shadow-sm">
                            <x-heroicon-s-chevron-left class="w-4 h-4" />
                        </a>
                    @endif

                    {{-- Pages --}}
                    @foreach ($elements as $element)
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span
                                        class="w-9 h-9 flex items-center justify-center text-sm font-semibold text-white bg-green-600 rounded-md shadow-sm">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                        class="w-9 h-9 flex items-center justify-center text-sm text-gray-600 bg-white rounded-md hover:bg-gray-100 shadow-sm">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}"
                            class="w-9 h-9 flex items-center justify-center text-gray-600 bg-white rounded-md hover:bg-gray-200 shadow-sm">
                            <x-heroicon-s-chevron-right class="w-4 h-4" />
                        </a>
                    @else
                        <span
                            class="w-9 h-9 flex items-center justify-center text-gray-400 bg-gray-200 rounded-md cursor-not-allowed">
                            <x-heroicon-s-chevron-right class="w-4 h-4" />
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
