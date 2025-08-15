<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'booking';
    protected $fillable = [
        'user_id',
        'room_id',
        'check_in_date',
        'check_in_out',
        'total_price',
        'guests',
        'status',
        'payment',
        'service_charge',
        'taxes',
        'sub_total',
        'discount',
        'hotel_charges',
        'rooms'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

}
