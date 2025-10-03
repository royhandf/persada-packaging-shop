@props(['metric', 'title', 'value', 'format' => 'number'])

@php
    $iconMap = [
        'revenue' => ['heroicon-o-wallet', 'green'],
        'orders' => ['heroicon-o-shopping-bag', 'blue'],
        'products' => ['heroicon-o-archive-box', 'amber'],
        'aov' => ['heroicon-o-calculator', 'purple'],
        'shipping' => ['heroicon-o-truck', 'gray'],
    ];
    [$icon, $color] = $iconMap[$metric] ?? ['heroicon-o-question-mark-circle', 'gray'];

    $colorClasses = [
        'green' => ['bg-green-100', 'text-green-600', 'dark:bg-green-500/20', 'dark:text-green-400'],
        'blue' => ['bg-blue-100', 'text-blue-600', 'dark:bg-blue-500/20', 'dark:text-blue-400'],
        'amber' => ['bg-amber-100', 'text-amber-600', 'dark:bg-amber-500/20', 'dark:text-amber-400'],
        'purple' => ['bg-purple-100', 'text-purple-600', 'dark:bg-purple-500/20', 'dark:text-purple-400'],
        'gray' => ['bg-gray-100', 'text-gray-600', 'dark:bg-gray-600/20', 'dark:text-gray-400'],
    ];
    [$bgColor, $textColor, $darkBgColor, $darkTextColor] = $colorClasses[$color];
@endphp

<div
    class="relative flex flex-col justify-between overflow-hidden rounded-lg bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg dark:bg-gray-800">
    <div>
        <div class="flex items-start justify-between">
            <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">{{ $title }}</dt>
            <div @class(['rounded-lg p-2', $bgColor, $darkBgColor])>
                @svg($icon, ['class' => "h-5 w-5 $textColor $darkTextColor"])
            </div>
        </div>

        <div class="mt-2">
            <dd>
                <div class="flex items-baseline gap-x-2">
                    @if ($format === 'currency')
                        <span class="text-sm font-semibold text-gray-500 dark:text-gray-400">Rp</span>
                        <span
                            class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ number_format($value, 0, ',', '.') }}</span>
                    @else
                        <span
                            class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ number_format($value, 0, ',', '.') }}</span>
                    @endif
                </div>
            </dd>
        </div>
    </div>
</div>
