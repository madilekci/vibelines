<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Reaction;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    public function store(Request $request, Quote $quote)
    {
        $request->validate([
            'emoji' => 'required|string|max:10',
        ]);

        Reaction::create([
            'quote_id' => $quote->id,
            'emoji' => $request->input('emoji'),
        ]);

        return redirect()->back();
    }
}
