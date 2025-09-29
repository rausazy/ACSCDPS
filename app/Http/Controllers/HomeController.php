<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;

class HomeController extends Controller
{
    public function index()
    {
        // Kunin lahat ng stocks kasama ang rawMaterials
        $stocks = Stock::with('rawMaterials')->get();

        // Compute overall expenses
        $overallExpenses = $stocks->sum(function($stock){
            return $stock->rawMaterials->sum(function($raw){
                return $raw->quantity * $raw->price;
            });
        });

        return view('home', compact('overallExpenses'));
    }
}
