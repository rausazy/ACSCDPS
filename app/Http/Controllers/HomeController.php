<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\RawMaterial;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class HomeController extends Controller
{
    public function index()
    {
        // ✅ EXPENSES
        $overallExpenses = Order::sum('overall_cost');

        // ✅ REVENUE
        $totalRevenue = Order::sum('total_price');

        // ✅ NET INCOME
        $totalNetIncome = $totalRevenue - $overallExpenses;

        // ✅ LOW STOCK (raw materials below 10)
        $lowStocks = RawMaterial::where('quantity', '<', 10)
            ->orderBy('quantity', 'asc')
            ->get();

        // ✅ BEST SELLERS (top 3 by total quantity ordered)
        $bestSellers = Order::select('product_name', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_name')
            ->orderByDesc('total_sold')
            ->limit(3)
            ->get();

        // ✅ MONTHLY ANALYTICS (last 12 months)
        $start = Carbon::now()->startOfMonth()->subMonths(11);
        $end   = Carbon::now()->endOfMonth();

        $rows = Order::whereBetween('created_at', [$start, $end])
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym,
                        SUM(total_price) as revenue,
                        SUM(overall_cost) as expenses")
            ->groupBy('ym')
            ->orderBy('ym')
            ->get()
            ->keyBy('ym');

        $chartLabels = [];
        $chartRevenue = [];
        $chartExpenses = [];
        $chartNet = [];

        $cursor = $start->copy();
        while ($cursor <= $end) {
            $ym = $cursor->format('Y-m');

            $revenue = isset($rows[$ym]) ? (float) $rows[$ym]->revenue : 0;
            $expenses = isset($rows[$ym]) ? (float) $rows[$ym]->expenses : 0;

            $chartLabels[] = $cursor->format('M Y');
            $chartRevenue[] = $revenue;
            $chartExpenses[] = $expenses;
            $chartNet[] = $revenue - $expenses;

            $cursor->addMonth();
        }

        return view('home', compact(
            'overallExpenses',
            'totalRevenue',
            'totalNetIncome',
            'lowStocks',
            'bestSellers',
            'chartLabels',
            'chartRevenue',
            'chartExpenses',
            'chartNet'
        ));
    }

    // ✅ PDF EXPORT (with chart image + table)
    public function exportAnalyticsPdf(Request $request)
    {
        $start = Carbon::now()->startOfMonth()->subMonths(11);
        $end   = Carbon::now()->endOfMonth();

        $rows = Order::whereBetween('created_at', [$start, $end])
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym,
                        SUM(total_price) as revenue,
                        SUM(overall_cost) as expenses")
            ->groupBy('ym')
            ->orderBy('ym')
            ->get()
            ->keyBy('ym');

        $data = [];
        $totalRevenue = 0;
        $totalExpenses = 0;

        $cursor = $start->copy();
        while ($cursor <= $end) {
            $ym = $cursor->format('Y-m');

            $revenue = isset($rows[$ym]) ? (float) $rows[$ym]->revenue : 0;
            $expenses = isset($rows[$ym]) ? (float) $rows[$ym]->expenses : 0;

            $data[] = [
                'month' => $cursor->format('F Y'),
                'revenue' => $revenue,
                'expenses' => $expenses,
                'net' => $revenue - $expenses,
            ];

            $totalRevenue += $revenue;
            $totalExpenses += $expenses;

            $cursor->addMonth();
        }

        // base64 png from canvas
        $chartImage = $request->input('chart_image');

        $pdf = Pdf::loadView('monthly-analytics-pdf', [
            'data' => $data,
            'totalRevenue' => $totalRevenue,
            'totalExpenses' => $totalExpenses,
            'totalNet' => $totalRevenue - $totalExpenses,
            'chartImage' => $chartImage,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('Monthly_Analytics_Report.pdf');
    }
}
