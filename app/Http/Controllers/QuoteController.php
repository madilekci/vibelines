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

    public function adminIndex()
    {
        $quotes = Quote::latest()->get();
        return view('admin.quotes.index', compact('quotes'));
    }

    public function toggleApproval(Quote $quote)
    {
        $quote->approved = !$quote->approved;
        $quote->save();

        return redirect()->route('quotes.admin')->with('status', 'Quote updated.');
    }

    public function destroy(Quote $quote)
    {
        $quote->delete();
        return redirect()->route('quotes.admin')->with('status', 'Quote deleted.');
    }
}
