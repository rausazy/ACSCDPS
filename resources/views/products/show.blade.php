@extends('layouts.app')

@section('content')

<div class="min-h-screen flex flex-col items-center py-16 px-4 sm:px-6 lg:px-8">

    <div style="width:100%;max-width:80rem;margin-bottom:1.5rem;margin-top:-2rem;">
        <a href="{{ url('/products') }}" 
           style="display:inline-flex;align-items:center;color:#9333ea;font-weight:500;text-decoration:none;transition:color .2s ease;">
            <svg xmlns="http://www.w3.org/2000/svg" style="height:20px;width:20px;margin-right:0.5rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Products
        </a>
    </div>

    <div style="text-align:center;margin-bottom:3.5rem;width:100%;display:flex;justify-content:center;align-items:center;gap:1rem;">
        <x-dynamic-component :component="'heroicon-o-' . $product->icon" style="width:3rem;height:3rem;" /> 
        <h1 style="font-size:3rem;font-weight:800;background:linear-gradient(to right,#9333ea,#ec4899,#3b82f6);-webkit-background-clip:text;color:transparent;line-height:1.2;padding-bottom:0.5rem;">
            {{ $product->name }}
        </h1>
    </div>

    <div style="width:100%;max-width:80rem;margin-bottom:2rem;padding:1.5rem;border-radius:1rem;box-shadow:0 4px 6px rgba(0,0,0,0.1);background:#fff;">
        <h2 style="font-weight:700;font-size:1.5rem;margin-bottom:1rem;">Customer Details</h2>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem;">
            <div>
                <label class="block mb-1 font-medium text-gray-700">Name</label>
                <input type="text" id="customerName" placeholder="Customer Name"
                    style="width:100%;padding:0.5rem 0.75rem;border:1px solid #d1d5db;border-radius:0.375rem;outline:none;">
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700">Email</label>
                <input type="email" id="customerEmail" placeholder="Email Address"
                    style="width:100%;padding:0.5rem 0.75rem;border:1px solid #d1d5db;border-radius:0.375rem;outline:none;">
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700">Phone</label>
                <input type="text" id="customerPhone" placeholder="Phone Number"
                    maxlength="11"
                    pattern="\d*"
                    oninput="this.value = this.value.replace(/\D/g,'').slice(0,11);"
                    style="width:100%;padding:0.5rem 0.75rem;border:1px solid #d1d5db;border-radius:0.375rem;outline:none;">
            </div>
            <div style="grid-column:1/-1;">
                <label class="block mb-1 font-medium text-gray-700">Address</label>
                <input type="text" id="customerAddress" placeholder="Full Address"
                    style="width:100%;padding:0.5rem 0.75rem;border:1px solid #d1d5db;border-radius:0.375rem;outline:none;">
            </div>
        </div>
    </div>
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

    <div style="width:100%;max-width:80rem;padding:1.5rem;border-radius:1rem;box-shadow:0 4px 6px rgba(0,0,0,0.1);background:#fff;overflow-x:auto;-webkit-overflow-scrolling:touch;margin:2rem auto 0;">
    
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

        <div style="margin-top:1.5rem;text-align:center;">
            <button type="button" id="confirmOrderBtn" onclick="confirmOrder()"
                style="background-color:rgb(34,197,94);color:white;font-weight:700;border-radius:0.375rem;padding:0.5rem 1.5rem;font-size:1rem;cursor:pointer;transition:background-color .2s ease;min-width:200px;">
                Confirm Order
            </button>
        </div>
    </div>
</div>

<div id="confirmationModal" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; overflow:auto; background-color:rgba(0,0,0,0.4); backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px);">
    <div style="background-color:#fefefe; margin:15% auto; padding:30px; border:1px solid #888; width:90%; max-width:500px; border-radius:0.75rem; text-align:center; box-shadow:0 8px 16px 0 rgba(0,0,0,0.2),0 12px 40px 0 rgba(0,0,0,0.19);">
        <h3 style="margin-bottom:1rem; color:#10b981; font-weight:700; font-size:1.5rem;">Order Confirmed! 🎉</h3>
        <p style="margin-bottom:1.5rem; font-size:1.125rem;">Added to Order History</p>
        <button onclick="closeModal()"
            style="background-color:rgb(34,197,94); color:white; font-weight:500; border-radius:0.375rem; padding:0.6rem 2rem; font-size:1rem; cursor:pointer; transition:background-color .2s ease;">
            Okay
        </button>
    </div>
