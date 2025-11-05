@extends('layouts.app')

@section('content')
<div style="min-height:100vh;display:flex;flex-direction:column;align-items:center;padding:4rem 1rem;">

    <!-- Back link -->
    <div style="width:100%;max-width:80rem;margin-bottom:1.5rem;">
        <a href="{{ url('/products') }}" 
           style="display:inline-flex;align-items:center;color:#9333ea;font-weight:500;text-decoration:none;transition:color .2s ease;">
            <svg xmlns="http://www.w3.org/2000/svg" style="height:20px;width:20px;margin-right:0.5rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Products
        </a>
    </div>

    <!-- Header -->
    <div style="text-align:center;margin-bottom:3.5rem;width:100%;display:flex;justify-content:center;align-items:center;gap:1rem;">
        <x-dynamic-component :component="'heroicon-o-' . $product->icon" style="width:3rem;height:3rem;{{ $product->color }}" />
        <h1 style="font-size:3rem;font-weight:800;background:linear-gradient(to right,#9333ea,#ec4899,#3b82f6);-webkit-background-clip:text;color:transparent;line-height:1.2;padding-bottom:0.5rem;">
            {{ $product->name }}
        </h1>
    </div>

<!-- Costing Section -->
<div style="width:100%;max-width:80rem;padding:1.5rem;border-radius:1rem;box-shadow:0 4px 6px rgba(0,0,0,0.1);background:#fff;overflow-x:auto;-webkit-overflow-scrolling:touch;margin:0 auto;">

    <h2 style="font-size:1.5rem;font-weight:700;margin-bottom:1rem;display:flex;justify-content:space-between;align-items:center;">
        Costing
    </h2>

    @if($rawMaterials->count())
        <div style="margin-bottom:1rem;">
            <label style="display:block;font-weight:500;color:#374151;margin-bottom:0.5rem;">Select Raw Materials to Use</label>
            <select id="rawSelect" style="width:100%;border:1px solid #d1d5db;border-radius:0.375rem;padding:0.5rem 0.75rem;">
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
                style="margin-top:0.75rem;padding:0.5rem 1rem;color:#fff;border-radius:0.375rem;font-weight:500;background-color:rgb(139,92,246);cursor:pointer;transition:background-color .2s ease;display:inline-block;">
                Add
            </button>   
        </div>

        <table class="responsive-table" style="width:100%;border-collapse:collapse;border:1px solid #e5e7eb;table-layout:fixed;">
            <thead>
                <tr style="background-color:#f3f4f6;">
                    <th style="border:1px solid #e5e7eb;padding:0.5rem 1rem;text-align:left;">Raw Material</th>
                    <th style="border:1px solid #e5e7eb;padding:0.5rem 1rem;text-align:left;">Quantity</th>
                    <th style="border:1px solid #e5e7eb;padding:0.5rem 1rem;text-align:left;">Unit Price</th>
                    <th style="border:1px solid #e5e7eb;padding:0.5rem 1rem;text-align:left;">Total Price</th>
                    <th style="border:1px solid #e5e7eb;padding:0.5rem 1rem;text-align:left;">Action</th>
                </tr>
            </thead>
            <tbody id="costingBody"></tbody>
        </table>

        <div style="margin-top:1.5rem;text-align:right;">
            <h3 style="font-size:1.125rem;font-weight:700;color:#1f2937;margin:0;">Overall Cost: <span id="overallCost">₱0.00</span></h3>
            <h3 style="font-size:1.125rem;font-weight:700;color:#1f2937;margin:0;">Overall Revenue: <span id="overallRevenue">₱0.00</span></h3>
        </div>
    @else
        <p style="color:#6b7280;">No raw materials available for this product.</p>
    @endif
