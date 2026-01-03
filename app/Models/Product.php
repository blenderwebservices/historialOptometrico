<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'brand',
        'price',
        'stock',
    ];

    public function consultations()
    {
        return $this->belongsToMany(Consultation::class, 'consultation_products')
                    ->withPivot('quantity', 'price_at_time')
                    ->withTimestamps();
    }
}
