<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('itineraries', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_id')->references("id")->on("users")->cascadeOnUpdate()->cascadeOnDelete(); // Foreign key with cascading delete
            $table->json('days_information'); // JSON column for days details
            $table->longText('destination_detail'); // Long text for destination detail
            $table->string('inclusion'); // String column for inclusion
            $table->string('exclusion'); // String column for exclusion
            $table->json('hotel_details'); // JSON column for hotel details
            $table->string('title'); // Title
            $table->string('meta_title')->nullable(); // Nullable meta title
            $table->string('keyword')->nullable(); // Nullable keyword
            $table->longText('meta_description')->nullable(); // Nullable meta description
            $table->string('itinerary_visibility'); // Itinerary visibility
            $table->string('itinerary_type'); // Itinerary type
            $table->json('duration'); // JSON column for duration
            $table->json('selected_destination'); // JSON column for selected destination
            $table->json('itinerary_theme'); // JSON column for itinerary theme
            $table->string('destination_thumbnail'); // String column for destination thumbnail
            $table->json('destination_images'); // JSON column for destination images
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itineraries');
    }
};
