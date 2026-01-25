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
    public function index(Request $request)
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

        // ✅ YEARS DROPDOWN (show even if walang order) — includes current year
        $currentYear = now()->year;
        $yearsBack = 5; // ilang years pababa (2026..2021 if current=2026)

        $availableYears = range($currentYear, $currentYear - $yearsBack);

        // default selected year = current year (2026)
        $selectedYear = (int) $request->query('year', $currentYear);

        // validate selection
        if (!in_array($selectedYear, $availableYears, true)) {
            $selectedYear = $availableYears[0]; // current year
        }

        // ✅ MONTHLY ANALYTICS (Jan–Dec of selected year)
        $start = Carbon::create($selectedYear, 1, 1)->startOfMonth();
        $end   = Carbon::create($selectedYear, 12, 31)->endOfMonth();

        $rows = Order::whereBetween('created_at', [$start, $end])
            ->selectRaw("
                MONTH(created_at) as m,
                SUM(total_price) as revenue,
                SUM(overall_cost) as expenses
            ")
            ->groupBy('m')
            ->orderBy('m')
            ->get()
            ->keyBy('m');

        $chartLabels = [];
        $chartRevenue = [];
        $chartExpenses = [];
        $chartNet = [];

        for ($m = 1; $m <= 12; $m++) {
            $chartLabels[] = Carbon::create($selectedYear, $m, 1)->format('M');

            $revenue = isset($rows[$m]) ? (float) $rows[$m]->revenue : 0;
            $expenses = isset($rows[$m]) ? (float) $rows[$m]->expenses : 0;

            $chartRevenue[] = $revenue;
            $chartExpenses[] = $expenses;
            $chartNet[] = $revenue - $expenses;
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
            'chartNet',
            'availableYears',
            'selectedYear'
        ));
    }

    // ✅ PDF EXPORT (same selected year + chart image + table)
    public function exportAnalyticsPdf(Request $request)
    {
        $currentYear = now()->year;
        $yearsBack = 5;

        // ✅ accept year from form; default = current year
        $selectedYear = (int) $request->input('year', $currentYear);

        // ✅ validate year range
        $availableYears = range($currentYear, $currentYear - $yearsBack);
        if (!in_array($selectedYear, $availableYears, true)) {
            $selectedYear = $availableYears[0]; // current year
        }

        $start = Carbon::create($selectedYear, 1, 1)->startOfMonth();
        $end   = Carbon::create($selectedYear, 12, 31)->endOfMonth();

        $rows = Order::whereBetween('created_at', [$start, $end])
            ->selectRaw("
                MONTH(created_at) as m,
                SUM(total_price) as revenue,
                SUM(overall_cost) as expenses
            ")
            ->groupBy('m')
            ->orderBy('m')
            ->get()
            ->keyBy('m');

        $data = [];
        $totalRevenue = 0;
        $totalExpenses = 0;

        for ($m = 1; $m <= 12; $m++) {
            $revenue = isset($rows[$m]) ? (float) $rows[$m]->revenue : 0;
            $expenses = isset($rows[$m]) ? (float) $rows[$m]->expenses : 0;

            $data[] = [
                'month' => Carbon::create($selectedYear, $m, 1)->format('F Y'),
                'revenue' => $revenue,
                'expenses' => $expenses,
                'net' => $revenue - $expenses,
            ];

            $totalRevenue += $revenue;
            $totalExpenses += $expenses;
        }

        $chartImage = $request->input('chart_image');

        $pdf = Pdf::loadView('monthly-analytics-pdf', [
            'data' => $data,
            'totalRevenue' => $totalRevenue,
            'totalExpenses' => $totalExpenses,
            'totalNet' => $totalRevenue - $totalExpenses,
            'chartImage' => $chartImage,
            'selectedYear' => $selectedYear,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream("Monthly_Analytics_{$selectedYear}.pdf");
    }
}
