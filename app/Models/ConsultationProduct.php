<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultation_id',
        'product_id',
        'quantity',
        'price_at_time',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
