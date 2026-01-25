<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Monthly Analytics Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }
        h1 {
            text-align: center;
            margin-bottom: 5px;
        }
        h3 {
            text-align: center;
            margin-top: 0;
            font-weight: normal;
        }

        .chart-box{
            margin-top: 16px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-align: center;
        }
        .chart-box img{
            width: 100%;
            max-width: 720px;
            height: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 18px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: right;
        }
        th {
            background: #f3f4f6;
        }
        td:first-child, th:first-child {
            text-align: left;
        }
        .summary {
            margin-top: 18px;
        }
    </style>
</head>
<body>

<h1>Cinlei Digital Printing Services</h1>
<h3>Monthly Analytics Report</h3>

{{-- ✅ CHART IMAGE (from canvas base64) --}}
@if(!empty($chartImage))
    <div class="chart-box">
        <div style="font-weight:bold; margin-bottom:8px;">Monthly Analytics Chart</div>
        <img src="{{ $chartImage }}" alt="Monthly Analytics Chart">
    </div>
@else
    <div style="margin-top:16px; text-align:center; color:#777; font-style:italic;">
        Chart not available.
    </div>
@endif

<table>
    <thead>
        <tr>
            <th>Month</th>
            <th>Revenue (₱)</th>
            <th>Expenses (₱)</th>
            <th>Net Income (₱)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
        <tr>
            <td>{{ $row['month'] }}</td>
            <td>{{ number_format($row['revenue'], 2) }}</td>
            <td>{{ number_format($row['expenses'], 2) }}</td>
            <td>{{ number_format($row['net'], 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="summary">
    <strong>Total Revenue:</strong> ₱{{ number_format($totalRevenue, 2) }} <br>
    <strong>Total Expenses:</strong> ₱{{ number_format($totalExpenses, 2) }} <br>
    <strong>Total Net Income:</strong> ₱{{ number_format($totalNet, 2) }}
</div>

</body>
</html>
