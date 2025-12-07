<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use PDF;

class HistoryController extends Controller
{
    public function index()
    {
        return view('history.history');
    }

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
        return view('history.history', compact('orders'));
    }

    public function destroy(Order $order)
{
    $order->delete();
    return response()->json(['success' => true]);
}

public function exportPdf(Request $request)
{
    $customerName = $request->input('customer_name');
    $date = $request->input('date');

    // Get all orders for that customer on that date
    $orders = Order::where('customer_name', $customerName)
        ->whereDate('created_at', $date)
        ->get();

    if ($orders->isEmpty()) {
        abort(404, 'No orders found for this customer on this date.');
    }

    // Take first order to get customer details
    $customer = $orders->first();

    $customerEmail = $customer->customer_email;
    $customerPhone = $customer->customer_phone;
    $customerAddress = $customer->customer_address;

    // Pass data to PDF view
    $pdf = PDF::loadView('history.pdf', compact(
        'orders', 'customerName', 'customerEmail', 'customerPhone', 'customerAddress', 'date'
    ));

    $fileName = 'Order_History_'.$customerName.'_'. $date .'.pdf';

    // Open in browser instead of downloading
    return $pdf->stream($fileName);
}

}
