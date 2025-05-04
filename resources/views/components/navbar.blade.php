{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">VibeLines</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <x-navlink href="{{ route('home') }}" :active="request()->routeIs('home')">Home</x-nav-link>
                <x-navlink href="{{ route('quotes.create') }}" :active="request()->routeIs('quotes.create')">Submit Quote</x-nav-link>
                <x-navlink href="{{ route('admin.quotes.index') }}" :active="request()->routeIs('admin.quotes.index')">Admin</x-nav-link>
            </ul>
        </div>
    </div>
</nav>