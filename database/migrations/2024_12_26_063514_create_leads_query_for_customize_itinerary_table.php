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
        Schema::create('leads_query_for_customize_itinerary', function (Blueprint $table) {
            $table->id();
            $table->foreignId('itinerary_id')->references("id")->on("itineraries")->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone_number');
            $table->string('selected_destination');
            $table->date('date_of_arrival');
            $table->json('places_to_cover')->nullable();
            $table->string('no_of_person')->nullable();
            $table->string('no_of_adult')->nullable();
            $table->string('no_of_child')->nullable();
            $table->string('child_age')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads_query_for_customize_itinerary');
    }
};
