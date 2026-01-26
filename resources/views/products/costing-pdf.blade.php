<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quotation PDF</title>
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

        tfoot td { 
            font-weight: 700; 
        }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.20;
            width: 500px;
            z-index: 1;
        }
    </style>
</head>
<body>

    <!-- Watermark -->
    <img src="{{ public_path('images/CinleiLogo.png') }}" class="watermark" alt="Watermark">

    <!-- Header: Logo + Company Info -->
    <div style="display:flex; align-items:center; justify-content:center; margin-bottom:20px; position:relative; z-index:2;">
        <!-- Logo (left) -->
        <div style="position:absolute; left:0; top:0;">
            <img src="{{ public_path('images/CinleiLogo.png') }}" alt="Logo" style="height:80px;">
        </div>

        <!-- Company info (center) -->
        <div style="text-align:center;">
            <h1 style="line-height:1.2;">Cinlei Digital Printing Services</h1>
            <p>Brgy. Palo Alto, Calamba, Philippines</p>
            <p>0966 286 7155 | cinlei2022@gmail.com</p>
        </div>
    </div>

<hr style="border:1px solid #d1d5db; margin-bottom:15px; position:relative; z-index:2;">

<p style="
    margin-top:10px;
    text-align:center;
    font-size:30px;
    font-weight:700;
    color:#6b7280;
    letter-spacing:2px;
">
    QUOTATION
</p>


    <!-- Quotation table -->
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Selling Price / Piece</th>
                <th>Discount (%)</th>
                <th>Total Price</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>{{ $costingData['product'] }}</td>
                <td>{{ $costingData['quantity'] }}</td>
                <td>₱{{ number_format($costingData['selling_price_per_piece'], 2, '.', ',') }}</td>
                <td>{{ $costingData['discount'] }}%</td>
                <td>₱{{ number_format($costingData['total_price'], 2, '.', ',') }}</td>
            </tr>
        </tbody>

        <tfoot>
            <tr>
                <td colspan="4" style="text-align:right;">Total:</td>
                <td>₱{{ number_format($costingData['total_price'], 2, '.', ',') }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- Footer -->
    <div style="text-align:center; margin-top:20px; font-size:11px; color:#6b7280; position:relative; z-index:2;">
        <em style="font-size:12px; color:#9ca3af; display:block; margin-bottom:5px;">
            "Printing your visions into reality."
        </em>

        <strong style="display:block; font-size:12px; color:#4B5563; margin-bottom:2px;">
            Rubelyn N. Palacol
        </strong>

        <span style="display:block; font-size:10px; color:#9ca3af;">
            PROPRIETOR
        </span>
    </div>

    <!-- Generated on -->
    <div style="text-align:right; font-size:10px; color:#6b7280; margin-top:10px; position:relative; z-index:2;">
        Generated on {{ \Carbon\Carbon::now('Asia/Manila')->format('F d, Y h:i A') }}
    </div>

</body>
</html>
