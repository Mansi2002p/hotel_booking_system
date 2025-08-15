<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
// If using media library for images
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Hotel extends Model implements HasMedia
{
    use  InteractsWithMedia;

    protected $fillable = [
     
        'name',
        'address',
        'description',
        'status',
        'city',
        'pincode',
        'Phoneno',
        'telephoneno',
        'star_category',
        'email',
        'website',
        'nearest_railwaystation',
        'nearest_airport',
        'map',
        'property_type_id',
        'user_id',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')->useDisk('public');  // Use 'public' disk or your preferred disk
    }
    /**
     * Get the property type associated with the hotel.
     */
    public function property_type()
    {
        return $this->belongsTo(PropertyType::class);
    }


    /**
     * Get the user who owns the hotel.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the amenities associated with the hotel.
     */
    public function amenities()
    {
        return $this->belongsToMany(Amenities::class, 'hotel_amenity', 'hotel_id', 'amenity_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'hotels_id');
    }
    
    /**
     * Get the media images for the hotel.
     */
    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('images');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }



  
}
