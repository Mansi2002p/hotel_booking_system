<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->integer('room_no');
            $table->foreignId('roomtype_id')->constrained('room_type')->onDelete('cascade'); 
            $table->foreignId('hotels_id')->constrained('hotels')->onDelete('cascade'); 
            $table->integer('price');
            $table->enum('air_conditon', ['Ac', 'Non Ac'])->default('Non Ac');  
            $table->integer('bed_capacity');
            $table->enum('status', ['available', 'notavailable'])->default('available');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
