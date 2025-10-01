@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center py-16 px-4 sm:px-6 lg:px-8">

    <!-- Back link -->
    <div class="w-full max-w-7xl mb-6">
        <a href="{{ url('/products') }}" 
           class="inline-flex items-center text-purple-600 hover:text-purple-800 font-medium transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Products
        </a>
    </div>

    <!-- Header -->
    <div class="text-center mb-14 w-full flex justify-center items-center space-x-4">
        <x-dynamic-component :component="'heroicon-o-' . $product->icon" 
            class="w-12 h-12 {{ $product->color }}" />
        
        <h1 class="text-5xl md:text-6xl font-extrabold bg-clip-text text-transparent 
            bg-gradient-to-r from-purple-600 via-pink-500 to-blue-500 
            leading-tight pb-2">
            {{ $product->name }}
        </h1>
    </div>

    <!-- Costing Section -->
    <div class="w-full max-w-7xl p-6 rounded-2xl shadow-md bg-white">

        <h2 class="text-2xl font-bold mb-4 flex justify-between items-center">
            Costing

            <!-- Export PDF Button Form -->
            <form id="pdfForm" method="POST" action="{{ route('products.costing.pdf', $product->url) }}" target="_blank">
                @csrf
                <input type="hidden" name="costing_data" id="costingDataInput">
                <button type="submit" onclick="preparePdfData()" 
                    class="px-4 py-2 bg-purple-600 text-white font-medium rounded-md 
                        hover:bg-purple-700 transition-colors duration-200"
                    style="background-color: rgb(147 51 234);"> <!-- bg-purple-600 -->
                    Export as PDF
                </button>
            </form>
        </h2>

        @if($rawMaterials->count())
            <!-- Dropdown to select raw materials -->
            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-2">Select Raw Materials to Use</label>
                <select id="rawSelect" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="">-- Choose Raw Material --</option>
                    @foreach($rawMaterials as $raw)
                        <option value="{{ $raw->id }}" 
                                data-name="{{ $raw->name }}" 
                                data-price="{{ $raw->price }}">
                            {{ $raw->name }}
                        </option>
                    @endforeach
                </select>
                <button type="button" id="addRawBtn" 
                    class="px-4 py-2 text-white rounded-md font-medium hover:bg-purple-600 transition"
                    style="background-color: rgb(139 92 246); margin-top: 12px !important; display: inline-block;">
                    Add
                </button>   
            </div>

            <table class="w-full table-auto border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2 text-left">Raw Material</th>
                        <th class="border px-4 py-2 text-left">Quantity</th>
                        <th class="border px-4 py-2 text-left">Unit Price</th>
                        <th class="border px-4 py-2 text-left">Total Price</th>
                        <th class="border px-4 py-2 text-left">Action</th>
                    </tr>
                </thead>
                <tbody id="costingBody">
                    <!-- Rows will be dynamically added -->
                </tbody>
            </table>

            <!-- Overall Cost & Revenue -->
            <div class="mt-6 text-right space-y-1" style="text-align: right; margin-top: 1.5rem;">
                <h3 class="text-lg font-bold text-gray-800" style="margin: 0;">
                    Overall Cost: <span id="overallCost">₱0.00</span>
                </h3>
                <h3 class="text-lg font-bold text-gray-800" style="margin: 0;">
                    Overall Revenue: <span id="overallRevenue">₱0.00</span>
                </h3>
            </div>
        @else
            <p class="text-gray-500">No raw materials available for this product.</p>
        @endif
    </div>

    <!-- Invisible Divider / Spacer -->
    <div class="h-20"></div>

    <!-- Quotation Section -->
    <div class="w-full max-w-7xl p-6 rounded-2xl shadow-md bg-white">
        <h2 class="text-2xl font-bold mb-4">Quotation</h2>

        <table class="w-full table-auto border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2 text-left">Product</th>
                    <th class="border px-4 py-2 text-left">Quantity</th>
                    <th class="border px-4 py-2 text-left">Cost per Piece</th>
                    <th class="border px-4 py-2 text-left">Markup per Piece (₱)</th>
                    <th class="border px-4 py-2 text-left">Selling Price per Piece</th>
                    <th class="border px-4 py-2 text-left">Discount (%)</th>
                    <th class="border px-4 py-2 text-left">Total Selling Price</th>
                </tr>
            </thead>
            <tbody>
                <tr id="quotationRow">
                    <td class="border px-4 py-2 font-medium">{{ $product->name }}</td>
                    <td class="border px-4 py-2">
                        <input type="number" id="quoteQty" min="1" value="0"
                            class="w-24 px-2 py-1 border rounded">
                    </td>
                    <td class="border px-4 py-2" id="quoteCostPerPiece">₱0.00</td>
                    <td class="border px-4 py-2">
                        <input type="number" id="quoteMarkup" step="0.01" value="0"
                            class="w-24 px-2 py-1 border rounded">
                    </td>
                    <td class="border px-4 py-2" id="quoteSellingPrice">₱0.00</td>
                    <td class="border px-4 py-2">
                        <input type="number" id="quoteDiscount" step="0.01" value="0"
                            class="w-24 px-2 py-1 border rounded">
                    </td>
                    <td class="border px-4 py-2" id="quoteTotal">₱0.00</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
