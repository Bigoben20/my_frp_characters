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
        
        Schema::create('skills', function (Blueprint $table) {
            $skills = [
              "Athletics",
              "Burglary",
              "Contacts",
              "Crafts",
              "Deceive",
              "Drive",
              "Empathy",
              "Fight",
              "Investigate",
              "Lore",
              "Notice",
              "Physique",
              "Provoke",
              "Rapport",
              "Resources",
              "Shoot",
              "Stealth",
              "Will",
              "Wisdom"
            ];
            $skills_data = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
            $table->id();
            $table->unsignedBigInteger('character_id');
            $table->string("skills")->nullable()->default(json_encode($skills));
            $table->string("skills_data")->nullable()->default(json_encode($skills_data));
            $table->timestamps();
            
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
