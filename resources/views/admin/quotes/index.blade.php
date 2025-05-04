@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Quotes Admin</h1>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <select name="approved" class="form-select">
                <option value="" {{ request('approved') === null ? 'selected' : '' }}>All</option>
                <option value="1" {{ request('approved') === '1' ? 'selected' : '' }}>Approved</option>
                <option value="0" {{ request('approved') === '0' ? 'selected' : '' }}>Unapproved</option>
            </select>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.quotes.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Text</th>
                <th>Author</th>
                <th>Approved</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($quotes as $quote)
                <tr>
                    <td>{{ $quote->text }}</td>
                    <td>{{ $quote->author }}</td>
                    <td>{{ $quote->approved ? '✅' : '❌' }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <!-- Toggle Approval Button -->
                            <form action="{{ route('admin.quotes.toggle', $quote->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $quote->approved ? 'btn-warning' : 'btn-success' }}">
                                    {{ $quote->approved ? 'Unapprove' : 'Approve' }}
                                </button>
                            </form>

                            <form action="{{ route('admin.quotes.destroy', $quote->id) }}" method="POST" onsubmit="return confirm('Delete this quote?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No quotes found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="mt-4">
            {{ $quotes->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection