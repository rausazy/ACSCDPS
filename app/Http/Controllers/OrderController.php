<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        Order::create([
            'customer_name' => $data['customer']['name'],
            'customer_email' => $data['customer']['email'],
            'customer_phone' => $data['customer']['phone'],
            'customer_address' => $data['customer']['address'],

            'product_name' => $data['quotation']['product_name'],
            'quantity' => $data['quotation']['quantity'],
            'cost_per_piece' => $data['quotation']['cost_per_piece'],
            'markup' => $data['quotation']['markup'],
            'selling_price_per_piece' => $data['quotation']['selling_price_per_piece'],
            'discount_percentage' => $data['quotation']['discount_percentage'],
            'total_price' => $data['quotation']['total_price'],

            'raw_materials' => json_encode($data['costing']['raw_materials']),
            'overall_cost' => $data['costing']['overall_cost'],
        ]);

        return response()->json(['success' => true]);
    }

    public function history()
    {
        $orders = Order::latest()->get();
        return view('history', compact('orders'));
    }
}

