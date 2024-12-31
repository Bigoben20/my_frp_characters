<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $spell_slots = [
        [
            "level" => 1,
            "total" => 0,
            "expended" => 0
        ],
        [
            "level" => 2,
            "total" => 0,
            "expended" => 0
        ],
        [
            "level" => 3,
            "total" => 0,
            "expended" => 0
        ],
        [
            "level" => 4,
            "total" => 0,
            "expended" => 0
        ],
        [
            "level" => 5,
            "total" => 0,
            "expended" => 0
        ],
        [
            "level" => 6,
            "total" => 0,
            "expended" => 0
        ],
        [
            "level" => 7,
            "total" => 0,
            "expended" => 0
        ],
        [
            "level" => 8,
            "total" => 0,
            "expended" => 0
        ],
        [
            "level" => 9,
            "total" => 0,
            "expended" => 0
        ],
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dnd_characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string("name", 300);
            $table->unsignedBigInteger("class_id")->nullable();
            $table->string("background", 100)->nullable();
            $table->string("species", 100)->nullable();
            $table->string("subclass", 100)->nullable();
            $table->string("level", 10)->nullable()->default(1);
            $table->string("xp", 10)->nullable();
            $table->string("ac", 10)->nullable();
            $table->string("shield")->nullable();
            $table->string("current_hp",10)->nullable();
            $table->string("temp_hp",10)->nullable();
            $table->string("max_hp",10)->default(0)->nullable();
            $table->string("spent_hit_dice",10)->nullable();
            $table->string("max_hit_dice",10)->nullable();
            $table->tinyInteger("success_death_save")->default(0)->nullable();
            $table->tinyInteger("fail_death_save")->default(0)->nullable();
            $table->string("initiative",5)->nullable();
            $table->string("speed",5)->nullable();
            $table->string("size",10)->nullable();
            $table->string("passive_perception",3)->nullable();
            $table->longText("appearance")->nullable();
            $table->longText("backstory")->nullable();
            $table->string("alignment",24)->nullable();
            $table->string("languages",255)->nullable();
            $table->string("spellcasting_ability",50)->nullable();
            $table->json("spell_slots")->default(json_encode($this->spell_slots));
            $table->boolean("is_public")->default(0);
            $table->timestamps();

            $table->foreign('class_id')->references('id')->on('dnd_classes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dnd_characters');
    }
};