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
        Schema::create('dnd_weapons', function (Blueprint $table) {
            $table->id();
            $table->string("name", 100);
            $table->string("notes", 255)->nullable();
            $table->string("atk_bonus", 4);
            $table->string("dc", 4);
            $table->string("damage_and_type", 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dnd_weapons');
    }
};
