<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockSize extends Model
{
    use HasFactory;

    protected $fillable = ['stock_id', 'size_name', 'quantity'];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
