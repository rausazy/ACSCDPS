<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;

class StocksController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('stockable')
            ->get()
            ->sortBy(function ($stock) {
                return strtolower($stock->stockable->name);
            });

        return view('stocks.stocks', compact('stocks'));
    }

    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $stock->update([
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('stocks.stocks')->with('success', 'Stock updated!');
    }
}
