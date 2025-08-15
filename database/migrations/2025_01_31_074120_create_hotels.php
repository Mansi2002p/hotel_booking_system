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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // Name of the hotel
            $table->string('address');  // Address of the hotel
            $table->text('description');  // Description of the hotel
            $table->string('city'); // Description of the hotel
            $table->string('pincode');
            $table->bigInteger('Phoneno');
            $table->bigInteger('telephoneno');
            $table->integer('star_category'); // Fixed spelling
            $table->string('email');
            $table->string('website')->nullable(); // Optional
            $table->string('nearest_railwaystation')->nullable();
            $table->string('nearest_airport')->nullable(); // Fixed typo
            $table->string('map')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');  // Status of the hotel
            $table->foreignId('property_type_id')->constrained('property_type')->onDelete('cascade');  // Property type foreign key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
