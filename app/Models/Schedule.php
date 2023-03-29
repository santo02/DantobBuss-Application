<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_id',
        'route_id',
        'tanggal',
        'harga' 
    ];

    public function bookings()
    {
        return $this->hasMany(Bookings::class);
    }
    
}
