<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Columns na pwedeng i-mass assign
    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'product_name',
        'quantity',
        'cost_per_piece',
        'markup',
        'selling_price_per_piece',
        'discount_percentage',
        'total_price',
        'raw_materials',
        'overall_cost',
    ];
}
