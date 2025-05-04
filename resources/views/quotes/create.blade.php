@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen">

    <div class="bg-white shadow-lg rounded-xl w-146 p-12">
        <h5 class="text-2xl font-semibold text-primary mb-6">Submit a New Quote</h5>
        <form action="{{ route('quotes.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="text" class="block text-sm font-medium text-gray-700">Your Quote</label>
                <textarea name="text" id="text" rows="4" class="form-textarea mt-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required></textarea>
            </div>
            <div class="mb-4 py-2">
                <label for="author" class="block text-sm font-medium text-gray-700">Author (optional)</label>
                <input type="text" name="author" id="author" class="form-input mt-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2">
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Submit Quote</button>
        </form>
    </div>

</div>
@endsection