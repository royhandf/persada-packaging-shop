@props(['active' => 'profile'])

<nav class="space-y-1">
    <a href="{{ route('customer.profile.index') }}"
        class="{{ $active === 'profile' ? 'bg-persada-primary/10 text-persada-primary' : 'text-gray-700 hover:bg-gray-100' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors">
        <x-heroicon-o-user-circle class="h-6 w-6 mr-3" />
        <span class="truncate">Profil Saya</span>
    </a>
    <a href="{{ route('customer.profile.address.index') }}"
        class="{{ $active === 'address' ? 'bg-persada-primary/10 text-persada-primary' : 'text-gray-700 hover:bg-gray-100' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors">
        <x-heroicon-o-map-pin class="h-6 w-6 mr-3" />
        <span class="truncate">Alamat</span>
    </a>
    <a href="#"
        class="{{ $active === 'orders' ? 'bg-persada-primary/10 text-persada-primary' : 'text-gray-700 hover:bg-gray-100' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors">
        <x-heroicon-o-shopping-bag class="h-6 w-6 mr-3" />
        <span class="truncate">Pesanan Saya</span>
    </a>
</nav>
