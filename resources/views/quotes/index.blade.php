@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen" id="quoteContainer">

    <div class="bg-white shadow-lg rounded-xl w-96 p-6">
        <div class="text-center">
            <h5 class="text-2xl font-semibold text-primary mb-6">Quote of the Moment</h5>

            <blockquote class="italic text-lg mb-6">
                <p class="text-xl">{{ $quote->text }}</p>
                @if ($quote->author)
                    <footer class="text-sm text-gray-600">{{ $quote->author }}</footer>
                @endif
            </blockquote>

            {{-- Total Reactions Count --}}
            <p class="mb-6">
                <strong class="text-lg">Total Reactions:</strong>
                <span class="bg-yellow-300 text-gray-800 px-3 py-1 rounded-full text-sm">{{ $quote->reactions_count }}</span>
            </p>

            {{-- Reaction Buttons --}}
            <div class="flex justify-around mb-6">
                @php
                    $emojis = ['😂', '😍', '🔥', '😢', '😡'];
                @endphp

                @foreach ($emojis as $emoji)
                    <form action="{{ route('reactions.store', $quote->id) }}" method="POST" class="inline-block">
                        @csrf
                        <input type="hidden" name="emoji" value="{{ $emoji }}">
                        <button type="submit" class="btn btn-outline-secondary btn-sm px-3 py-2 transition-all hover:bg-gray-100 hover:border-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            <span style="font-size: 2rem; cursor: pointer;">{{ $emoji }}</span>
                        </button>
                    </form>
                @endforeach
            </div>

            {{-- Copy Quote Button --}}
<button class="w-full bg-blue-500 text-white font-semibold rounded-lg py-3 mb-6 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer" id="copyButton">
    <i class="bi bi-clipboard mr-2"></i> Copy Quote
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
            <a href="{{ route('home') }}" class="w-full bg-gray-500 text-white font-semibold rounded-lg py-3 px-6 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 text-center">
                See New Quote
            </a>
        </div>
    </div>

</div>
@endsection