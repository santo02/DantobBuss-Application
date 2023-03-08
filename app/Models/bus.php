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

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function route()
    {
        return $this->belongsTo(Routes::class);
    }

    public function bookings()
    {
        return $this->hasMany(Bookings::class);
    }

    public function trackings()
    {
        return $this->hasMany(Trackings::class);
    }

}
