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
            $table->json("properties")->nullable();
            $table->unsignedBigInteger("mastery")->nullable();
            $table->string("weight", 100)->nullable();
            $table->string("cost", 100)->nullable();
            $table->string("damage_and_type", 255);
            $table->timestamps();

            $table->foreign("mastery")->references("id")->on("dnd_weapon_properties")->onDelete("cascade");
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
