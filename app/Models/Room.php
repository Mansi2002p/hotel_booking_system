<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Room extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'room_no', 'roomtype_id', 'hotels_id', 'price', 'air_conditon', 'bed_capacity', 'decsription'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('room_images'); // Allows multiple uploads
    }
    
    
    
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotels_id');
    }
    
    // Relationship with RoomType
    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'roomtype_id');
    }
    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('room_images');
    }


    public function amenities()
    {
        return $this->belongsToMany(Amenities::class, 'room_amenity', 'room_id', 'amenity_id');
    }
    
    
 
}
