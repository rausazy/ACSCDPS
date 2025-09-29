<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use Illuminate\Http\Request;

class RawMaterialController extends Controller
{
    public function store(Request $request, $stock)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'quantity' => 'nullable|integer|min:0',
            'price'    => 'nullable|numeric|min:0',
            'sizes.*.name'     => 'nullable|string|max:255',
            'sizes.*.quantity' => 'nullable|integer|min:0',
            'sizes.*.price'    => 'nullable|numeric|min:0',
        ]);

        if ($request->has('has_sizes') && $request->has('sizes')) {
            foreach ($request->sizes as $size) {
                if (!empty($size['name'])) {
                    RawMaterial::create([
                        'stock_id' => $stock,
                        'name'     => $request->name . ' - ' . $size['name'],
                        'quantity' => isset($size['quantity']) ? (int) $size['quantity'] : 0,
                        'price'    => isset($size['price']) ? (float) $size['price'] : 0,
                    ]);
                }
            }
        } else {
            RawMaterial::create([
                'stock_id' => $stock,
                'name'     => $request->name,
                'quantity' => $request->quantity ?? 0,
                'price'    => $request->price ?? 0,
            ]);
        }

        return redirect()->route('stocks.show', $stock)
                         ->with('success', 'Raw material added successfully.');
    }

    public function update(Request $request, RawMaterial $rawMaterial)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'price'    => 'required|numeric|min:0',
        ]);

        $rawMaterial->update($request->only(['name', 'quantity', 'price']));

        return redirect()->route('stocks.show', $rawMaterial->stock_id)
                         ->with('success', 'Raw material updated successfully!');
    }

    public function destroy(RawMaterial $rawMaterial)
    {
        $stockId = $rawMaterial->stock_id;
        $rawMaterial->delete();

        return redirect()->route('stocks.show', $stockId)
                         ->with('success', 'Raw material deleted successfully!');
    }
}
