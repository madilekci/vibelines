@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center vh-100" id="quoteContainer">

    <div class="card shadow-lg rounded-4" style="width: 24rem;">
        <div class="card-body text-center">
            <h5 class="card-title mb-4 text-primary">Quote of the Moment</h5>

            <blockquote class="blockquote mb-4" style="font-style: italic;">
                <p class="lead">{{ $quote->text }}</p>
                @if ($quote->author)
                    <footer class="blockquote-footer text-muted">{{ $quote->author }}</footer>
                @endif
            </blockquote>

            {{-- Total Reactions Count --}}
            <p class="mb-3">
                <strong>Total Reactions:</strong>
                <span class="badge bg-warning text-dark">{{ $quote->reactions_count }}</span>
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
                        <button type="submit" class="btn btn-outline-secondary btn-sm px-3 py-2">
                            <span style="font-size: 1.5rem;">{{ $emoji }}</span>
                        </button>
                    </form>
                @endforeach
            </div>

            {{-- Copy Quote Button --}}
            <button class="btn btn-outline-primary btn-lg mb-3" id="copyButton" style="font-size: 1.1rem; width: 100%; padding: 0.75rem;">
                <i class="bi bi-clipboard"></i> Copy Quote
            </button>

            {{-- Copy quote script --}}
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const copyButton = document.getElementById('copyButton');
                    copyButton.addEventListener('click', function () {
                        const quoteText = "{{ $quote->text }}";  // Dynamically fetch the quote text

                        // Decode HTML entities (e.g., &#039; -> ')
                        const decodedText = decodeHTML(quoteText);

                        // Check if Clipboard API is supported
                        if (navigator.clipboard) {
                            navigator.clipboard.writeText(decodedText).then(function () {
                                alert('Quote copied to clipboard!');
                            }).catch(function (error) {
                                console.error('Copy failed:', error);
                                alert('Failed to copy the quote!');
                            });
                        } else {
                            // Fallback for older browsers using execCommand
                            const textArea = document.createElement('textarea');
                            textArea.value = decodedText;
                            document.body.appendChild(textArea);
                            textArea.select();
                            try {
                                const successful = document.execCommand('copy');
                                if (successful) {
                                    alert('Quote copied to clipboard!');
                                } else {
                                    alert('Failed to copy the quote!');
                                }
                            } catch (err) {
                                console.error('Error using execCommand:', err);
                                alert('Failed to copy the quote!');
                            }
                            document.body.removeChild(textArea);
                        }
                    });
                });

                // Function to decode HTML entities
                function decodeHTML(html) {
                    var txt = document.createElement('textarea');
                    txt.innerHTML = html;
                    return txt.value;
                }
            </script>

            {{-- See New Quote Button --}}
            <a href="{{ route('home') }}" class="btn btn-secondary btn-lg mt-4" style="width: 100%; padding: 0.75rem;">
                See New Quote
            </a>
        </div>
    </div>

</div>
@endsection