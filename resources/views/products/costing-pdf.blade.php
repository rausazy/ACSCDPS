<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quotation - {{ $product->name }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #f3f3f3;
        }
    </style>
</head>
<body>
    <h2>Quotation</h2>

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
                <td>₱{{ number_format($costingData['selling_price_per_piece'], 2) }}</td>
                <td>{{ $costingData['discount'] }}%</td>
                <td>₱{{ number_format($costingData['total_price'], 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