</div>
<style>
/* ... (existing responsive table styles) ... */
@media (max-width: 640px) {
    .responsive-table thead {display:none;}
    .responsive-table tr {display:block;margin-bottom:0.5rem;border:1px solid #e5e7eb;border-radius:0.5rem;padding:0.25rem;}
    .responsive-table td {display:flex;justify-content:space-between;align-items:center;border:none !important;border-bottom:1px solid #e5e7eb;padding:0.25rem 0.5rem;}
    .responsive-table td:last-child {border-bottom:none;}
    .responsive-table td::before {content:attr(data-label);font-weight:600;color:#374151;margin-right:0.5rem;}
}
</style>


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
const confirmationModal = document.getElementById('confirmationModal'); 

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

function getRawMaterialData() {
    const rawMaterials = [];
    const rows = costingBody.querySelectorAll('tr');

    rows.forEach(row => {
        const name = row.querySelector('td[data-label="Raw Material"]').innerText;
        const qty = parseFloat(row.querySelector('.quantity-input').value) || 0;
        const price = parseFloat(row.querySelector('.unit-price-input').value) || 0;
        const total = qty * price;

        rawMaterials.push({
            id: row.dataset.id,
            name: name,
            quantity: qty,
            unit_price: price,
            total_price: total.toFixed(2)
        });
    });

    return rawMaterials;
}

function closeModal() {
    confirmationModal.style.display = 'none';
}

function confirmOrder() {
    updateQuotation();

    const rawMaterials = getRawMaterialData();
    
    const orderData = {
        customer: {
            name: document.getElementById('customerName').value,
            email: document.getElementById('customerEmail').value,
            phone: document.getElementById('customerPhone').value,
            address: document.getElementById('customerAddress').value,
        },
        costing: {
            raw_materials: rawMaterials,
            overall_cost: parseFloat(overallCostEl.innerText.replace(/[₱,]/g, '')) || 0,
        },
        quotation: {
            product_name: "{{ $product->name }}",
            quantity: parseFloat(document.getElementById('quoteQty').value) || 0,
            cost_per_piece: parseFloat(quoteCostPerPiece.innerText.replace(/[₱,]/g, '')) || 0,
            markup: parseFloat(document.getElementById('quoteMarkup').value) || 0,
            selling_price_per_piece: parseFloat(quoteSellingPrice.innerText.replace(/[₱,]/g, '')) || 0,
            discount_percentage: parseFloat(document.getElementById('quoteDiscount').value) || 0,
            total_price: parseFloat(quoteTotal.innerText.replace(/[₱,]/g, '')) || 0,
        }
    };

    console.log("Order Data Sent to Server:", orderData);
    
    confirmationModal.style.display = 'block';
}

function preparePdfData(event) {
    if (event) event.preventDefault();
    updateQuotation();

    const data = {
        product: "{{ $product->name }}",
        quantity: document.getElementById('quoteQty').value || 0,
        selling_price_per_piece: parseFloat(quoteSellingPrice.innerText.replace(/[₱,]/g, '')) || 0,
        discount: parseFloat(document.getElementById('quoteDiscount').value) || 0,
        total_price: parseFloat(quoteTotal.innerText.replace(/[₱,]/g, '')) || 0,
        customer: {
            name: document.getElementById('customerName').value,
            email: document.getElementById('customerEmail').value,
            phone: document.getElementById('customerPhone').value,
            address: document.getElementById('customerAddress').value,
        }
    };

    document.getElementById('costingDataInput').value = JSON.stringify(data);
    document.getElementById('pdfForm').submit();
}

window.onclick = function(event) {
    if (event.target == confirmationModal) {
        closeModal();
    }
}
</script>

@endsection