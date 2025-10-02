<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Str;
use PDF;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name', 'asc')->get();
        return view('products.products', compact('products'));
    }

    public function create()
    {
        return view('products.create'); // form para mag-add ng product
    }

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:products,name',
        'icon' => 'nullable|string|max:255',
    ]);

    $url = Str::slug($request->name);

    // Random color set
    $colors = [
        'text-pink-500', 'text-purple-500', 'text-blue-500', 'text-green-500',
        'text-amber-500', 'text-fuchsia-500', 'text-sky-500', 'text-orange-500',
        'text-rose-500', 'text-cyan-500', 'text-red-500', 'text-indigo-500',
        'text-lime-500', 'text-violet-500', 'text-blue-400', 'text-pink-500'
    ];
    $color = $colors[array_rand($colors)];

    // Create Product
    $product = Product::create([
        'name' => $request->name,
        'icon' => $request->icon,
        'url'  => $url,
        'color'=> $color,
    ]);

    // ✅ Create corresponding Stock entry with default quantity 0 via polymorphic relation
    $product->stock()->create([
        'quantity' => 0,
    ]);

    return redirect()->route('products.products')->with('success', 'Product added!');
}


    public function destroy(Product $product)
    {
        // Automatic na made-delete ang stock kung may cascade sa migration.
        // Pero para safe, i-delete manually dito:
        if ($product->stock) {
            $product->stock->delete();
        }

        $product->delete();

        return redirect()->route('products.products')->with('success', 'Product successfully deleted!');
    }

   public function show($url)   
{
    $product = Product::where('url', $url)->firstOrFail();

    // Kunin raw materials ng stock ng product
    $rawMaterials = $product->stock 
        ? $product->stock->rawMaterials()->orderBy('name')->get() 
        : collect();

    return view('products.show', compact('product', 'rawMaterials'));

    
}

public function exportPdf(Request $request, $url)
{
    $product = Product::where('url', $url)->firstOrFail();

    $costingData = json_decode($request->costing_data, true);

    // Load PDF view
    $pdf = \PDF::loadView('products.costing-pdf', [
        'product' => $product,
        'costingData' => $costingData,
    ]);

    // Pwede mong gamitin stream para i-display agad sa browser
    return $pdf->stream($product->name . '_quotation.pdf');

    // O download kung gusto mo automatic save
    // return $pdf->download($product->name . '_quotation.pdf');
}
}
