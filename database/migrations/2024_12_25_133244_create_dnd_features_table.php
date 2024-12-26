<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    private $template = [
        [
            "name" => "",
            "description" => ""
        ]
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dnd_features', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('character_id');
            $table->json('class_features')->nullable()->default(json_encode($this->template));
            $table->json('species_traits')->nullable()->default(json_encode($this->template));
            $table->json('feats')->nullable()->default(json_encode($this->template));
            $table->timestamps();

            $table->foreign('character_id')->references('id')->on('dnd_characters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dnd_features');
    }
};
