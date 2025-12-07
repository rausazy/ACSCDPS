<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Order;

class HomeController extends Controller
{
    public function index()
    {
        // Kunin lahat ng stocks kasama ang rawMaterials
        $stocks = Stock::with('rawMaterials')->get();

        // Compute overall expenses mula sa stocks
        $overallExpenses = $stocks->sum(function($stock){
            return $stock->rawMaterials->sum(function($raw){
                return $raw->quantity * $raw->price;
            });
        });

        // Compute total revenue mula sa lahat ng confirmed orders
        $totalRevenue = Order::sum('total_price'); // adjust 'total_price' kung iba ang column name

        // Compute total net income
        $totalNetIncome = $totalRevenue - $overallExpenses;

        return view('home', compact('overallExpenses', 'totalRevenue', 'totalNetIncome'));
    }
}
