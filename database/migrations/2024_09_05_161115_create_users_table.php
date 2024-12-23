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
        Schema::create('users', function (Blueprint $table){
            $table->id();
            $table->string("name");
            $table->string("company_name");
            $table->unsignedBigInteger('phone');
            $table->string("email")->unique();

            $table->unsignedBigInteger('whatsapp')->nullable();
            $table->string("facebook")->nullable();
            $table->string("instagram")->nullable();
            $table->string("youtube")->nullable();
            
            $table->string('location')->nullable();
            $table->text('your_requirements')->nullable();
            $table->string('your_photo')->nullable();
            $table->string("password");
            $table->string('gender')->nullable();
            $table->string('preferred_language')->nullable();
            $table->string("role")->default("user");
            $table->boolean("is_authorised")->default(false);
            $table->boolean("is_publicly_present")->default(false);
            $table->boolean("is_verified")->default(false);

            $table->timestamp('verification_date')->nullable();
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
