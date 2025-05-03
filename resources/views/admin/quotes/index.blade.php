@extends('layouts.app')

<div class="container">
    <h1>Quote Moderation</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Text</th>
                <th>Author</th>
                <th>Approved</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($quotes as $quote)
                <tr>
                    <td>{{ $quote->text }}</td>
                    <td>{{ $quote->author }}</td>
                    <td>{{ $quote->approved ? '✅' : '❌' }}</td>
                    <td>
                        <form action="{{ route('quotes.toggleApproval', $quote) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                {{ $quote->approved ? 'Disapprove' : 'Approve' }}
                            </button>
                        </form>

                        <form action="{{ route('quotes.destroy', $quote) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this quote?')">🗑 Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>