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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string("name", 300);
            $table->string("high_concept", 300);
            $table->string("trouble", 300)->nullable()->default(null);
            $table->string("relationship",300)->nullable()->default(null);
            $table->string("aspect",300)->nullable()->default(null);
            $table->string("aspect2",300)->nullable()->default(null);
            $table->longText("stunts")->nullable()->default(null);
            $table->tinyInteger("refresh")->default(0);
            $table->tinyInteger("fate_point")->default(0);
            $table->tinyInteger("physical_stress")->default(0);
            $table->tinyInteger("mental_stress")->default(0);
            $table->string("mid")->nullable()->default(null);
            $table->string("moderate")->nullable()->default(null);
            $table->string("severe")->nullable()->default(null);
            $table->string("extreme")->nullable()->default(null);
            $table->string("mid2")->nullable()->default(null);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
