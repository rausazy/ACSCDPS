<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon', 'url', 'color'];

    public function stock()
    {
        return $this->morphOne(Stock::class, 'stockable');
    }

    /**
     * Accessor para consistent display name
     */
    public function getDisplayNameAttribute()
    {
        return $this->name; // column name sa products table
    }
}
