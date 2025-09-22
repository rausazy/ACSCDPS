<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
    protected $fillable = [
        'stock_id',
        'name',
        'quantity',
        'price',
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}

