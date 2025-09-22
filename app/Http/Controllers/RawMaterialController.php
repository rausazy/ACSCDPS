<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use Illuminate\Http\Request;

class RawMaterialController extends Controller
{
    public function index()
    {
        $rawMaterials = RawMaterial::all();
        return view('raw_materials.index', compact('rawMaterials'));
    }

    public function create()
    {
        return view('raw_materials.create');
    }

public function store(Request $request, $stockId)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'quantity' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
    ]);

    RawMaterial::create([
        'stock_id' => $stockId,   // ← dito pinapasok
        'name' => $request->name,
        'quantity' => $request->quantity,
        'price' => $request->price,
    ]);

    return redirect()->route('stocks.show', $stockId)
                     ->with('success', 'Raw material added successfully.');
}



    public function show(RawMaterial $rawMaterial)
    {
        return view('raw_materials.show', compact('rawMaterial'));
    }

    public function destroy(RawMaterial $rawMaterial)
    {
        $rawMaterial->delete();
        return redirect()->route('stocks.stocks')->with('success', 'Raw material deleted successfully!');
    }
}
