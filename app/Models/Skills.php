<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skills extends Model
{
    use HasFactory;

    protected $table = 'skills';

    protected $fillable = [
        'skills_data',
        'character_id',
    ];

    public function getSkillsData() {
        $skillsData = $this->attributes['skills_data'];
        strtr("[","{",$skillsData);
        strtr("]","}",$skillsData);
        return $skillsData;
    }
}
