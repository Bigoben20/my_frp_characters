<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DndAbility extends Model
{
    use HasFactory;

    protected $table = 'dnd_abilities';

    protected $fillable = [
        'character_id',
        'abilities',
        'proficiencies',
        'heroic_inspiration',
        'proficiency_bonus',
    ];
       

    public function characters()
    {
        return $this->belongsTo(DndCharacter::class, 'character_id', 'id');
    }
}