const costingBody = document.getElementById('costingBody');
const rawSelect = document.getElementById('rawSelect');
const addRawBtn = document.getElementById('addRawBtn');
const overallCostEl = document.getElementById('overallCost');
const overallRevenueEl = document.getElementById('overallRevenue');

const quoteQty = document.getElementById('quoteQty');
const quoteMarkup = document.getElementById('quoteMarkup');
const quoteDiscount = document.getElementById('quoteDiscount');
const quoteCostPerPiece = document.getElementById('quoteCostPerPiece');
const quoteSellingPrice = document.getElementById('quoteSellingPrice');
const quoteTotal = document.getElementById('quoteTotal');

let currentQuoteTotal = 0; // store quotation total para magamit sa revenue

function updateTotals() {
    let overallTotal = 0;
    const rows = costingBody.querySelectorAll('tr');

    rows.forEach(row => {
        const qtyInput = row.querySelector('.quantity-input');
        const priceInput = row.querySelector('.unit-price-input');
        const totalEl = row.querySelector('.total-price');

        const qty = parseFloat(qtyInput.value) || 0;
        const price = parseFloat(priceInput.value) || 0;
        const total = qty * price;

        totalEl.innerText = '₱' + total.toFixed(2);
        overallTotal += total;
    });

    overallCostEl.innerText = '₱' + overallTotal.toFixed(2);

    // compute overall revenue (overall cost + quotation total)
    overallRevenueEl.innerText = '₱' + (overallTotal + currentQuoteTotal).toFixed(2);
}

/* ========================
   Quotation Section Script
   ======================== */
function updateQuotation() {
    const qty = parseFloat(quoteQty.value) || 0;
    const markup = parseFloat(quoteMarkup.value) || 0;
    const discount = parseFloat(quoteDiscount.value) || 0;

    const overallCost = [...costingBody.querySelectorAll('tr')].reduce((sum, row) => {
        const qtyInput = row.querySelector('.quantity-input');
        const priceInput = row.querySelector('.unit-price-input');
        const qtyVal = parseFloat(qtyInput.value) || 0;
        const priceVal = parseFloat(priceInput.value) || 0;
        return sum + (qtyVal * priceVal);
    }, 0);

    if(qty > 0) {
        const costPerPiece = overallCost / qty;
        const sellingPricePerPiece = costPerPiece + markup;
        const totalSellingPrice = sellingPricePerPiece * qty;
        const finalTotal = totalSellingPrice - (totalSellingPrice * (discount / 100));

        quoteCostPerPiece.innerText = '₱' + costPerPiece.toFixed(2);
        quoteSellingPrice.innerText = '₱' + sellingPricePerPiece.toFixed(2);
        quoteTotal.innerText = '₱' + finalTotal.toFixed(2);

        currentQuoteTotal = finalTotal; // update global var
    } else {
        quoteCostPerPiece.innerText = '₱0.00';
        quoteSellingPrice.innerText = '₱0.00';
        quoteTotal.innerText = '₱0.00';
        currentQuoteTotal = 0;
    }

    // refresh totals after updating quotation
    updateTotals();
}

// Add raw material row
addRawBtn.addEventListener('click', () => {
    const selectedOption = rawSelect.options[rawSelect.selectedIndex];
    if(selectedOption.value === "") return;

    const rawId = selectedOption.value;
    const rawName = selectedOption.dataset.name;
    const unitPrice = selectedOption.dataset.price || 0;

    if([...costingBody.querySelectorAll('tr')].some(r => r.dataset.id == rawId)) {
        alert('Raw material already added!');
        return;
    }

    const row = document.createElement('tr');
    row.dataset.id = rawId;
    row.classList.add('hover:bg-gray-50');
    row.innerHTML = `
        <td class="border px-4 py-2">${rawName}</td>
        <td class="border px-4 py-2">
            <input type="number" min="0" value="0" class="w-20 px-2 py-1 border rounded quantity-input">
        </td>
        <td class="border px-4 py-2">
            <input type="number" step="0.01" value="${unitPrice}" class="w-24 px-2 py-1 border rounded unit-price-input" readonly>
        </td>
        <td class="border px-4 py-2 total-price">₱0.00</td>
        <td class="border px-4 py-2">
            <button type="button" 
                class="remove-btn text-white px-2 py-1 rounded hover:bg-red-600 transition"
                style="background-color: rgb(239 68 68);">
                Remove
            </button>
        </td>
    `;
    costingBody.appendChild(row);

    const qtyInput = row.querySelector('.quantity-input');
    const removeBtn = row.querySelector('.remove-btn');

    qtyInput.addEventListener('input', () => {
        updateTotals();
        updateQuotation();
    });
    removeBtn.addEventListener('click', () => {
        row.remove();
        updateTotals();
        updateQuotation();
    });

    updateTotals();
});

// Events for quotation inputs
quoteQty.addEventListener('input', updateQuotation);
quoteMarkup.addEventListener('input', updateQuotation);
quoteDiscount.addEventListener('input', updateQuotation);

</script>


@endsection
