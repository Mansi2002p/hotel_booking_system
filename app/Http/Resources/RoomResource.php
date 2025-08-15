<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'room_no' => $this->room_no,
            'price' => $this->price,
            'air_conditon' => $this->air_conditon,
            'bed_capacity' => $this->bed_capacity,
            'decsription' => $this->decsription,
            'hotel' => [
                'id' => $this->hotel->id,
                'name' => $this->hotel->name,
                'address' => $this->hotel->address,
            ],
            'room_type' => $this->roomType->name ?? null,
            // 'amenities' => $this->amenities->pluck('name'),
            'amenities' => AmenityResource::collection($this->whenLoaded('amenities')),
            // 'images' => $this->getMedia('room_images')->map(function ($media) {
            //     return $media->getFullUrl();
            // }),
            'images' => $this->getMedia('room_images')->map(function ($media) {
                                return [
                                    'id' => $media->id,
                                    'url' => $media->getFullUrl(),   // Full image URL
                                    'name' => $media->name,          // Original filename
                                    'mime_type' => $media->mime_type // Optional: file type
                                ];
         }),
        ];
    }
}
