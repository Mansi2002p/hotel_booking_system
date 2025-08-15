<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    use HasFactory;
   
    protected $table = 'property_type'; // Explicitly define the table name
    protected $fillable = ['name'];

    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }
}
