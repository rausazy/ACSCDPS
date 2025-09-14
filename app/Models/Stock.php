<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['stockable_id', 'stockable_type', 'quantity'];

    public function stockable()
    {
        return $this->morphTo();
    }
}
