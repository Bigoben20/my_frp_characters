<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DndWeapon extends Model
{
    use HasFactory;

    protected $table = 'dnd_weapons';

    protected $fillable = [
        'name',
        'notes',
        'atk_bonus',
        'dc',
        'damage_and_type',
    ];

    public function characters()
    {
        return $this->belongsToMany(DndCharacter::class, 'dnd_character_weapon', 'weapon_id', 'character_id');
    }
}
