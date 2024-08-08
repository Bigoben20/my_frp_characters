<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;
    
    protected $table = 'characters';

    protected $fillable = [
        'name',
        'high_concept',
        'trouble',
        'aspect',
        'aspect2',
        'stunts',
        'physical_stress',
        'mental_stress',
        'user_id',
        'img_url',
    ];

    public function skills()
    {
        return $this->hasOne(Skills::class, 'character_id', 'id');
    }
    public function notes()
    {
        return $this->hasOne(Note::class, 'character_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
