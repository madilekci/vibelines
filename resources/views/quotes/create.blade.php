@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Submit a New Quote</h5>
            <form action="{{ route('quotes.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="text" class="form-label">Your Quote</label>
                    <textarea name="text" id="text" rows="4" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="author" class="form-label">Author (optional)</label>
                    <input type="text" name="author" id="author" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">Submit Quote</button>
            </form>
        </div>
    </div>
</div>
@endsection