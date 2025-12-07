@extends('layouts.app')

@section('content')
<div style="min-height:100vh; display:flex; flex-direction:column; align-items:center; padding:2rem 1rem;">

    <!-- Header -->
    <div style="display:flex; flex-direction:column; align-items:flex-start; width:100%; max-width:72rem; margin-bottom:3rem;">
        <h1 style="
            font-size:clamp(2rem, 5vw, 3rem); 
            font-weight:800; 
            background:linear-gradient(to right, #8b5cf6, #ec4899, #3b82f6); 
            -webkit-background-clip:text; 
            -webkit-text-fill-color:transparent; 
            line-height:1.2; 
            margin-bottom:0.5rem;
        ">History</h1>
        <p style="font-size:clamp(0.875rem, 3vw, 1rem); color:#4B5563; max-width:42rem; line-height:1.5;">
            A record of past orders grouped by date and customer.
        </p>
    </div>

    <!-- Page Content -->
    <div style="width:100%; max-width:48rem; display:flex; flex-direction:column; gap:2rem;">
        @php
            $ordersByDate = $orders->groupBy(function($order) {
                return $order->created_at->format('Y-m-d');
            });
        @endphp

        @forelse($ordersByDate as $date => $ordersOfDate)
            <div style="background-color:#F9FAFB; border-radius:0.75rem; padding:1rem; box-shadow:0 1px 2px rgba(0,0,0,0.05);">
                <h2 style="font-size:clamp(1rem,4vw,1.125rem); font-weight:600; color:#374151; margin-bottom:1rem;">
                    {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}
                </h2>

                @php
                    $ordersByCustomer = $ordersOfDate->groupBy('customer_name');
                @endphp

                @foreach($ordersByCustomer as $customerName => $customerOrders)
                    <div style="
                        margin-bottom:1rem; 
                        border:1px solid #E5E7EB; 
                        border-radius:0.5rem; 
                        overflow:hidden; 
                        transition:box-shadow 0.3s; 
                        box-shadow:0 1px 2px rgba(0,0,0,0.05);
                    " 
                        onmouseover="this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)'" 
                        onmouseout="this.style.boxShadow='0 1px 2px rgba(0,0,0,0.05)'">

                        <!-- Customer Header -->
                        <button type="button" style="
                            width:100%; 
                            text-align:left; 
                            padding:1rem 1rem; 
                            background-color:#FFFFFF; 
                            border-left:4px solid #8B5CF6; 
                            border-top-left-radius:0.5rem; 
                            border-top-right-radius:0.5rem; 
                            display:flex; 
                            justify-content:space-between; 
                            align-items:center; 
                            cursor:pointer; 
                            transition:background-color 0.3s;" 
                            class="customer-header">
                            <span style="font-weight:600; color:#1F2937; font-size:clamp(0.875rem,3vw,1rem); overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $customerName }}</span>
                            <svg style="width:1.25rem; height:1.25rem; transition:transform 0.3s;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Customer Orders (Collapsed) -->
                        <div class="customer-orders" style="max-height:0; overflow:hidden; transition:max-height 0.5s ease;">
                            <div style="padding:1rem; background-color:#FFFFFF; display:flex; flex-direction:column; gap:0.5rem; overflow-x:auto;">
                                <table style="width:100%; min-width:600px; border-collapse:collapse; table-layout:auto;">
                                    <thead>
                                        <tr style="background-color:#F3F4F6;">
                                            <th style="border:1px solid #E5E7EB; padding:0.5rem; text-align:left;">Product</th>
                                            <th style="border:1px solid #E5E7EB; padding:0.5rem; text-align:left;">Quantity</th>
                                            <th style="border:1px solid #E5E7EB; padding:0.5rem; text-align:left;">Selling Price</th>
                                            <th style="border:1px solid #E5E7EB; padding:0.5rem; text-align:left;">Discount (%)</th>
                                            <th style="border:1px solid #E5E7EB; padding:0.5rem; text-align:left;">Total Price</th>
                                            <th style="border:1px solid #E5E7EB; padding:0.5rem; text-align:left;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($customerOrders as $order)
                                            <tr id="order-row-{{ $order->id }}" style="transition:opacity 0.5s;">
                                                <td style="border:1px solid #E5E7EB; padding:0.5rem; font-size:clamp(0.75rem,3vw,0.875rem);">{{ $order->product_name }}</td>
                                                <td style="border:1px solid #E5E7EB; padding:0.5rem; font-size:clamp(0.75rem,3vw,0.875rem);">{{ $order->quantity }}</td>
                                                <td style="border:1px solid #E5E7EB; padding:0.5rem; font-size:clamp(0.75rem,3vw,0.875rem);">₱{{ number_format($order->selling_price_per_piece, 2) }}</td>
                                                <td style="border:1px solid #E5E7EB; padding:0.5rem; font-size:clamp(0.75rem,3vw,0.875rem);">{{ $order->discount_percentage }}</td>
                                                <td style="border:1px solid #E5E7EB; padding:0.5rem; font-size:clamp(0.75rem,3vw,0.875rem);">₱{{ number_format($order->total_price, 2) }}</td>
                                                <td style="border:1px solid #E5E7EB; padding:0.5rem; display:flex; gap:0.5rem;">
                                                    <button type="button" data-id="{{ $order->id }}" style="padding:0.25rem 0.5rem; background-color:#DC2626; color:white; border-radius:0.25rem; transition:background-color 0.2s; font-size:clamp(0.625rem,3vw,0.75rem);" onmouseover="this.style.backgroundColor='#B91C1C'" onmouseout="this.style.backgroundColor='#DC2626'" class="delete-order">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Export PDF per customer -->
                                <form method="POST" action="{{ route('history.export-pdf') }}" target="_blank" style="margin-top:0.5rem;">
                                    @csrf
                                    <input type="hidden" name="customer_name" value="{{ $customerName }}">
                                    <input type="hidden" name="date" value="{{ $date }}">
                                    <button type="submit" style="padding:0.5rem 0.75rem; background-color:#8B5CF6; color:white; border-radius:0.25rem; transition:background-color 0.2s; font-size:clamp(0.75rem,3vw,0.875rem);" onmouseover="this.style.backgroundColor='#7C3AED'" onmouseout="this.style.backgroundColor='#8B5CF6'">Export PDF</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @empty
            <p style="text-align:center; color:#6B7280;">No history yet.</p>
        @endforelse
    </div>
</div>

<script>
    // Toggle customer orders
    document.querySelectorAll('.customer-header').forEach(header => {
        header.addEventListener('click', () => {
            const ordersDiv = header.nextElementSibling;
            if (ordersDiv.style.maxHeight && ordersDiv.style.maxHeight !== '0px') {
                ordersDiv.style.maxHeight = '0';
                header.querySelector('svg').style.transform = 'rotate(0deg)';
            } else {
                ordersDiv.style.maxHeight = ordersDiv.scrollHeight + 'px';
                header.querySelector('svg').style.transform = 'rotate(180deg)';
            }
        });
    });

    // AJAX Delete
    document.querySelectorAll('.delete-order').forEach(button => {
        button.addEventListener('click', function() {
            if(!confirm('Are you sure you want to delete this order?')) return;
            const orderId = this.dataset.id;
            const row = document.getElementById(`order-row-${orderId}`);
            fetch(`/history/${orderId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            })
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    row.style.transition = 'opacity 0.5s';
                    row.style.opacity = 0;
                    setTimeout(()=>row.remove(),500);
                } else {
                    alert('Failed to delete order.');
                }
            })
            .catch(err => console.error(err));
        });
    });
</script>
@endsection
