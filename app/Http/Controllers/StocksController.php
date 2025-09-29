<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\StockSize;

class StocksController extends Controller
{
    // List all stocks
    public function index()
    {
        $stocks = Stock::with(['stockable', 'sizes', 'rawMaterials']) // added rawMaterials
            ->get()
            ->sortBy(function ($stock) {
                return strtolower($stock->stockable->name ?? $stock->name);
            });

        return view('stocks.stocks', compact('stocks'));
    }

    // Show page for individual stock
    public function show(Stock $stock)
    {
        $stock->load(['stockable', 'sizes', 'rawMaterials']); // added rawMaterials
        $allStocks = Stock::with(['sizes', 'rawMaterials'])->latest()->get(); // added rawMaterials

        // overall quantity from raw materials
        $totalQuantity = $stock->rawMaterials->sum('quantity');

        return view('stocks.show', compact('stock', 'allStocks', 'totalQuantity'));
    }

    // Store new stock
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'price'    => 'required|numeric|min:0',
        ]);

        // Determine quantity: if has_sizes, sum sizes
        $quantity = $request->has('sizes') ? array_sum(array_column($request->sizes ?? [], 'quantity')) : $request->quantity;

        $stock = Stock::create([
            'name'     => $request->name,
            'quantity' => $quantity,
            'price'    => $request->price,
        ]);

        // Save sizes if provided
        if ($request->has('sizes')) {
            foreach ($request->sizes as $size) {
                if (!empty($size['size_name']) && isset($size['quantity'])) {
                    $stock->sizes()->create([
                        'size_name' => $size['size_name'],
                        'quantity'  => $size['quantity'],
                    ]);
                }
            }
        }

        // Redirect back to same page with success message
        return redirect()->route('stocks.show', $stock->id)
                         ->with('success', 'Stock added successfully!');
    }

    // Update existing stock
    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'price'    => 'required|numeric|min:0',
        ]);

        $stock->update([
            'name'     => $request->name,
            'quantity' => $request->quantity,
            'price'    => $request->price,
        ]);

        return redirect()->route('stocks.show', $stock->id)
                         ->with('success', 'Stock updated successfully!');
    }
}
