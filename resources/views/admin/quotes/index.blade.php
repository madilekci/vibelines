@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-4">
    <form method="GET" class="flex gap-4 mb-10">
        <div class="flex-1">
            <input type="text" name="search" class="form-input w-full p-2 border border-gray-300 rounded-md" placeholder="Search..." value="{{ request('search') }}">
        </div>
        <div class="flex-1">
            <select name="approved" class="form-select w-full p-2 border border-gray-300 rounded-md">
                <option value="" {{ request('approved') === null ? 'selected' : '' }}>All</option>
                <option value="1" {{ request('approved') === '1' ? 'selected' : '' }}>Approved</option>
                <option value="0" {{ request('approved') === '0' ? 'selected' : '' }}>Unapproved</option>
            </select>
        </div>
        <div class="flex items-center gap-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Filter</button>
            <a href="{{ route('admin.quotes.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">Reset</a>
        </div>
    </form>

    <table class="min-w-full table-auto border-collapse">
        <thead>
            <tr>
                <th class="px-4 py-2 border-b">Text</th>
                <th class="px-4 py-2 border-b">Author</th>
                <th class="px-4 py-2 border-b">Approved</th>
                <th class="px-4 py-2 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($quotes as $quote)
                <tr>
                    <td class="px-4 py-2 border-b">{{ $quote->text }}</td>
                    <td class="px-4 py-2 border-b">{{ $quote->author }}</td>
                    <td class="px-4 py-2 border-b">{{ $quote->approved ? '✅' : '❌' }}</td>
                    <td class="px-4 py-2 border-b">
                        <div class="flex gap-2">
                            <!-- Toggle Approval Button -->
                            <form action="{{ route('admin.quotes.toggle', $quote->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-sm px-3 py-1 rounded-md {{ $quote->approved ? 'bg-yellow-400 text-gray-800' : 'bg-green-500 text-white' }}">
                                    {{ $quote->approved ? 'Unapprove' : 'Approve' }}
                                </button>
                            </form>

                            <form action="{{ route('admin.quotes.destroy', $quote->id) }}" method="POST" onsubmit="return confirm('Delete this quote?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm px-3 py-1 rounded-md bg-red-500 text-white hover:bg-red-600">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4">No quotes found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $quotes->links() }}
    </div>
</div>
@endsection