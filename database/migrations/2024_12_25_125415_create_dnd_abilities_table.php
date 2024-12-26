<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    private $abilities = [
        [
            "ability_name" => "Strength",
            "ability_score" => null,
            "ability_modifier" => null,
            "saving_throw" => null,
            "sub_abilities" => [
                [
                    "name" => "Athletics",
                    "score" => null,
                    "modifier" => null,
                    "saving_throw_check" => false
                ]
            ]
        ],
        [
            "ability_name" => "Dexterity",
            "ability_score" => null,
            "ability_modifier" => null,
            "saving_throw" => null,
            "sub_abilities" => [
                [
                    "name" => "Acrobatics",
                    "score" => null,
                    "modifier" => null,
                    "saving_throw_check" => false
                ],
                [
                    "name" => "Sleight of Hand",
                    "score" => null,
                    "modifier" => null,
                    "saving_throw_check" => false
                ],
                [
                    "name" => "Stealth",
                    "score" => null,
                    "modifier" => null,
                    "saving_throw_check" => false
                ]
            ]
        ],
        [
            "ability_name" => "Constitution",
            "ability_score" => null,
            "ability_modifier" => null,
            "saving_throw" => null,
            "sub_abilities" => [
            ]
        ],
        [
            "ability_name" => "Intelligence",
            "ability_score" => null,
            "ability_modifier" => null,
            "saving_throw" => null,
            "sub_abilities" => [
                [
                    "name" => "Arcana",
                    "score" => null,
                    "modifier" => null,
                    "saving_throw_check" => false
                ],
                [
                    "name" => "History",
                    "score" => null,
                    "modifier" => null,
                    "saving_throw_check" => false
                ],
                [
                    "name" => "Investigation",
                    "score" => null,
                    "modifier" => null,
                    "saving_throw_check" => false
                ],
                [
                    "name" => "Nature",
                    "score" => null,
                    "modifier" => null,
                    "saving_throw_check" => false
                ],
                [
                    "name" => "Religion",
                    "score" => null,
                    "modifier" => null,
                    "saving_throw_check" => false
                ]
            ]
        ],
        [
            "ability_name" => "Wisdom",
            "ability_score" => null,
            "ability_modifier" => null,
            "saving_throw" => null,
            "sub_abilities" => [
                [
                    "name" => "Animal Handling",
                    "score" => null,
                    "modifier" => null,
                    "saving_throw_check" => false
                ],
                [
                    "name" => "Insight",
                    "score" => null,
                    "modifier" => null,
                    "saving_throw_check" => false
                ],
                [
                    "name" => "Medicine",
                    "score" => null,
                    "modifier" => null,
                    "saving_throw_check" => false
                ],
                [
                    "name" => "Perception",
                    "score" => null,
                    "modifier" => null,
                    "saving_throw_check" => false
                ],
                [
                    "name" => "Survival",
                    "score" => null,
                    "modifier" => null,
                    "saving_throw_check" => false
                ]
            ]
        ],
        [
            "ability_name" => "Charisma",
            "ability_score" => null,
            "ability_modifier" => null,
            "saving_throw" => null,
            "sub_abilities" => [
                [
                    "name" => "Deception",
                    "score" => null,
                    "modifier" => null,
                    "saving_throw_check" => false
                ],
                [
                    "name" => "Intimidation",
                    "score" => null,
                    "modifier" => null,
                    "saving_throw_check" => false
                ],
                [
                    "name" => "Performance",
                    "score" => null,
                    "modifier" => null,
                    "saving_throw_check" => false
                ],
                [
                    "name" => "Persuasion",
                    "score" => null,
                    "modifier" => null,
                    "saving_throw_check" => false
                ]
            ]
        ]
    ];

    private $proficiencies = [
        [
            "name" => "Armor",
            "proficiencies" => []
        ],
        [
            "name" => "Weapons",
            "proficiencies" => []
        ],
        [
            "name" => "Tools",
            "proficiencies" => []
        ],
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('dnd_abilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('character_id');
            $table->json('abilities')->default(json_encode($this->abilities));
            $table->json('proficiencies')->default(json_encode($this->proficiencies));
            $table->boolean('heroic_inspiration')->default(false);
            $table->string('proficiency_bonus')->default("+2");
            $table->timestamps();

            $table->foreign('character_id')->references('id')->on('dnd_characters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dnd_abilities');
    }
};
