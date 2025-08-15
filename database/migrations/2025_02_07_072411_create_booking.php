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
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->date('check_in_date');
            $table->date('check_in_out');
            $table->integer('total_price');
            $table->integer('guests');
            $table->enum('status', ['confirm', 'cancel'])->default('confirm');  
            $table->enum('payment', ['paid', 'due'])->default('paid');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
