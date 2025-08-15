<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HotelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
 
        // public function toArray($request)
        // {
        //     return [
        //         'id' => $this->id,
        //         'name' => $this->name,
        //         'address' => $this->address,
        //         'description' => $this->description,
        //         'city' => $this->city,
        //         'pincode' => $this->pincode,
        //         'Phoneno' => $this->Phoneno,
        //         'telephoneno' => $this->telephoneno,
        //         'star_category' => $this->star_category,
        //         'email' => $this->email,
        //         'website' => $this->website,
        //         'nearest_railwaystation' => $this->nearest_railwaystation,
        //         'nearest_airport' => $this->nearest_airport,
        //         'latitude' => $this->latitude,
        //         'longitude' => $this->longitude,
        //         'property_type_id' => $this->property_type_id,
        //         'status' => $this->status,
        //         'images' => $this->getMedia('images')->map(function ($media) {
        //                 return [
        //                     'id' => $media->id,
        //                     'url' => $media->getFullUrl(),   // Full image URL
        //                     'name' => $media->name,          // Original filename
        //                     'mime_type' => $media->mime_type // Optional: file type
        //                 ];
        //         }),

        //         'amenities' => AmenityResource::collection($this->whenLoaded('amenities')),
        //         'created_at' => $this->created_at,
        //         'updated_at' => $this->updated_at,
        //     ];
        // }

        public function toArray($request)
        {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'address' => $this->address,
                'description' => $this->description,
                'city' => $this->city,
                'pincode' => $this->pincode,
                'Phoneno' => $this->Phoneno,
                'telephoneno' => $this->telephoneno,
                'star_category' => $this->star_category,
                'email' => $this->email,
                'website' => $this->website,
                'nearest_railwaystation' => $this->nearest_railwaystation,
                'nearest_airport' => $this->nearest_airport,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'property_type_id' => $this->property_type_id,
                'status' => $this->status,
    
                // ✅ Include hotel images
                // 'images' => getAllMediaImages($this, 'images'),
    
                // // ✅ Include amenities if loaded
                // 'amenities' => AmenityResource::collection($this->whenLoaded('amenities')),

                'images' => getAllMediaImages($this, 'images'),
                'amenities' => AmenityResource::collection($this->whenLoaded('amenities')),
    
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ];
        }

}

