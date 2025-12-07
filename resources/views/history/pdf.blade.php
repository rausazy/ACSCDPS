<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order History PDF</title>
    <style>
        @page { margin: 20px; }
        body { 
            font-family: "DejaVu Sans", sans-serif; 
            font-size: 14px; 
            color: #1f2937; 
            margin: 0; 
            position: relative;
        }

        h1 { 
            font-size: 26px; 
            color: #9C89B8; 
            margin: 0; 
        }

        p { 
            margin: 2px 0; 
            font-size: 12px; 
            color: #374151; 
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
            font-size: 13px;
            position: relative;
            z-index: 2; /* above watermark */
        }

        th, td { 
            border: 1px solid #d1d5db; 
            padding: 6px 8px; 
            text-align: left; 
        }

        th { 
            font-weight: 600; 
        }

        tbody tr:nth-child(even) { 
            /* background removed to show watermark */
        }

        tfoot td { 
            font-weight: 700; 
        }

        .footer { 
            margin-top: 20px; 
            font-size: 11px; 
            color: #6b7280; 
            text-align: center; 
        }

        /* Watermark style */
        .watermark {
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.20; /* subtle */
            width: 500px;
            z-index: 1; /* behind content */
        }
    </style>
</head>
<body>
    <!-- Watermark -->
    <img src="{{ public_path('images/CinleiLogo.png') }}" class="watermark" alt="Watermark">

    <!-- Header: Logo + Company Info -->
    <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 20px; position: relative; z-index:2;">
        <!-- Logo sa left -->
        <div style="position: absolute; left: 0; top: 0;">
            <img src="{{ public_path('images/CinleiLogo.png') }}" alt="Logo" style="height: 80px;">
        </div>

        <!-- Company info sa center -->
        <div style="text-align: center;">
            <h1 style="line-height: 1.2;">Cinlei Digital Printing Services</h1>
            <p>Brgy. Palo Alto, Calamba, Philippines</p>
            <p>0966 286 7155 | cinlei2022@gmail.com</p>
        </div>
    </div>

    <hr style="border:1px solid #d1d5db; margin-bottom: 15px; z-index:2; position: relative;">

    <!-- Customer info sa left -->
    <div style="text-align: left; margin-bottom: 15px; font-size:12px;">
        <p><strong>Customer:</strong> {{ $customerName }}</p>
        <p><strong>Email:</strong> {{ $customerEmail }}</p>
        <p><strong>Phone:</strong> {{ $customerPhone }}</p>
        <p><strong>Address:</strong> {{ $customerAddress }}</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</p>
    </div>

    <!-- Table of orders -->
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Selling Price</th>
                <th>Discount (%)</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->product_name }}</td>
                <td>{{ $order->quantity }}</td>
                <td>₱{{ number_format($order->selling_price_per_piece, 2, '.', ',') }}</td>
                <td>{{ $order->discount_percentage }}</td>
                <td>₱{{ number_format($order->total_price, 2, '.', ',') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align:right;">Total:</td>
                <td>₱{{ number_format($orders->sum('total_price'), 2, '.', ',') }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- Footer -->
    <div style="text-align: center; margin-top: 20px; font-size: 11px; color: #6b7280; position: relative; z-index:2;">
        <!-- Quote -->
        <em style="font-size:12px; color:#9ca3af; display:block; margin-bottom:5px;">
            "Printing your visions into reality."
        </em>

        <!-- Proprietor Name -->
        <strong style="display:block; font-size:12px; color:#4B5563; margin-bottom:2px;">
            Rubelyn N. Palacol
        </strong>

        <!-- Proprietor Title -->
        <span style="display:block; font-size:10px; color:#9ca3af;">
            PROPRIETOR
        </span>
    </div>

    <!-- Generated on (Right-aligned at bottom) -->
    <div style="text-align: right; font-size: 10px; color:#6b7280; margin-top:10px;">
        Generated on {{ \Carbon\Carbon::now('Asia/Manila')->format('F d, Y h:i A') }}
    </div>
</body>
</html>
