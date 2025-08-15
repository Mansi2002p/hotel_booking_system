<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'email'      => $this->email,
            'moblieno'   => $this->moblieno,
            'address'    => $this->address,
            'zipcode'    => $this->zipcode,
            'city'       => $this->city,
            'state'      => $this->state,
            'country'    => $this->country,
            'role'       => $this->role,
            'created_at' => $this->created_at,
        ];
    }

}
