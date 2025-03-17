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
        Schema::create('hero_section_videos', function (Blueprint $table) {
            $table->id();
            $table->string('video_url'); // URL of the video
            $table->string('use_in'); // Where the video is used (e.g., home, about, blog, contact)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_section_videos');
    }
};
