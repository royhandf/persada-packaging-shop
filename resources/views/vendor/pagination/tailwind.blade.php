@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Showing
                    <span
                        class="font-medium text-gray-900 dark:text-white">{{ $paginator->firstItem() }}-{{ $paginator->lastItem() }}</span>
                    dari
                    <span class="font-medium text-gray-900 dark:text-white">{{ $paginator->total() }}</span>
                </p>
            </div>

            <div>
                <span class="inline-flex items-center space-x-1">
                    {{-- Previous --}}
                    @if ($paginator->onFirstPage())
                        <span
                            class="w-9 h-9 flex items-center justify-center text-gray-400 bg-gray-200 rounded-md cursor-not-allowed dark:bg-gray-800 dark:text-gray-500">
                            <x-heroicon-s-chevron-left class="w-4 h-4" />
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}"
                            class="w-9 h-9 flex items-center justify-center text-gray-600 bg-white rounded-md hover:bg-gray-100 shadow-sm dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
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
                                        class="w-9 h-9 flex items-center justify-center text-sm text-gray-600 bg-white rounded-md hover:bg-gray-100 shadow-sm dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}"
                            class="w-9 h-9 flex items-center justify-center text-gray-600 bg-white rounded-md hover:bg-gray-100 shadow-sm dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                            <x-heroicon-s-chevron-right class="w-4 h-4" />
                        </a>
                    @else
                        <span
                            class="w-9 h-9 flex items-center justify-center text-gray-400 bg-gray-200 rounded-md cursor-not-allowed dark:bg-gray-800 dark:text-gray-500">
                            <x-heroicon-s-chevron-right class="w-4 h-4" />
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
