<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DndEquipment extends Model
{
    use HasFactory;

    protected $table = 'dnd_equipments';

    protected $fillable = [
        'name',
        'type',
        'notes'
    ];

    public function characters()
    {
        return $this->belongsToMany(DndCharacter::class, 'dnd_character_equipment', 'equipment_id', 'character_id');
    }
}
