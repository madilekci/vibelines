@extends('layouts.app')

@section('content')
    {{-- Quote Submission Form --}}
    <form action="{{ route('quotes.store') }}" method="POST" class="mb-8 bg-white p-4 rounded shadow">
        @csrf
        <div class="mb-4">
            <label for="text" class="block font-bold mb-1">Your Quote</label>
            <textarea name="text" id="text" rows="3" class="w-full border rounded p-2" required></textarea>
        </div>
        <div class="mb-4">
            <label for="author" class="block font-bold mb-1">Author (optional)</label>
            <input type="text" name="author" id="author" class="w-full border rounded p-2">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit Quote</button>
    </form>

    {{-- Display Quotes --}}
    @foreach ($quotes as $quote)
        <div class="bg-white p-4 mb-4 rounded shadow">
            <p class="text-lg mb-2">"{{ $quote->text }}"</p>
            @if ($quote->author)
                <p class="text-sm text-gray-600">— {{ $quote->author }}</p>
            @endif

            {{-- Emoji Reaction Buttons --}}
            <div class="mt-4 flex space-x-2">
                @php
                    $emojis = ['😂', '😍', '🔥', '😢', '😡'];
                    $reactionCounts = $quote->reactions->groupBy('emoji')->map->count();
                @endphp

                @foreach ($emojis as $emoji)
                    <form action="{{ route('reactions.store', $quote->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="emoji" value="{{ $emoji }}">
                        <button type="submit" class="px-2 py-1 border rounded hover:bg-gray-100">
                            {{ $emoji }} {{ $reactionCounts[$emoji] ?? 0 }}
                        </button>
                    </form>
                @endforeach
            </div>
        </div>
    @endforeach
@endsection