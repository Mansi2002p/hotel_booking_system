<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenities extends Model
{
    use HasFactory;
    protected $table = 'amenities'; // Explicitly define the table name
    protected $fillable = ['name'];

    
    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'hotel_amenity');
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_amenity');
    }
    
}