</div>


    <div style="height:5rem;"></div>

    <!-- Quotation Section -->
    <div style="width:100%;max-width:80rem;padding:1.5rem;border-radius:1rem;box-shadow:0 4px 6px rgba(0,0,0,0.1);background:#fff;overflow-x:auto;-webkit-overflow-scrolling:touch;margin:0 auto;">
    
        <h2 style="font-size:1.5rem;font-weight:700;margin-bottom:1rem;display:flex;flex-direction:column;gap:0.5rem;">
            <span style="text-align:left;">Quotation</span>

            <form id="pdfForm" method="POST" 
                action="{{ route('products.costing-pdf', $product->url) }}" 
                target="_blank" 
                onsubmit="preparePdfData(event)" 
                style="margin-top:0.5rem;text-align:left;">
                @csrf
                <input type="hidden" name="costing_data" id="costingDataInput">
                <button type="submit" 
                    style="background-color:rgb(147,51,234);color:white;font-weight:500;border-radius:0.375rem;padding:0.375rem 0.75rem;font-size:0.875rem;line-height:1.25rem;cursor:pointer;transition:background-color .2s ease;width:100%;max-width:fit-content;">
                    Export as PDF
                </button>
            </form>
        </h2>

        <table class="responsive-table" style="width:100%;border-collapse:collapse;border:1px solid #e5e7eb;table-layout:fixed;">
            <thead>
                <tr style="background-color:#f3f4f6;">
                    <th style="border:1px solid #e5e7eb;padding:0.5rem 1rem;text-align:left;">Product</th>
                    <th style="border:1px solid #e5e7eb;padding:0.5rem 1rem;text-align:left;">Quantity</th>
                    <th style="border:1px solid #e5e7eb;padding:0.5rem 1rem;text-align:left;">Cost per Piece</th>
                    <th style="border:1px solid #e5e7eb;padding:0.5rem 1rem;text-align:left;">Markup per Piece (₱)</th>
                    <th style="border:1px solid #e5e7eb;padding:0.5rem 1rem;text-align:left;">Selling Price per Piece</th>
                    <th style="border:1px solid #e5e7eb;padding:0.5rem 1rem;text-align:left;">Discount (%)</th>
                    <th style="border:1px solid #e5e7eb;padding:0.5rem 1rem;text-align:left;">Total Price</th>
                </tr>
            </thead>
            <tbody>
                <tr id="quotationRow">
                    <td style="border:1px solid #e5e7eb;padding:0.5rem 1rem;font-weight:500;word-wrap:break-word;overflow-wrap:break-word;" data-label="Product">{{ $product->name }}</td>
                    <td style="border:1px solid #e5e7eb;padding:0.5rem 1rem;" data-label="Quantity">
                        <input type="number" id="quoteQty" min="1" value="0"
                            style="width:70px;padding:0.25rem 0.5rem;border:1px solid #d1d5db;border-radius:0.375rem;">
                    </td>
                    <td id="quoteCostPerPiece" style="border:1px solid #e5e7eb;padding:0.5rem 1rem;" data-label="Cost per Piece">₱0.00</td>
                    <td style="border:1px solid #e5e7eb;padding:0.5rem 1rem;" data-label="Markup per Piece">
                        <input type="number" id="quoteMarkup" step="0.01" value="0"
                            style="width:70px;padding:0.25rem 0.5rem;border:1px solid #d1d5db;border-radius:0.375rem;">
                    </td>
                    <td id="quoteSellingPrice" style="border:1px solid #e5e7eb;padding:0.5rem 1rem;" data-label="Selling Price">₱0.00</td>
                    <td style="border:1px solid #e5e7eb;padding:0.5rem 1rem;" data-label="Discount">
                        <input type="number" id="quoteDiscount" step="0.01" value="0"
                            style="width:70px;padding:0.25rem 0.5rem;border:1px solid #d1d5db;border-radius:0.375rem;">
                    </td>
                    <td id="quoteTotal" style="border:1px solid #e5e7eb;padding:0.5rem 1rem;" data-label="Total">₱0.00</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Mobile responsive -->
    <style>
    @media (max-width: 640px) {
      .responsive-table thead {display:none;}
      .responsive-table tr {display:block;margin-bottom:0.5rem;border:1px solid #e5e7eb;border-radius:0.5rem;padding:0.25rem;}
      .responsive-table td {display:flex;justify-content:space-between;align-items:center;border:none !important;border-bottom:1px solid #e5e7eb;padding:0.25rem 0.5rem;}
      .responsive-table td:last-child {border-bottom:none;}
      .responsive-table td::before {content:attr(data-label);font-weight:600;color:#374151;margin-right:0.5rem;}
    }
    </style>
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

let currentQuoteTotal = 0;

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
    overallRevenueEl.innerText = '₱' + (overallTotal + currentQuoteTotal).toFixed(2);
}

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

        currentQuoteTotal = finalTotal;
    } else {
        quoteCostPerPiece.innerText = '₱0.00';
        quoteSellingPrice.innerText = '₱0.00';
        quoteTotal.innerText = '₱0.00';
        currentQuoteTotal = 0;
    }

    updateTotals();
}

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
        <td class="border px-4 py-2" data-label="Raw Material" style="word-wrap:break-word;overflow-wrap:break-word;">${rawName}</td>
        <td class="border px-4 py-2" data-label="Quantity">
            <input type="number" min="0" value="0" class="quantity-input"
                   style="width:70px;padding:0.25rem 0.5rem;border:1px solid #d1d5db;border-radius:0.375rem;">
        </td>
        <td class="border px-4 py-2" data-label="Unit Price">
            <input type="number" step="0.01" value="${unitPrice}" class="unit-price-input" readonly
                   style="width:100px;padding:0.25rem 0.5rem;border:1px solid #d1d5db;border-radius:0.375rem;">
        </td>
        <td class="border px-4 py-2 total-price" data-label="Total Price">₱0.00</td>
        <td class="border px-4 py-2" data-label="Action">
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

quoteQty.addEventListener('input', updateQuotation);
quoteMarkup.addEventListener('input', updateQuotation);
quoteDiscount.addEventListener('input', updateQuotation);

function preparePdfData(event) {
    if (event) event.preventDefault();
    updateQuotation();

    const data = {
        product: "{{ $product->name }}",
        quantity: document.getElementById('quoteQty').value || 0,
        selling_price_per_piece: parseFloat(quoteSellingPrice.innerText.replace(/[₱,]/g, '')) || 0,
        discount: parseFloat(document.getElementById('quoteDiscount').value) || 0,
        total_price: parseFloat(quoteTotal.innerText.replace(/[₱,]/g, '')) || 0
    };

    document.getElementById('costingDataInput').value = JSON.stringify(data);
    document.getElementById('pdfForm').submit();
}
</script>

@endsection
