@extends('layouts.app')

@section('content')
<div style="min-height:100vh; padding:4rem 1rem;">

    <!-- Page Container -->
    <div style="width:100%; max-width:80rem; margin:0 auto; text-align:left;">

        <!-- Header + Controls -->
        <div style="display:flex; flex-direction:column; gap:1.5rem; margin-bottom:2.5rem;">

            <div style="display:flex; flex-direction:column; gap:1.5rem;">
                <!-- Left: Title -->
                <div style="text-align:left;">
                    <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold bg-clip-text text-transparent 
                        bg-gradient-to-r from-purple-600 via-pink-500 to-blue-500 leading-tight pb-2">
                        Stocks
                    </h1>
                    <p class="mt-2 text-base sm:text-lg text-gray-700 leading-relaxed max-w-2xl">
                        Manage and track your available stocks efficiently.
                    </p>
                </div>

                <!-- Right: Search + Filters (filters under search) -->
                <div style="display:flex; flex-direction:column; gap:0.75rem; width:100%; align-items:flex-start;">
                    <!-- Search -->
                    <input type="text" id="stockSearch"
                        placeholder="Search stocks..."
                        class="w-full sm:w-72 border border-gray-300 rounded-xl px-4 py-2 
                               focus:outline-none focus:ring-2 focus:ring-purple-500
                               text-sm sm:text-base shadow-sm"
                        style="width:100%; max-width:18rem;">

                    <!-- Filters (under search) -->
                    <div style="display:flex; flex-wrap:wrap; gap:0.5rem; width:100%;">
                        <button type="button"
                            class="stock-filter-btn px-4 py-2 rounded-xl border border-gray-300 bg-white hover:bg-gray-100 transition text-sm font-medium"
                            data-filter="all">
                            All
                        </button>

                        <button type="button"
                            class="stock-filter-btn px-4 py-2 rounded-xl border border-gray-300 bg-white hover:bg-gray-100 transition text-sm font-medium"
                            data-filter="product">
                            Products
                        </button>

                        <button type="button"
                            class="stock-filter-btn px-4 py-2 rounded-xl border border-gray-300 bg-white hover:bg-gray-100 transition text-sm font-medium"
                            data-filter="service">
                            Services
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- Stocks Grid -->
        <div id="stocksGrid"
             class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 sm:gap-8 w-full"
             style="width:100%; justify-items:stretch; align-items:stretch;">
            @foreach ($stocks as $stock)
                @php
                    $stockable = $stock->stockable;
                    $type = $stockable ? strtolower(class_basename($stockable)) : 'other';

                    if ($type !== 'product' && $type !== 'service') {
                        $type = 'other';
                    }

                    $displayName = optional($stock->stockable)->name ?? $stock->name;
                @endphp

                <a href="{{ route('stocks.show', $stock->id) }}"
                   class="stock-card group relative rounded-2xl transition transform duration-500 hover:-translate-y-2 cursor-pointer block"
                   data-type="{{ $type }}"
                   data-name="{{ strtolower($displayName) }}"
                   style="display:block; text-decoration:none;">

                    <!-- gradient border wrapper -->
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-purple-500 to-pink-500 opacity-0 group-hover:opacity-100 transition duration-500 blur-sm"></div>

                    <!-- inner white box -->
                    <div class="relative bg-white rounded-2xl shadow-md group-hover:shadow-2xl p-5 sm:p-7 flex flex-col items-center text-center transition duration-500"
                         style="text-align:center;">
                        <x-dynamic-component
                            :component="'heroicon-o-' . (optional($stock->stockable)->icon ?? 'cube')"
                            class="w-11 h-11 sm:w-12 sm:h-12 {{ optional($stock->stockable)->color ?? 'text-gray-500' }} mb-3 transition-transform duration-500 group-hover:scale-110" />

                        <h2 class="text-base sm:text-lg font-semibold text-gray-800">
                            {{ $displayName }}
                        </h2>

                        <p class="text-xs font-semibold mt-2 px-3 py-1 rounded-full
                            {{ $type === 'product' ? 'bg-purple-100 text-purple-700' : '' }}
                            {{ $type === 'service' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $type === 'other' ? 'bg-gray-100 text-gray-700' : '' }}">
                            {{ strtoupper($type) }}
                        </p>

                        <p class="text-sm text-gray-500 mt-2">
                            Quantity: {{ $stock->rawMaterials->sum('quantity') }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- No Results -->
        <div id="noStockResults" class="hidden mt-10 text-gray-500 text-lg"
            style="margin-top:2.5rem; text-align:center; width:100%; display:flex; justify-content:center;">
            <span>No stocks found.</span>
        </div>

    </div>
</div>

<script>
    // --- Inline responsive alignment for hosted (no CSS dependency) ---
    // Align header row like: left title, right controls (>=640px), stacked on mobile.
    (function () {
        const applyLayout = () => {
            const isDesktop = window.matchMedia('(min-width: 640px)').matches;

            // the header wrapper is: PageContainer -> Header+Controls -> (first child) -> (first child)
            // We'll just find the first flex container that holds title + right controls.
            const pageContainer = document.querySelector('[data-stocks-page-container]') || null;
        };

        // Make the right controls align end on desktop
        const rightControls = document.querySelector('#stockSearch')?.parentElement;
        const headerRow = rightControls?.parentElement;

        const setHeaderLayout = () => {
            const isDesktop = window.matchMedia('(min-width: 640px)').matches;

            if (headerRow) {
                headerRow.style.display = 'flex';
                headerRow.style.gap = '1.5rem';
                headerRow.style.flexDirection = isDesktop ? 'row' : 'column';
                headerRow.style.alignItems = isDesktop ? 'flex-start' : 'stretch';
                headerRow.style.justifyContent = isDesktop ? 'space-between' : 'flex-start';
            }

            if (rightControls) {
                rightControls.style.alignItems = isDesktop ? 'flex-end' : 'flex-start';
                rightControls.style.width = isDesktop ? 'auto' : '100%';
            }
        };

        setHeaderLayout();
        window.addEventListener('resize', setHeaderLayout);
    })();

    const filterBtns = document.querySelectorAll('.stock-filter-btn');
    const stockCards = document.querySelectorAll('.stock-card');
    const noStockResults = document.getElementById('noStockResults');
    const stockSearch = document.getElementById('stockSearch');

    let activeFilter = 'all';

    function setActiveButton(activeBtn) {
        filterBtns.forEach(btn => {
            btn.classList.remove('bg-purple-600', 'text-white', 'border-purple-600');
            btn.classList.add('bg-white', 'text-gray-800', 'border-gray-300');
        });

        activeBtn.classList.remove('bg-white', 'text-gray-800', 'border-gray-300');
        activeBtn.classList.add('bg-purple-600', 'text-white', 'border-purple-600');
    }

    function applyFilterAndSearch() {
        const term = (stockSearch?.value || '').toLowerCase().trim();
        let visibleCount = 0;

        stockCards.forEach(card => {
            const type = card.dataset.type;
            const name = card.dataset.name || '';

            const matchesFilter = (activeFilter === 'all') ? true : (type === activeFilter);
            const matchesSearch = term === '' ? true : name.includes(term);

            if (matchesFilter && matchesSearch) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (visibleCount === 0) noStockResults.classList.remove('hidden');
        else noStockResults.classList.add('hidden');
    }

    // Default active = all
    const defaultBtn = document.querySelector('.stock-filter-btn[data-filter="all"]');
    if (defaultBtn) {
        setActiveButton(defaultBtn);
        activeFilter = 'all';
        applyFilterAndSearch();
    }

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            activeFilter = btn.dataset.filter;
            setActiveButton(btn);
            applyFilterAndSearch();
        });
    });

    if (stockSearch) {
        stockSearch.addEventListener('input', applyFilterAndSearch);
    }
</script>
@endsection
