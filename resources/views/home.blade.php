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

    <!-- ✅ Low Stocks + Best Sellers + Restock Board -->
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

        <!-- ✅ ONE CARD: Restock Board (4 Columns, colored headers, smooth transitions) -->
        <div class="mt-8 bg-white rounded-2xl shadow-lg p-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
                <h2 class="text-2xl font-bold text-gray-800">🧾 Restock Board</h2>
                <p class="text-sm text-gray-500">
                    Update status using the dropdown — items will move smoothly.
                </p>
            </div>

            @if($lowStocks->count())
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                    <!-- Products -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-bold text-sm text-gray-700">Products</h3>
                            <span id="count-products"
                                class="text-xs font-semibold px-2 py-1 rounded-full bg-gray-100 text-gray-700">0</span>
                        </div>
                        <div id="rb-product-list" class="space-y-3"></div>
                    </div>

                    <!-- To Buy -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-bold text-sm text-amber-900">To Buy</h3>
                            <span id="count-to_buy"
                                class="text-xs font-semibold px-2 py-1 rounded-full bg-amber-100 text-amber-900">0</span>
                        </div>
                        <div id="col-to_buy" class="min-h-[230px] rounded-xl p-3 space-y-2 border bg-amber-50"></div>
                    </div>

                    <!-- On Going -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-bold text-sm text-sky-900">On Going</h3>
                            <span id="count-on_going"
                                class="text-xs font-semibold px-2 py-1 rounded-full bg-sky-100 text-sky-900">0</span>
                        </div>
                        <div id="col-on_going" class="min-h-[230px] rounded-xl p-3 space-y-2 border bg-sky-50"></div>
                    </div>

                    <!-- Done -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-bold text-sm text-emerald-900">Done</h3>
                            <span id="count-done"
                                class="text-xs font-semibold px-2 py-1 rounded-full bg-emerald-100 text-emerald-900">0</span>
                        </div>
                        <div id="col-done" class="min-h-[230px] rounded-xl p-3 space-y-2 border bg-emerald-50"></div>
                    </div>

                </div>

                <!-- tiny helper style for smooth animation -->
                <style>
                    .rb-card {
                        transition: transform 250ms ease, opacity 250ms ease, box-shadow 250ms ease;
                    }
                    .rb-card.rb-enter {
                        opacity: 0;
                        transform: translateY(6px);
                    }
                    .rb-card.rb-enter-active {
                        opacity: 1;
                        transform: translateY(0);
                    }
                    .rb-badge {
                        transition: transform 250ms ease, opacity 250ms ease, box-shadow 250ms ease;
                    }
                    .rb-badge.rb-pop {
                        transform: scale(0.97);
                        opacity: 0.2;
                    }
                </style>
            @else
                <p class="text-gray-500 italic">No low stock items to track.</p>
            @endif
        </div>
    </div>

    <!-- Monthly Analytics -->
    <div class="w-full max-w-6xl bg-white rounded-2xl shadow-lg p-8">

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
        // ✅ Restock Board (no qty left, colored, smooth transitions)
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

            const key = "restock_board_pretty_v1";
            let statuses = {};
            try { statuses = JSON.parse(localStorage.getItem(key) || "{}"); } catch(e){ statuses = {}; }

            function save() {
                localStorage.setItem(key, JSON.stringify(statuses));
            }

            function animateIn(el) {
                el.classList.add('rb-enter');
                requestAnimationFrame(() => {
                    el.classList.add('rb-enter-active');
                    setTimeout(() => {
                        el.classList.remove('rb-enter');
                        el.classList.remove('rb-enter-active');
                    }, 260);
                });
            }

            function createBadge(item, tint) {
                const div = document.createElement("div");
                div.className = "rb-badge bg-white border rounded-xl p-3 text-sm shadow-sm";
                div.style.borderColor = tint.border;
                div.style.boxShadow = "0 3px 12px rgba(0,0,0,0.06)";
                div.innerHTML = `
                    <div class="font-semibold text-gray-800">${item.name}</div>
                `;
                return div;
            }

            function renderColumns(withPop = false) {
                colToBuy.innerHTML = "";
                colOnGoing.innerHTML = "";
                colDone.innerHTML = "";

                let cToBuy = 0, cOnGoing = 0, cDone = 0;

                items.forEach(item => {
                    const status = statuses[item.id] || "to_buy";

                    if (status === "to_buy") {
                        const badge = createBadge(item, { border: "#fbbf24" });
                        colToBuy.appendChild(badge);
                        if (withPop) badge.classList.add('rb-pop');
                        setTimeout(()=> badge.classList.remove('rb-pop'), 220);
                        cToBuy++;
                    }

                    if (status === "on_going") {
                        const badge = createBadge(item, { border: "#38bdf8" });
                        colOnGoing.appendChild(badge);
                        if (withPop) badge.classList.add('rb-pop');
                        setTimeout(()=> badge.classList.remove('rb-pop'), 220);
                        cOnGoing++;
                    }

                    if (status === "done") {
                        const badge = createBadge(item, { border: "#34d399" });
                        colDone.appendChild(badge);
                        if (withPop) badge.classList.add('rb-pop');
                        setTimeout(()=> badge.classList.remove('rb-pop'), 220);
                        cDone++;
                    }
                });

                // Empty text
                if (!colToBuy.children.length) colToBuy.innerHTML = `<p class="text-xs text-amber-700/70 italic">No items</p>`;
                if (!colOnGoing.children.length) colOnGoing.innerHTML = `<p class="text-xs text-sky-700/70 italic">No items</p>`;
                if (!colDone.children.length) colDone.innerHTML = `<p class="text-xs text-emerald-700/70 italic">No items</p>`;

                // Counts
                if (countProducts) countProducts.textContent = items.length;
                if (countToBuy) countToBuy.textContent = cToBuy;
                if (countOnGoing) countOnGoing.textContent = cOnGoing;
                if (countDone) countDone.textContent = cDone;
            }

            // Build product list
            productList.innerHTML = "";
            items.forEach(item => {
                const wrapper = document.createElement("div");
                wrapper.className = "rb-card bg-white border border-gray-200 rounded-2xl p-3 shadow-sm hover:shadow-md";
                wrapper.innerHTML = `
                    <div class="flex justify-between items-center gap-3">
                        <div class="min-w-0">
                            <div class="font-bold text-sm text-gray-800 truncate">${item.name}</div>
                        </div>

                        <select class="border border-gray-300 rounded-xl px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-purple-500"
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

                    // quick soft animation
                    wrapper.style.opacity = "0.6";
                    wrapper.style.transform = "translateY(1px)";
                    setTimeout(() => {
                        wrapper.style.opacity = "1";
                        wrapper.style.transform = "translateY(0)";
                    }, 180);

                    renderColumns(true);
                });

                productList.appendChild(wrapper);
                animateIn(wrapper);
            });

            renderColumns(false);
        });

    })();
</script>
@endsection