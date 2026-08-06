<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DndSpell extends Model
{
    use HasFactory;

    protected $table = 'dnd_spells';

    protected $fillable = [
        'name',
        'level',
        'school',
        'casting_time',
        'range',
        'area',
        'components',
        'duration',
        'concentration',
        'ritual',
        'classes',
        'description',
        'higher_levels',
        'img_url'
    ];

    public function characters()
    {
        return $this->belongsToMany(DndCharacter::class, 'dnd_character_spell', 'spell_id', 'character_id');
    }
}
