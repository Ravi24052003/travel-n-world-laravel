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
        Schema::create('leads_phone_email', function (Blueprint $table) {
            $table->id();
            $table->foreignId('itinerary_id')->references("id")->on("itineraries")->cascadeOnUpdate()->cascadeOnDelete();
            $table->string("email");
            $table->unsignedBigInteger("phone");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads_phone_email');
    }
};
