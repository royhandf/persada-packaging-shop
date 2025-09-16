@props(['items'])

<nav aria-label="Breadcrumb" class="mb-8">
    <ol role="list" class="flex items-center space-x-2 text-sm">
        @foreach ($items as $index => $item)
            <li>
                <div class="flex items-center">
                    @if ($index > 0)
                        <x-heroicon-o-chevron-right class="h-5 w-5 flex-shrink-0 text-gray-300" />
                    @endif

                    @if (isset($item['url']))
                        <a href="{{ $item['url'] }}"
                            class="ml-2 text-gray-500 hover:text-gray-700">{{ $item['text'] }}</a>
                    @else
                        <span class="ml-2 text-gray-800 font-medium">{{ $item['text'] }}</span>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav>
