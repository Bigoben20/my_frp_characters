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
        Schema::create('dnd_weapon_properties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->boolean('mastery')->default(false); // Mastery-specific property
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dnd_weapon_properties');
    }
};
