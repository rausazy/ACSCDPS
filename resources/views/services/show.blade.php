@extends('layouts.app')

@section('content')

{{-- TINANGGALAN NG background-color: #f7f7f7; --}}
<div style="min-height:100vh; display:flex; flex-direction:column; align-items:center; padding-top:4rem; padding-bottom:4rem; padding-left:1rem; padding-right:1rem;">


<div style="width:100%; max-width:80rem; margin-bottom:1.5rem;">
    <a href="{{ url('/services') }}" 
        style="display:inline-flex; align-items:center; color:#9333ea; font-weight:500; text-decoration:none; transition:color .2s ease;">
        <svg xmlns="http://www.w3.org/2000/svg" style="height:20px; width:20px; margin-right:0.5rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Services
    </a>
</div>

<div style="text-align:center; margin-bottom:3.5rem; width:100%; display:flex; justify-content:center; align-items:center; gap:1rem;">
    <x-dynamic-component :component="'heroicon-o-' . $service->icon" style="width:3rem; height:3rem; color:#9333ea;" />
    <h1 style="font-size:3rem; font-weight:800; background:linear-gradient(to right,#9333ea,#ec4899,#3b82f6); -webkit-background-clip:text; color:transparent; line-height:1.2; padding-bottom:0.5rem;">
        {{ $service->name }}
    </h1>
</div>

<div style="width:100%; max-width:80rem; margin-bottom:2rem; padding:1.5rem; border-radius:1rem; box-shadow:0 4px 6px rgba(0,0,0,0.1); background:#fff;">
    <h2 style="font-weight:700; font-size:1.5rem; margin-bottom:1rem; color:#1f2937;">Customer Details</h2>
    <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:1rem;">
        <div>
            <label style="display:block; margin-bottom:0.25rem; font-weight:500; color:#4b5563;">Name</label>
            <input type="text" id="customerName" placeholder="Customer Name"
                style="width:100%; padding:0.5rem 0.75rem; border:1px solid #d1d5db; border-radius:0.375rem; outline:none; transition:border-color .2s ease;"
                onfocus="this.style.borderColor='#9333ea';" onblur="this.style.borderColor='#d1d5db';">
        </div>
        <div>
            <label style="display:block; margin-bottom:0.25rem; font-weight:500; color:#4b5563;">Email</label>
            <input type="email" id="customerEmail" placeholder="Email Address"
                style="width:100%; padding:0.5rem 0.75rem; border:1px solid #d1d5db; border-radius:0.375rem; outline:none; transition:border-color .2s ease;"
                onfocus="this.style.borderColor='#9333ea';" onblur="this.style.borderColor='#d1d5db';">
        </div>
        <div>
            <label style="display:block; margin-bottom:0.25rem; font-weight:500; color:#4b5563;">Phone</label>
            <input type="text" id="customerPhone" placeholder="Phone Number"
                maxlength="11"
                pattern="\d*"
                oninput="this.value = this.value.replace(/\D/g,'').slice(0,11);"
                style="width:100%; padding:0.5rem 0.75rem; border:1px solid #d1d5db; border-radius:0.375rem; outline:none; transition:border-color .2s ease;"
                onfocus="this.style.borderColor='#9333ea';" onblur="this.style.borderColor='#d1d5db';">
        </div>
        <div style="grid-column:1/-1;">
            <label style="display:block; margin-bottom:0.25rem; font-weight:500; color:#4b5563;">Address</label>
            <input type="text" id="customerAddress" placeholder="Full Address"
                style="width:100%; padding:0.5rem 0.75rem; border:1px solid #d1d5db; border-radius:0.375rem; outline:none; transition:border-color .2s ease;"
                onfocus="this.style.borderColor='#9333ea';" onblur="this.style.borderColor='#d1d5db';">
        </div>
    </div>
</div>

<div style="width:100%; max-width:80rem; padding:1.5rem; border-radius:1rem; box-shadow:0 4px 6px rgba(0,0,0,0.1); background:#fff; overflow-x:auto; -webkit-overflow-scrolling:touch; margin:0 auto;">

    <h2 style="font-size:1.5rem; font-weight:700; margin-bottom:1rem; color:#1f2937;">
        Costing
    </h2>

    @if($rawMaterials->count())
        <div style="margin-bottom:1.5rem; border:1px solid #e5e7eb; padding:1rem; border-radius:0.5rem; background-color: #f9fafb;">
            <label style="display:block; font-weight:500; color:#374151; margin-bottom:0.5rem;">Select Raw Materials to Use</label>
            <div style="display:flex; gap:0.5rem; flex-wrap: wrap; align-items: flex-end;">
                <select id="rawSelect" style="flex-grow:1; min-width: 200px; border:1px solid #d1d5db; border-radius:0.375rem; padding:0.5rem 0.75rem; outline:none;">
                    <option value="">-- Choose Raw Material --</option>
                    @foreach($rawMaterials as $raw)
                        <option value="{{ $raw->id }}" data-name="{{ $raw->name }}" data-price="{{ $raw->price }}">
                            {{ $raw->name }} (₱{{ number_format($raw->price, 2) }})
                        </option>
                    @endforeach
                </select>
                <button type="button" id="addRawBtn" 
                    style="padding:0.5rem 1rem; color:#fff; border-radius:0.375rem; font-weight:500; background-color:#9333ea; cursor:pointer; transition:background-color .2s ease; border:none; flex-shrink: 0;">
                    Add
                </button> 
            </div>
        </div>

        <table class="responsive-table" style="width:100%; border-collapse:collapse; border:1px solid #e5e7eb; table-layout:fixed;">
            <thead>
                <tr style="background-color:#f3f4f6; color:#374151;">
                    <th style="border:1px solid #e5e7eb; padding:0.75rem 1rem; text-align:left; font-size:0.875rem; font-weight:600;">Raw Material</th>
                    <th style="border:1px solid #e5e7eb; padding:0.75rem 1rem; text-align:left; font-size:0.875rem; font-weight:600;">Quantity</th>
                    <th style="border:1px solid #e5e7eb; padding:0.75rem 1rem; text-align:left; font-size:0.875rem; font-weight:600;">Unit Price</th>
                    <th style="border:1px solid #e5e7eb; padding:0.75rem 1rem; text-align:left; font-size:0.875rem; font-weight:600;">Total Price</th>
                    <th style="border:1px solid #e5e7eb; padding:0.75rem 1rem; text-align:left; font-size:0.875rem; font-weight:600;">Action</th>
                </tr>
            </thead>
            <tbody id="costingBody"></tbody>
        </table>

        <div style="margin-top:1.5rem; text-align:right;">
            <h3 style="font-size:1.125rem; font-weight:700; color:#1f2937; margin:0.25rem 0;">Overall Cost: <span id="overallCost" style="color:#ef4444;">₱0.00</span></h3>
            <h3 style="font-size:1.125rem; font-weight:700; color:#1f2937; margin:0.25rem 0;">Overall Revenue: <span id="overallRevenue" style="color:#10b981;">₱0.00</span></h3>
        </div>
    @else
        <p style="color:#6b7280; padding:1rem; border:1px dashed #d1d5db; border-radius:0.5rem; text-align:center;">No raw materials available for this service.</p>
    @endif
</div>

<div style="width:100%; max-width:80rem; padding:1.5rem; border-radius:1rem; box-shadow:0 4px 6px rgba(0,0,0,0.1); background:#fff; overflow-x:auto; -webkit-overflow-scrolling:touch; margin:2rem auto 0;"> 
    <h2 style="font-size:1.5rem; font-weight:700; margin-bottom:1rem; display:flex; flex-direction:column; gap:0.5rem; color:#1f2937;">
        <span style="text-align:left;">Quotation</span>

        <form id="pdfForm" method="POST" 
            action="{{ route('services.costing-pdf', $service->url) }}" 
            target="_blank" 
            onsubmit="preparePdfData(event)" 
            style="margin-top:0.5rem; text-align:left;">
            @csrf
            <input type="hidden" name="costing_data" id="costingDataInput">
            <button type="submit" 
                style="background-color:#9333ea; color:white; font-weight:500; border-radius:0.375rem; padding:0.375rem 0.75rem; font-size:0.875rem; line-height:1.25rem; cursor:pointer; transition:background-color .2s ease; border:none;">
                Export as PDF
            </button>
        </form>
    </h2>

    <table class="responsive-table" style="width:100%; border-collapse:collapse; border:1px solid #e5e7eb; table-layout:fixed;">
        <thead>
            <tr style="background-color:#f3f4f6; color:#374151;">
                <th style="border:1px solid #e5e7eb; padding:0.75rem 1rem; text-align:left; font-size:0.875rem; font-weight:600;">Service</th>
                <th style="border:1px solid #e5e7eb; padding:0.75rem 1rem; text-align:left; font-size:0.875rem; font-weight:600;">Quantity</th>
                <th style="border:1px solid #e5e7eb; padding:0.75rem 1rem; text-align:left; font-size:0.875rem; font-weight:600;">Cost per Unit</th>
                <th style="border:1px solid #e5e7eb; padding:0.75rem 1rem; text-align:left; font-size:0.875rem; font-weight:600;">Markup (₱)</th>
                <th style="border:1px solid #e5e7eb; padding:0.75rem 1rem; text-align:left; font-size:0.875rem; font-weight:600;">Selling Price</th>
                <th style="border:1px solid #e5e7eb; padding:0.75rem 1rem; text-align:left; font-size:0.875rem; font-weight:600;">Discount (%)</th>
                <th style="border:1px solid #e5e7eb; padding:0.75rem 1rem; text-align:left; font-size:0.875rem; font-weight:600;">Total Price</th>
            </tr>
        </thead>
        <tbody>
            <tr id="quotationRow" style="background-color: #fff;">
                <td style="border:1px solid #e5e7eb; padding:0.5rem 1rem; font-weight:500; word-wrap:break-word; overflow-wrap:break-word;" data-label="Service">{{ $service->name }}</td>
                <td style="border:1px solid #e5e7eb; padding:0.5rem 1rem;" data-label="Quantity">
                    <input type="number" id="quoteQty" min="1" value="0"
                        style="width:70px; padding:0.25rem 0.5rem; border:1px solid #d1d5db; border-radius:0.375rem; outline:none; text-align: center;">
                </td>
                <td id="quoteCostPerPiece" style="border:1px solid #e5e7eb; padding:0.5rem 1rem; color:#ef4444; font-weight:500;" data-label="Cost per Unit">₱0.00</td>
                <td style="border:1px solid #e5e7eb; padding:0.5rem 1rem;" data-label="Markup per Unit">
                    <input type="number" id="quoteMarkup" step="0.01" value="0"
                        style="width:70px; padding:0.25rem 0.5rem; border:1px solid #d1d5db; border-radius:0.375rem; outline:none; text-align: center;">
                </td>
                <td id="quoteSellingPrice" style="border:1px solid #e5e7eb; padding:0.5rem 1rem; color:#10b981; font-weight:700;" data-label="Selling Price">₱0.00</td>
                <td style="border:1px solid #e5e7eb; padding:0.5rem 1rem;" data-label="Discount">
                    <input type="number" id="quoteDiscount" step="0.01" value="0"
                        style="width:70px; padding:0.25rem 0.5rem; border:1px solid #d1d5db; border-radius:0.375rem; outline:none; text-align: center;">
                </td>
                <td id="quoteTotal" style="border:1px solid #e5e7eb; padding:0.5rem 1rem; font-weight:700; color:#1f2937;" data-label="Total">₱0.00</td>
            </tr>
        </tbody>
    </table>
    
    <div style="margin-top:2rem; text-align:center;">
        <button type="button" id="confirmOrderBtn" onclick="confirmOrder()"
            style="background-color:#10b981; color:white; font-weight:700; border-radius:0.375rem; padding:0.6rem 2rem; font-size:1.125rem; cursor:pointer; transition:background-color .2s ease; min-width:200px; border:none; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.3);">
            Confirm Order
        </button>
    </div>
</div>

<div id="confirmationModal" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; overflow:auto; background-color:rgba(0,0,0,0.4); backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px);">
    <div style="background-color:#fefefe; margin:15% auto; padding:30px; border:1px solid #888; width:90%; max-width:500px; border-radius:0.75rem; text-align:center; box-shadow:0 8px 16px 0 rgba(0,0,0,0.2),0 12px 40px 0 rgba(0,0,0,0.19);">
        <h3 style="margin-bottom:1rem; color:#10b981; font-weight:700; font-size:1.5rem;">Order Confirmed! 🎉</h3>
        <p style="margin-bottom:1.5rem; font-size:1.125rem;">Added to Order History</p>
        <button onclick="closeModal()"
            style="background-color:#10b981; color:white; font-weight:500; border-radius:0.375rem; padding:0.6rem 2rem; font-size:1rem; cursor:pointer; transition:background-color .2s ease; border:none;">
            Okay
        </button>
    </div>
</div>

<style>
@media (max-width: 640px) {
    .responsive-table thead {display:none;}
    .responsive-table tr {
        display:block;
        margin-bottom:1rem; /* Added margin for better separation */
        border:1px solid #e5e7eb;
        border-radius:0.5rem;
        padding:0.5rem; /* Increased padding */
    }
    .responsive-table td {
        display:flex;
        justify-content:space-between;
        align-items:center;
        border:none !important;
        border-bottom:1px solid #e5e7eb;
        padding:0.5rem; /* Increased padding */
    }
    .responsive-table td:last-child {border-bottom:none;}
    .responsive-table td::before {content:attr(data-label);font-weight:600;color:#374151;margin-right:0.5rem;}
    
    /* Ensure inputs in table cells are responsive */
    .responsive-table td input[type="number"], 
    .responsive-table td input[type="text"] {
        text-align: right;
        flex-grow: 1;
        max-width: 100px; /* Limit input width */
    }
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
        <td style="border:1px solid #e5e7eb; padding:0.5rem 1rem; word-wrap:break-word; overflow-wrap:break-word;" data-label="Raw Material">${rawName}</td>
        <td style="border:1px solid #e5e7eb; padding:0.5rem 1rem;" data-label="Quantity">
            <input type="number" min="0" value="0" class="quantity-input" style="width:70px; padding:0.25rem 0.5rem; border:1px solid #d1d5db; border-radius:0.375rem; text-align: center;">
        </td>
        <td style="border:1px solid #e5e7eb; padding:0.5rem 1rem;" data-label="Unit Price">
            <input type="number" step="0.01" value="${unitPrice}" class="unit-price-input" readonly style="width:100px; padding:0.25rem 0.5rem; border:1px solid #d1d5db; border-radius:0.375rem; text-align: center;">
        </td>
        <td class="total-price" style="border:1px solid #e5e7eb; padding:0.5rem 1rem; font-weight:500;" data-label="Total Price">₱0.00</td>
        <td style="border:1px solid #e5e7eb; padding:0.5rem 1rem;" data-label="Action">
            <button type="button" class="remove-btn" style="background-color: #ef4444; color: white; padding:0.25rem 0.5rem; border-radius:0.375rem; font-weight:500; cursor:pointer; transition:background-color .2s ease; border:none;">Remove</button>
        </td>
    `;
    costingBody.appendChild(row);
    const qtyInput = row.querySelector('.quantity-input');
    const removeBtn = row.querySelector('.remove-btn');
    qtyInput.addEventListener('input', () => { updateTotals(); updateQuotation(); });
    removeBtn.addEventListener('click', () => { row.remove(); updateTotals(); updateQuotation(); });
    updateTotals();
    updateQuotation();
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

    // validations
    if (!document.getElementById('customerName').value ||
        !document.getElementById('customerEmail').value ||
        !document.getElementById('customerPhone').value) {
        alert('Please fill out Name, Email, and Phone under Customer Details before confirming the order.');
        return;
    }

    if (rawMaterials.length === 0 ||
        parseFloat(quoteTotal.innerText.replace(/[₱,]/g, '')) <= 0) {
        alert('Please add raw materials, quantity, and set a valid quotation before confirming the order.');
        return;
    }

    // ✅ FORM DATA (para gumana $request->all())
    const formData = new FormData();

    // customer
    formData.append('customer[name]', document.getElementById('customerName').value);
    formData.append('customer[email]', document.getElementById('customerEmail').value);
    formData.append('customer[phone]', document.getElementById('customerPhone').value);
    formData.append('customer[address]', document.getElementById('customerAddress').value);

    // quotation (MATCH SA HISTORY CONTROLLER)
    formData.append('quotation[product_name]', "{{ $service->name }}"); // service name
    formData.append('quotation[quantity]', parseFloat(quoteQty.value) || 0);
    formData.append('quotation[cost_per_piece]', quoteCostPerPiece.innerText.replace(/[₱,]/g, ''));
    formData.append('quotation[markup]', parseFloat(quoteMarkup.value) || 0);
    formData.append('quotation[selling_price_per_piece]', quoteSellingPrice.innerText.replace(/[₱,]/g, ''));
    formData.append('quotation[discount_percentage]', parseFloat(quoteDiscount.value) || 0);
    formData.append('quotation[total_price]', quoteTotal.innerText.replace(/[₱,]/g, ''));

    // costing
    formData.append('costing[overall_cost]', overallCostEl.innerText.replace(/[₱,]/g, ''));
    formData.append('costing[raw_materials]', JSON.stringify(rawMaterials));

    fetch("{{ route('history.store') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: formData
    })
    .then(res => {
        if (!res.ok) throw new Error('Failed to save order');
        return res.json();
    })
    .then(() => {
        confirmationModal.style.display = 'block';
    })
    .catch(err => {
        console.error(err);
        alert('Failed to save order.');
    });
}

function preparePdfData(event) {
    if (event) event.preventDefault();
    updateQuotation();
    
    // Simple validation before PDF export
    if (parseFloat(document.getElementById('quoteQty').value) <= 0 || parseFloat(quoteTotal.innerText.replace(/[₱,]/g, '')) <= 0) {
        alert('Please set a valid Quantity and Quotation before exporting to PDF.');
        return;
    }
    if (!document.getElementById('customerName').value) {
        alert('Please fill out the Customer Name before exporting the quotation.');
        return;
    }
    
    const data = {
        service: "{{ $service->name }}",
        quantity: document.getElementById('quoteQty').value || 0,
        selling_price_per_piece: parseFloat(quoteSellingPrice.innerText.replace(/[₱,]/g, '')) || 0,
        discount: parseFloat(document.getElementById('quoteDiscount').value) || 0,
        total_price: parseFloat(quoteTotal.innerText.replace(/[₱,]/g, '')) || 0,
        raw_materials: getRawMaterialData(), 
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

// Close modal when clicking outside 
window.onclick = function(event) {
    if (event.target == confirmationModal) {
        closeModal();
    }
}

// Initial calculation on load
document.addEventListener('DOMContentLoaded', () => {
    updateTotals();
    updateQuotation();
});
</script>

@endsection