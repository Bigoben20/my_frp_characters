<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DndCharacter extends Model
{
    use HasFactory;

    protected $table = 'dnd_characters';

    protected $fillable = [
        'name',
        'class',
        'background',
        'species',
        'subclass',
        'level',
        'ac',
        'shield',
        'current_hp',
        'temp_hp',
        'max_hp',
        'spent_hit_dice',
        'max_hit_dice',
        'success_death_save',
        'fail_death_save',
        'initiative',
        'speed',
        'size',
        'passive_perception',
        'appearance',
        'backstory',
        'alignment',
        'languages',
    ];

    public function weapons()
    {
        return $this->belongsToMany(DndWeapon::class, 'dnd_character_weapon', 'character_id', 'weapon_id');
    }

    public function spells()
    {
        return $this->belongsToMany(DndSpell::class, 'dnd_character_spell', 'character_id', 'spell_id');
    }

    public function equipments()
    {
        return $this->belongsToMany(DndEquipment::class, 'dnd_character_equipment', 'character_id', 'equipment_id');
    }

    public function features()
    {
        return $this->hasOne(DndFeature::class, 'character_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function abilities()
    {
        return $this->hasOne(DndAbility::class, 'character_id', 'id');
    }
}
