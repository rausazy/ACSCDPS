<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Order;

class HomeController extends Controller
{
    public function index()
    {
        // ✅ EXPENSES = cost ng confirmed orders (record, hindi nababawasan kapag nabawasan stocks)
        $overallExpenses = Order::sum('overall_cost');

        // ✅ REVENUE = total confirmed orders
        $totalRevenue = Order::sum('total_price');

        // ✅ NET INCOME
        $totalNetIncome = $totalRevenue - $overallExpenses;

        return view('home', compact('overallExpenses', 'totalRevenue', 'totalNetIncome'));
    }
}
