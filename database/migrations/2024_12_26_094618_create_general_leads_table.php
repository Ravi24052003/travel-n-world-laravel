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
        Schema::create('general_leads', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("email");
            $table->unsignedBigInteger("phone");
            $table->string("selected_destination");
            $table->timestamp('date_of_arrival')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_leads');
    }
};
