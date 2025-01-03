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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references("id")->on("users")->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('blog_title')->unique();
            $table->string('blog_slug')->unique();
            $table->string('blog_image');
            $table->string('blog_keywords');
            $table->text('blog_description');
            $table->string('blog_author_name')->nullable();
            $table->json('blog_category');
            $table->string('blog_meta_title');
            $table->string('blog_visibility')->default('public');
            $table->longText('blog_content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
