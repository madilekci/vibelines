{{-- Navbar --}}
<nav class="bg-white shadow-sm">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <a class="text-xl font-semibold text-gray-800" href="{{ route('home') }}">VibeLines</a>
        <button class="lg:hidden text-gray-700" type="button" aria-label="Toggle navigation" id="navbarToggler">
            <span class="block w-6 h-0.5 bg-gray-800 mb-1"></span>
            <span class="block w-6 h-0.5 bg-gray-800 mb-1"></span>
            <span class="block w-6 h-0.5 bg-gray-800"></span>
        </button>
        <div class="lg:flex flex-grow items-center hidden" id="navbarNav">
            <ul class="flex space-x-6 ml-auto">
                <x-navlink href="{{ route('home') }}" :active="request()->routeIs('home')">Home</x-navlink>
                <x-navlink href="{{ route('quotes.create') }}" :active="request()->routeIs('quotes.create')">Submit Quote</x-navlink>
                <x-navlink href="{{ route('admin.quotes.index') }}" :active="request()->routeIs('admin.quotes.index')">Admin</x-navlink>
            </ul>
        </div>
    </div>
</nav>