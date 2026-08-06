<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $template = [
        [
            "name" => "",
            "level" => "",
            "school" => "",
            "casting_time" => "",
            "range" => "",
            "area" => "",
            "components" => "",
            "duration" => "",
            "concentration" => false,
            "ritual" => false,
            "classes" => "",
            "description" => "",
            "higher_levels" => "",
            "img_url" => ""

        ]
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dnd_spells', function (Blueprint $table) {
            $table->id();
            $table->string("name", 300);
            $table->string("level", 100)->nullable();
            $table->string("school", 100)->nullable();
            $table->string("casting_time", 100)->nullable();
            $table->string("range", 100)->nullable();
            $table->string("area", 100)->nullable();
            $table->string("components", 100)->nullable();
            $table->string("duration", 100)->nullable();
            $table->boolean("concentration")->default(false);
            $table->boolean("ritual")->default(false);
            $table->string("classes", 100)->nullable();
            $table->text("description")->nullable();
            $table->text("higher_levels")->nullable();
            $table->string("img_url", 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dnd_spells');
    }
};
