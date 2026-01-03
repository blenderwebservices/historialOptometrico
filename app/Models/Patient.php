<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'phone',
        'email',
        'birth_date',
        'address',
        'notes',
    ];

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }
}
