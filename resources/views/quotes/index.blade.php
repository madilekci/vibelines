@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center vh-100">

    <div class="card shadow-lg" style="width: 24rem;">
        <div class="card-body text-center">
            <h5 class="card-title mb-4">Quote of the Moment</h5>
            <blockquote class="blockquote mb-4">
                <p class="lead">“{{ $quote->text }}”</p>
                @if ($quote->author)
                    <footer class="blockquote-footer text-muted">{{ $quote->author }}</footer>
                @endif
            </blockquote>

            {{-- Total Reactions Count --}}
            <p class="mb-3">
                <strong>Total Reactions:</strong> <span class="badge bg-primary">{{ $quote->reactions_count }}</span>
            </p>

            {{-- Reaction Buttons --}}
            <div class="d-flex justify-content-around mb-4">
                @php
                    $emojis = ['😂', '😍', '🔥', '😢', '😡'];
                @endphp

                @foreach ($emojis as $emoji)
                    <form action="{{ route('reactions.store', $quote->id) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="emoji" value="{{ $emoji }}">
                        <button type="submit" class="btn btn-outline-primary btn-sm px-3 py-2">
                            <span style="font-size: 1.5rem;">{{ $emoji }}</span>
                        </button>
                    </form>
                @endforeach
            </div>

            {{-- See New Quote Button --}}
            <a href="{{ route('home') }}" class="btn btn-secondary btn-lg">See New</a>
        </div>
    </div>

</div>
@endsection