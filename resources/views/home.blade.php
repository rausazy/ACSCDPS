@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center py-16">

    <div class="text-center mb-14">
        <h1 class="text-5xl md:text-6xl font-extrabold bg-clip-text text-transparent 
           bg-gradient-to-r from-purple-600 via-pink-500 to-blue-500 
           leading-tight pb-2">
            Cinlei Digital Printing Services
        </h1>
        <p class="mt-4 text-lg text-gray-700 max-w-2xl mx-auto leading-relaxed">
            We provide <span class="font-semibold text-purple-600">top-quality products</span> and 
            <span class="font-semibold text-pink-500">professional services</span> 
            designed to help your business grow and succeed.
        </p>
    </div>  

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full max-w-6xl mb-16">

        <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition transform hover:scale-105">
            <div class="flex items-center space-x-6">
                <div class="p-5 rounded-full bg-green-100 text-green-600">
                    <x-heroicon-o-chart-bar class="w-12 h-12" />
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-700">Total Revenue</h2>
                    <p class="text-4xl font-extrabold text-gray-900">
                        ₱{{ number_format($totalRevenue ?? 0, 2) }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition transform hover:scale-105">
            <div class="flex items-center space-x-6">
                <div class="p-5 rounded-full bg-purple-100 text-purple-600">
                    <x-heroicon-o-currency-dollar class="w-12 h-12" />
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-700">Total Expenses</h2>
                    <p class="text-4xl font-extrabold text-gray-900">
                        ₱{{ number_format($overallExpenses ?? 0, 2) }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition transform hover:scale-105">
            <div class="flex items-center space-x-6">
                <div class="p-5 rounded-full bg-indigo-100 text-indigo-600">
                    <x-heroicon-o-banknotes class="w-12 h-12" />
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-700">Total Net Income</h2>
                    <p class="text-4xl font-extrabold text-gray-900">
                        ₱{{ number_format($totalNetIncome ?? 0, 2) }}
                    </p>
                </div>
            </div>
        </div>

    </div>

    <div class="w-full max-w-6xl mb-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">⚠️ Low on Stock</h2>

                <ul class="divide-y divide-gray-200">
                    @forelse($lowStocks as $item)
                        <li class="flex justify-between items-center py-2 text-gray-700">
                            <span>{{ $item->name }}</span>
                            <span class="text-red-600 font-semibold">{{ $item->quantity }} left</span>
                        </li>
                    @empty
                        <li class="py-2 text-gray-500 italic">
                            No low stock items.
                        </li>
                    @endforelse
                </ul>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">⭐ Best Seller</h2>

                <ul class="divide-y divide-gray-200">
                    @forelse($bestSellers as $item)
                        <li class="flex justify-between items-center py-2 text-gray-700">
                            <span>{{ $item->product_name }}</span>
                            <span class="text-gray-500">{{ $item->total_sold }} sold</span>
                        </li>
                    @empty
                        <li class="py-2 text-gray-500 italic">
                            No best seller data yet.
                        </li>
                    @endforelse
                </ul>
            </div>

        </div>
    </div>

    <div class="w-full max-w-6xl bg-white rounded-2xl shadow-lg p-8">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
            <h2 class="text-3xl font-bold text-gray-800">📊 Monthly Analytics</h2>

            <form id="exportPdfForm" method="POST" action="{{ route('analytics.export.pdf') }}">
                @csrf
                <input type="hidden" name="chart_image" id="chartImageInput">

                <button type="button" id="exportPdfBtn"
                    class="inline-flex items-center gap-2 px-10 py-2 
                           bg-purple-600 text-white font-semibold rounded-xl 
                           shadow hover:bg-purple-700 transition">
                    Export to PDF
                </button>
            </form>
        </div>

        <div class="w-full">
            <canvas id="monthlyChart" class="w-full" style="height:320px;"></canvas>
        </div>

        <canvas id="monthlyChartPdf" style="display:none;"></canvas>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    (function () {
        const labels = @json($chartLabels ?? []);
        const revenue = @json($chartRevenue ?? []);
        const expenses = @json($chartExpenses ?? []);
        const net = @json($chartNet ?? []);

        const exportForm = document.getElementById('exportPdfForm');
        const exportBtn = document.getElementById('exportPdfBtn');
        const chartImageInput = document.getElementById('chartImageInput');

        const uiCanvas = document.getElementById('monthlyChart');
        const uiChart = new Chart(uiCanvas, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    { label: 'Revenue', data: revenue, tension: 0.35, fill: false },
                    { label: 'Expenses', data: expenses, tension: 0.35, fill: false },
                    { label: 'Net Income', data: net, tension: 0.35, fill: false },
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: { legend: { display: true } },
                scales: {
                    y: {
                        ticks: {
                            callback: function(value) {
                                return '₱' + Number(value).toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        function buildPdfChart() {
            const pdfCanvas = document.getElementById('monthlyChartPdf');

            pdfCanvas.width = 1100;
            pdfCanvas.height = 520;

            const pdfCtx = pdfCanvas.getContext('2d');

            return new Chart(pdfCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        { label: 'Revenue', data: revenue },
                        { label: 'Expenses', data: expenses },
                        { label: 'Net Income', data: net },
                    ]
                },
                options: {
                    responsive: false,
                    animation: false,
                    plugins: { legend: { display: true } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '₱' + Number(value).toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }

        exportBtn.addEventListener('click', function () {
           
            exportBtn.disabled = true;
            exportBtn.classList.add('opacity-70', 'cursor-not-allowed');

            
            if (typeof Chart === 'undefined') {
                chartImageInput.value = '';
                exportForm.submit();
                return;
            }

            const pdfChart = buildPdfChart();

            setTimeout(() => {
                try {
                    const pdfCanvas = document.getElementById('monthlyChartPdf');
                    chartImageInput.value = pdfCanvas.toDataURL('image/png');
                } catch (err) {
                    chartImageInput.value = '';
                }

                pdfChart.destroy();
                exportForm.submit();

                setTimeout(() => {
                    exportBtn.disabled = false;
                    exportBtn.classList.remove('opacity-70', 'cursor-not-allowed');
                }, 600);
            }, 200);
        });
    })();
</script>
@endsection
