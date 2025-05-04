<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index()
    {
        $quotes = Quote::where('approved', true)->with('reactions')->latest()->get();
        return view('quotes.index', compact('quotes'));
    }
    public function create()
    {
        return view('quotes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:1000',
            'author' => 'nullable|string|max:255',
        ]);

        Quote::create([
            'text' => $request->input('text'),
            'author' => $request->input('author'),
            'approved' => false, // wait for admin approval
        ]);

        return redirect()->back()->with('success', 'Quote submitted! Waiting for approval.');
    }
    public function showRandomQuote()
    {
        // Get a random quote from the database
        $quote = Quote::inRandomOrder()->first();

        return view('quotes.index', compact('quote'));
    }

    // Admin functions
    public function adminIndex(Request $request)
    {
        $query = Quote::query();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('text', 'like', "%{$search}%")
                ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Filter by approval status
        if ($request->has('approved') && $request->approved) {
            $query->where('approved', $request->approved);
        }

        // Pagination
        $quotes = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.quotes.index', compact('quotes'));
    }
    public function toggleApproval(Quote $quote)
    {
        $quote->approved = !$quote->approved;
        $quote->save();

        return redirect()->route('admin.quotes.index')->with('status', 'Quote updated.');
    }
    public function destroy(Quote $quote)
    {
        $quote->delete();
        return redirect()->route('admin.quotes.index')->with('status', 'Quote deleted.');
    }
}
