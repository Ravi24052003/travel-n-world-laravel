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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->references("id")->on("users")->cascadeOnUpdate()->cascadeOnDelete();
            $table->string("company_logo")->nullable();
            $table->string('company_name');
            $table->string('company_address');
            $table->string('company_city');
            $table->string('pin_code');
            $table->string('company_status')->nullable();
            $table->json('services_offered')->nullable();
            $table->string('number_of_staff')->nullable();
            $table->text('about_company')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
