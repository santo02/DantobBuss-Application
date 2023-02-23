<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'police_number',
        'number_of_seats',
        'merk',
        'status',
        'supir_id'
    ];

}
