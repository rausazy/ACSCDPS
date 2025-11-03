<!DOCTYPE html>
<html>
<head>
    <title>{{ $product->name }} Costing</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 14px; 
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            text-align: center;
            margin-bottom: 10px;
        }

        header img {
            height: 60px;
        }

        header h2 {
            margin: 5px 0;
            color: #4B0082;
        }

        header .contact {
            font-size: 12px;
            margin-bottom: 10px;
        }

        /* Customer info box */
        .customer-info {
            margin-bottom: 10px;
            font-size: 13px;
        }

        table { 
            width: 80%; 
            margin: 0 auto 20px auto; /* center table */
            border-collapse: collapse; 
        }

        th, td { 
            border: 1px solid #ccc; 
            padding: 6px; 
            text-align: left; 
        }

        th { 
            background-color: #f5f5f5; 
            color: #4B0082; 
            font-weight: bold;
        }

        tr:nth-child(even) { 
            background-color: #f9f9f9; 
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 400px;
            height: 400px;
            opacity: 0.1;
            transform: translate(-50%, -50%);
        }

        .totals {
            width: 80%;
            margin: 0 auto 20px auto;
            text-align: right;
            font-weight: bold;
        }

        footer {
            text-align: center;
            margin-top: 40px;
        }

        footer p {
            margin: 2px;
        }
    </style>
</head>
<body>

    <header>
        <img src="{{ public_path('images/CinleiLogo.png') }}" alt="Logo">
        <h2>Cinlei Digital Printing Services</h2>
        <div class="contact">
            Email: cinlei@example.com | Phone: 0912-345-6789 | Facebook: /cinleidigital
        </div>
    </header>

    <div class="customer-info">
        <strong>Customer Name:</strong> {{ $customerName ?? 'N/A' }}<br>
        <strong>Order Date:</strong> {{ $orderDate ?? date('Y-m-d') }}
    </div>

    <!-- Watermark -->
    <img class="watermark" src="{{ public_path('images/CinleiLogo.png') }}" alt="Logo">

    <h3 style="text-align:center;">{{ $product->name }} Costing</h3>

    <table>
        <thead>
            <tr>
                <th>Raw Material</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Price</th>
                <th>Desired Profit</th>
            </tr>
        </thead>
        <tbody>
            @php
                $overallCost = 0;
                $overallRevenue = 0;
            @endphp
            @foreach($costingData as $raw)
                @php
                    $qty = $raw['quantity'] ?? 0;
                    $unit = $raw['unit_price'] ?? 0;
                    $profit = $raw['profit'] ?? 0;
                    $total = $qty * $unit;
                    $overallCost += $total;
                    $overallRevenue += $total + $profit;
                @endphp
                <tr>
                    <td>{{ $raw['name'] }}</td>
                    <td>{{ $qty }}</td>
                    <td>₱{{ number_format($unit,2) }}</td>
                    <td>₱{{ number_format($total,2) }}</td>
                    <td>₱{{ number_format($profit,2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <p>Overall Cost: ₱{{ number_format($overallCost,2) }}</p>
        <p>Overall Revenue: ₱{{ number_format($overallRevenue,2) }}</p>
    </div>

    <footer>
        <p>Rubelyn N. Palacol</p>
        <p>PROPRIETOR</p>
    </footer>

</body>
</html>
