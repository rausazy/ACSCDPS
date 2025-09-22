<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'stockable_id',
        'stockable_type',
    ];

    /**
     * Polymorphic relation (if stock belongs to Product or Service, etc.)
     */
    public function stockable()
    {
        return $this->morphTo();
    }

    /**
     * Relation to sizes (if you keep stock sizes).
     */
    public function sizes()
    {
        return $this->hasMany(StockSize::class);
    }

    /**
     * Relation to raw materials.
     */
    public function rawMaterials()
    {
        return $this->hasMany(RawMaterial::class);
    }
}
