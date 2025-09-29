<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // e.g., Shirts
use App\Models\Stock;

class CostingController extends Controller
{
    // Show the costing page for a product
    public function show($productId)
    {
        $product = Product::with('rawMaterials')->findOrFail($productId);

        // Map raw materials to include unit price and available quantity
        $rawMaterials = $product->rawMaterials->map(function($raw){
            return [
                'id' => $raw->id,
                'name' => $raw->name,
                'unit_price' => $raw->price,
                'available_qty' => $raw->quantity
            ];
        });

        return view('costing.show', compact('product', 'rawMaterials'));
    }

    // Optional: store the costing order
    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $request->validate([
            'quantities' => 'required|array'
        ]);

        $totalCost = 0;

        foreach ($request->quantities as $rawId => $qty) {
            $stock = Stock::find($rawId);
            if ($stock) {
                $totalCost += $qty * $stock->price;
            }
        }

        // you can save order or just return total cost
        return back()->with('success', 'Total Cost: ₱' . number_format($totalCost,2));
    }
}
