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
                    <h2 class="text-xl font-semibold text-gray-700">Total Costs</h2>
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
                    <h2 class="text-xl font-semibold text-gray-700">Total Profit</h2>
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

        <!-- ✅ RESTOCK BOARD (Hosted-safe layout + roomy spacing + drop animation) -->
        <div style="
            margin-top:48px;
            margin-bottom:10px;
            background:#ffffff;
            border-radius:24px;
            padding:40px;
            box-shadow:0 10px 30px rgba(0,0,0,0.08);
        ">
            <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:16px;">
                <div style="display:flex; align-items:center; gap:12px;">
                    <div style="font-size:22px;">🧾</div>
                    <div>
                        <div style="font-size:22px; font-weight:800; color:#111827; line-height:1.2;">Restock Board</div>
                    </div>
                </div>
            </div>

            @if($lowStocks->count())
                <div style="overflow-x:auto; margin-top:24px;">
                    <div style="min-width: 980px;">
                        <div style="
                            display:grid;
                            grid-template-columns: 1.5fr 1fr 1fr 1fr;
                            gap:28px;
                        ">

                            <!-- Products -->
                            <div>
                                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
                                    <div style="font-weight:800; font-size:13px; color:#111827;">Products</div>
                                    <span id="count-products"
                                        style="font-size:12px; font-weight:800; padding:4px 10px; border-radius:999px; background:#f3f4f6; color:#374151;">0</span>
                                </div>
                                <div id="rb-product-list" style="display:flex; flex-direction:column; gap:12px;"></div>
                            </div>

                            <!-- To Buy -->
                            <div>
                                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
                                    <div style="font-weight:800; font-size:13px; color:#92400e;">To Buy</div>
                                    <span id="count-to_buy"
                                        style="font-size:12px; font-weight:800; padding:4px 10px; border-radius:999px; background:#fef3c7; color:#92400e;">0</span>
                                </div>
                                <div id="col-to_buy"
                                     style="
                                        min-height:300px;
                                        background:#fffbeb;
                                        border:2px solid #fde68a;
                                        border-radius:20px;
                                        padding:20px;
                                        display:flex;
                                        flex-direction:column;
                                        gap:14px;
                                     ">
                                </div>
                            </div>

                            <!-- On Going -->
                            <div>
                                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
                                    <div style="font-weight:800; font-size:13px; color:#075985;">On Going</div>
                                    <span id="count-on_going"
                                        style="font-size:12px; font-weight:800; padding:4px 10px; border-radius:999px; background:#e0f2fe; color:#075985;">0</span>
                                </div>
                                <div id="col-on_going"
                                     style="
                                        min-height:300px;
                                        background:#f0f9ff;
                                        border:2px solid #bae6fd;
                                        border-radius:20px;
                                        padding:20px;
                                        display:flex;
                                        flex-direction:column;
                                        gap:14px;
                                     ">
                                </div>
                            </div>

                            <!-- Done -->
                            <div>
                                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
                                    <div style="font-weight:800; font-size:13px; color:#065f46;">Done</div>
                                    <span id="count-done"
                                        style="font-size:12px; font-weight:800; padding:4px 10px; border-radius:999px; background:#d1fae5; color:#065f46;">0</span>
                                </div>
                                <div id="col-done"
                                     style="
                                        min-height:300px;
                                        background:#ecfdf5;
                                        border:2px solid #a7f3d0;
                                        border-radius:20px;
                                        padding:20px;
                                        display:flex;
                                        flex-direction:column;
                                        gap:14px;
                                     ">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Drop animation + card styling -->
                <style>
                    .rb-card{
                        background:#fff;
                        border:1px solid #e5e7eb;
                        border-radius:16px;
                        padding:14px 16px;
                        box-shadow:0 4px 14px rgba(0,0,0,0.06);
                        transition: transform .2s ease, box-shadow .2s ease, opacity .2s ease;
                    }
                    .rb-card:hover{
                        transform: translateY(-2px);
                        box-shadow:0 8px 18px rgba(0,0,0,0.09);
                    }

                    .rb-badge{
                        background:#fff;
                        border-radius:16px;
                        padding:14px 16px;
                        box-shadow:0 4px 14px rgba(0,0,0,0.06);
                        transition: transform .2s ease, box-shadow .2s ease, opacity .2s ease;
                    }

                    @keyframes rbDrop {
                        0%   { opacity: 0; transform: translateY(-10px) scale(0.98); }
                        70%  { opacity: 1; transform: translateY(2px) scale(1.01); }
                        100% { opacity: 1; transform: translateY(0) scale(1); }
                    }
                    .rb-drop{
                        animation: rbDrop 260ms ease-out;
                    }
                </style>
            @else
                <p style="color:#6b7280; font-style:italic; margin-top:12px;">No low stock items to track.</p>
            @endif
        </div>
    </div>

    <!-- ✅ Monthly Analytics (with more spacing from Restock Board) -->
    <div class="w-full max-w-6xl bg-white rounded-2xl shadow-lg p-8" sstyle="margin-top:32px;">

        <!-- ✅ Row 1: Title + Dropdown -->
        <div class="flex flex-col sm:flex-row sm:items-center gap-5 mb-2 w-full">   
            <h2 class="text-3xl font-bold text-gray-800 leading-tight">
                📊 Monthly Analytics
            </h2>

            <select id="yearSelect"
                class="border border-gray-300 rounded-xl px-4 py-2 
                       text-sm sm:text-base
                       focus:outline-none focus:ring-2 focus:ring-purple-500 
                       shadow-sm w-fit sm:ml-3">
                @foreach($availableYears as $yr)
                    <option value="{{ $yr }}" {{ (int)$selectedYear === (int)$yr ? 'selected' : '' }}>
                        {{ $yr }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- ✅ Row 2: Export Button BELOW (RIGHT aligned) -->
        <div class="w-full mb-6 flex justify-end" style="width:100%; display:flex; justify-content:flex-end; margin-bottom:24px;">
            <form id="exportPdfForm" method="POST" action="{{ route('analytics.export.pdf') }}"
                  style="display:inline-flex; justify-content:flex-end; width:auto;">
                @csrf
                <input type="hidden" name="chart_image" id="chartImageInput">
                <input type="hidden" name="year" id="yearInput" value="{{ $selectedYear }}">

                <button type="button" id="exportPdfBtn"
                    style="display:inline-flex;align-items:center;gap:8px;
                           padding:8px 20px;
                           background:#7c3aed;color:white;font-weight:700;
                           border-radius:12px;border:none;cursor:pointer;
                           box-shadow:0 4px 10px rgba(0,0,0,0.12);">
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
    // =========================
    // Chart Vars
    // =========================
    const labels = @json($chartLabels ?? []);
    const revenue = @json($chartRevenue ?? []);
    const expenses = @json($chartExpenses ?? []);
    const net = @json($chartNet ?? []);

    const exportForm = document.getElementById('exportPdfForm');
    const exportBtn = document.getElementById('exportPdfBtn');
    const chartImageInput = document.getElementById('chartImageInput');

    const yearSelect = document.getElementById('yearSelect');
    const yearInput = document.getElementById('yearInput');

    if (yearSelect) {
        yearSelect.addEventListener('change', function () {
            const yr = this.value;
            if (yearInput) yearInput.value = yr;

            const url = new URL(window.location.href);
            url.searchParams.set('year', yr);
            window.location.href = url.toString();
        });
    }

    if (yearSelect && yearInput) yearInput.value = yearSelect.value;

    const uiCanvas = document.getElementById('monthlyChart');
    new Chart(uiCanvas, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                { label: 'Revenue', data: revenue, tension: 0.35, fill: false },
                { label: 'Costs', data: expenses, tension: 0.35, fill: false },
                { label: 'Profit', data: net, tension: 0.35, fill: false },
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
                    { label: 'Costs', data: expenses },
                    { label: 'Profit', data: net },
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
        exportBtn.style.opacity = "0.7";
        exportBtn.style.cursor = "not-allowed";

        if (yearSelect && yearInput) yearInput.value = yearSelect.value;

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
                exportBtn.style.opacity = "1";
                exportBtn.style.cursor = "pointer";
            }, 600);
        }, 200);
    });

    // =========================
    // ✅ Restock Board (localStorage + drop animation)
    // =========================
    document.addEventListener("DOMContentLoaded", function() {
        const productList = document.getElementById("rb-product-list");
        const colToBuy = document.getElementById("col-to_buy");
        const colOnGoing = document.getElementById("col-on_going");
        const colDone = document.getElementById("col-done");

        const countProducts = document.getElementById("count-products");
        const countToBuy = document.getElementById("count-to_buy");
        const countOnGoing = document.getElementById("count-on_going");
        const countDone = document.getElementById("count-done");

        if (!productList || !colToBuy || !colOnGoing || !colDone) return;

        const items = @json($lowStocks->map(function($i){
            return ['id'=>$i->id,'name'=>$i->name];
        })->values());

        const key = "restock_board_pretty_v2";
        let statuses = {};
        try { statuses = JSON.parse(localStorage.getItem(key) || "{}"); } catch(e){ statuses = {}; }

        function save() {
            localStorage.setItem(key, JSON.stringify(statuses));
        }

        function createBadge(item, borderColor) {
            const div = document.createElement("div");
            div.className = "rb-badge rb-drop";
            div.style.border = "1px solid " + borderColor;
            div.innerHTML = `<div style="font-weight:800; color:#111827; font-size:13px;">${item.name}</div>`;
            // remove class after animation so it can animate again next time
            setTimeout(() => div.classList.remove('rb-drop'), 300);
            return div;
        }

        function renderColumns() {
            colToBuy.innerHTML = "";
            colOnGoing.innerHTML = "";
            colDone.innerHTML = "";

            let cToBuy = 0, cOnGoing = 0, cDone = 0;

            items.forEach(item => {
                const status = statuses[item.id] || "to_buy";

                if (status === "to_buy") {
                    colToBuy.appendChild(createBadge(item, "#fbbf24"));
                    cToBuy++;
                } else if (status === "on_going") {
                    colOnGoing.appendChild(createBadge(item, "#38bdf8"));
                    cOnGoing++;
                } else {
                    colDone.appendChild(createBadge(item, "#34d399"));
                    cDone++;
                }
            });

            if (!colToBuy.children.length) colToBuy.innerHTML = `<div style="color:#92400e; opacity:.7; font-size:12px; font-style:italic;">No items</div>`;
            if (!colOnGoing.children.length) colOnGoing.innerHTML = `<div style="color:#075985; opacity:.7; font-size:12px; font-style:italic;">No items</div>`;
            if (!colDone.children.length) colDone.innerHTML = `<div style="color:#065f46; opacity:.7; font-size:12px; font-style:italic;">No items</div>`;

            if (countProducts) countProducts.textContent = items.length;
            if (countToBuy) countToBuy.textContent = cToBuy;
            if (countOnGoing) countOnGoing.textContent = cOnGoing;
            if (countDone) countDone.textContent = cDone;
        }

        // Build product list with dropdowns
        productList.innerHTML = "";
        items.forEach(item => {
            const wrapper = document.createElement("div");
            wrapper.className = "rb-card";

            wrapper.innerHTML = `
                <div style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
                    <div style="min-width:0;">
                        <div style="font-weight:800; color:#111827; font-size:13px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            ${item.name}
                        </div>
                    </div>

                    <select class="rb-select"
                        style="
                            border:2px solid #a855f7;
                            border-radius:14px;
                            padding:8px 12px;
                            font-size:12px;
                            font-weight:700;
                            outline:none;
                            cursor:pointer;
                            background:#fff;
                        "
                        data-id="${item.id}">
                        <option value="to_buy">To Buy</option>
                        <option value="on_going">On Going</option>
                        <option value="done">Done</option>
                    </select>
                </div>
            `;

            const sel = wrapper.querySelector("select");
            sel.value = statuses[item.id] || "to_buy";

            sel.addEventListener("change", function() {
                statuses[item.id] = this.value;
                save();
                renderColumns();
            });

            productList.appendChild(wrapper);
        });

        renderColumns();
    });

})();
</script>
@endsection