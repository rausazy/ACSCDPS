<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\RawMaterial;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use PDF;

class HistoryController extends Controller
{
    /**
     * Show history page (list of orders)
     * NOTE: If your route points to history(), you can use that instead.
     */
    public function index()
    {
        $orders = Order::latest()->get();
        return view('history.history', compact('orders'));
    }

    /**
     * Backward-compatible method (in case your web.php calls HistoryController@history)
     */
    public function history()
    {
        $orders = Order::latest()->get();
        return view('history.history', compact('orders'));
    }

    /**
     * Confirm order from your costing page (fetch POST)
     * - Saves order
     * - Deducts RAW MATERIAL stocks
     * - Cost is only saved (NOT deducted)
     */
    public function store(Request $request)
    {
        // ✅ basic validation (same fields your JS sends)
        $request->validate([
            'customer.name' => 'required|string',
            'customer.email' => 'required|email',
            'customer.phone' => 'required|string',
            'quotation.product_name' => 'required|string',
            'quotation.quantity' => 'required|numeric|min:1',
            'quotation.total_price' => 'required',
            'costing.raw_materials' => 'required',
        ]);

        $data = $request->all();

        // ✅ raw_materials comes from JS as JSON string (JSON.stringify)
        $raws = $data['costing']['raw_materials'] ?? '[]';

        if (is_string($raws)) {
            $raws = json_decode($raws, true);
        }

        if (!is_array($raws) || count($raws) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'No raw materials provided.'
            ], 422);
        }

        // ✅ AUTO-DETECT stock column in raw_materials table
        // (para di ka na manghula kung quantity/stock/stock_qty/qty)
        $possibleStockColumns = ['quantity', 'stock', 'stock_qty', 'qty'];
        $stockColumn = null;

        foreach ($possibleStockColumns as $col) {
            if (Schema::hasColumn('raw_materials', $col)) {
                $stockColumn = $col;
                break;
            }
        }

        if (!$stockColumn) {
            return response()->json([
                'success' => false,
                'message' => 'Walang stock column sa raw_materials table. Expected one of: quantity, stock, stock_qty, qty.'
            ], 422);
        }

        try {
            DB::transaction(function () use ($data, $raws, $stockColumn) {

                // ✅ 1) Deduct RAW MATERIAL stocks
                foreach ($raws as $rm) {
                    $rawId = (int)($rm['id'] ?? 0);
                    $qty   = (float)($rm['quantity'] ?? 0);

                    // skip invalid rows
                    if ($rawId <= 0 || $qty <= 0) continue;

                    // lock row to prevent double deductions in concurrent requests
                    $rawMaterial = RawMaterial::where('id', $rawId)->lockForUpdate()->first();

                    if (!$rawMaterial) {
                        throw new \Exception("Raw material not found (ID: {$rawId}).");
                    }

                    $currentStock = (float)($rawMaterial->{$stockColumn} ?? 0);

                    if ($currentStock < $qty) {
                        throw new \Exception("Insufficient stock for {$rawMaterial->name}. (Available: {$currentStock}, Needed: {$qty})");
                    }

                    $rawMaterial->decrement($stockColumn, $qty);
                }

                // ✅ 2) Save order history (cost is saved only)
                Order::create([
                    'customer_name' => $data['customer']['name'] ?? null,
                    'customer_email' => $data['customer']['email'] ?? null,
                    'customer_phone' => $data['customer']['phone'] ?? null,
                    'customer_address' => $data['customer']['address'] ?? null,

                    'product_name' => $data['quotation']['product_name'] ?? null,
                    'quantity' => $data['quotation']['quantity'] ?? 0,
                    'cost_per_piece' => $data['quotation']['cost_per_piece'] ?? 0,
                    'markup' => $data['quotation']['markup'] ?? 0,
                    'selling_price_per_piece' => $data['quotation']['selling_price_per_piece'] ?? 0,
                    'discount_percentage' => $data['quotation']['discount_percentage'] ?? 0,
                    'total_price' => $data['quotation']['total_price'] ?? 0,

                    // ✅ store raw materials as JSON ONCE
                    'raw_materials' => json_encode($raws),
                    'overall_cost' => $data['costing']['overall_cost'] ?? 0,
                ]);
            });

            return response()->json(['success' => true]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Delete an order
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Export PDF (same behavior as your existing code)
     */
    public function exportPdf(Request $request)
    {
        $customerName = $request->input('customer_name');
        $date = $request->input('date');

        $orders = Order::where('customer_name', $customerName)
            ->whereDate('created_at', $date)
            ->get();

        if ($orders->isEmpty()) {
            abort(404, 'No orders found for this customer on this date.');
        }

        $customer = $orders->first();

        $customerEmail = $customer->customer_email;
        $customerPhone = $customer->customer_phone;
        $customerAddress = $customer->customer_address;

        $pdf = PDF::loadView('history.pdf', compact(
            'orders', 'customerName', 'customerEmail', 'customerPhone', 'customerAddress', 'date'
        ));

        $fileName = 'Order_History_' . $customerName . '_' . $date . '.pdf';

        return $pdf->stream($fileName);
    }
}
