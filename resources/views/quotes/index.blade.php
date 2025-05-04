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

            {{-- Copy Quote Button --}}
            <button class="btn btn-outline-primary btn-sm" id="copyButton">
                <i class="bi bi-clipboard"></i> Copy
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
                                console.log('Quote copied!');
                            }).catch(function (error) {
                                console.error('Copy failed:', error);
                                console.log('Failed to copy the quote!');
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
                                    console.log('Quote copied!');
                                } else {
                                    console.log('Failed to copy the quote!');
                                }
                            } catch (err) {
                                console.error('Error using execCommand:', err);
                                console.log('Failed to copy the quote!');
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
            <a href="{{ route('home') }}" class="btn btn-secondary btn-lg">See New</a>
        </div>
    </div>

</div>
@endsection