<li class="nav-item">
    <a
        class="nav-link {{ $attributes->get('active') ? 'text-blue-500' : 'text-gray-700' }} hover:text-blue-700"
        href="{{ $attributes->get('href') }}">
        {{ $slot }}
    </a>
</li>