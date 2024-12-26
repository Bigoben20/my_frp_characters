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
        Schema::create('dnd_character_equipment', function (Blueprint $table) {
            $table->id(); // Eğer birincil anahtar gerekmezse bunu kaldırabilirsiniz.
            $table->unsignedBigInteger('character_id');
            $table->unsignedBigInteger('equipment_id');
            $table->timestamps(); // İsteğe bağlı olarak created_at ve updated_at alanlarını ekler.

            // Foreign key tanımları
            $table->foreign('character_id')->references('id')->on('dnd_characters')->onDelete('cascade');
            $table->foreign('equipment_id')->references('id')->on('dnd_equipments')->onDelete('cascade');

            // Aynı ilişki birden fazla kez eklenmesin diye unique constraint
            $table->unique(['character_id', 'equipment_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dnd_character_equipment');
    }
};
