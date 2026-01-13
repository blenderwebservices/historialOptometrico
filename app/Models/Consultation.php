<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'consultation_date',
        'right_eye_sph',
        'right_eye_cyl',
        'right_eye_axis',
        'right_eye_add',
        'left_eye_sph',
        'left_eye_cyl',
        'left_eye_axis',
        'left_eye_add',
        'subtotal',
        'tax',
        'total',
        'internal_notes',
    ];

    protected $casts = [
        'consultation_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'consultation_products')
            ->withPivot('quantity', 'price_at_time')
            ->withTimestamps();
    }

    public function consultationProducts()
    {
        return $this->hasMany(ConsultationProduct::class);
    }
}
