<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon', 'color', 'url'];

    public function stock()
    {
        return $this->morphOne(Stock::class, 'stockable');
    }

    /**
     * Accessor para consistent display name
     */
    public function getDisplayNameAttribute()
    {
        return $this->name; // column name sa services table
    }
}
