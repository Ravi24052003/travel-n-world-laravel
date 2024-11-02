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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("company_name");
            $table->unsignedBigInteger('phone');
            $table->string("email")->unique();
            $table->string('location')->nullable();
            $table->text('your_requirements')->nullable();
            $table->string('your_photo')->nullable();
            $table->string("password");
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('preferred_language')->nullable();
            $table->string("role")->default("user");
            $table->boolean("isAuthorised")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
