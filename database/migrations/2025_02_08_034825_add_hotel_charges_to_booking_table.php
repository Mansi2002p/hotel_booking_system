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
        Schema::table('booking', function (Blueprint $table) {
            //
            // Additional fields
            $table->decimal('service_charge', 10, 2)->default(0.00);
            $table->decimal('taxes', 10, 2)->default(0.00);
            $table->decimal('sub_total', 10, 2)->default(0.00);
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->decimal('hotel_charges', 10, 2)->default(0.00);
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            //
            $table->dropColumn(['service_charge', 'taxes', 'sub_total', 'discount', 'hotel_charges']);
      
        });
    }
};
