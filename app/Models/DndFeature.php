<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DndFeature extends Model
{
    use HasFactory;

    protected $table = 'dnd_features';

    protected $fillable = [
        'character_id',
        'class_features',
        'species_traits',
        'feats'
    ];

    public function character()
    {
        return $this->belongsTo(DndCharacter::class, 'character_id', 'id');
    }

    public function setClassFeaturesAttribute($value)
    {
        $this->attributes['class_features'] = json_encode($value);
    }

    public function getClassFeaturesAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setSpeciesTraitsAttribute($value)
    {
        $this->attributes['species_traits'] = json_encode($value);
    }

    public function getSpeciesTraitsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setFeatsAttribute($value)
    {
        $this->attributes['feats'] = json_encode($value);
    }

    public function getFeatsAttribute($value)
    {
        return json_decode($value, true);
    }

    // Add methods
    public function addClassFeature($name, $description)
    {
        $classFeatures = $this->class_features;
        $classFeatures[] = [
            "name" => $name,
            "description" => $description
        ];
        $this->class_features = $classFeatures;
        $this->save();
    }

    public function addSpeciesTrait($name, $description)
    {
        $speciesTraits = $this->species_traits;
        $speciesTraits[] = [
            "name" => $name,
            "description" => $description
        ];
        $this->species_traits = $speciesTraits;
        $this->save();
    }

    public function addFeat($name, $description)
    {
        $feats = $this->feats;
        $feats[] = [
            "name" => $name,
            "description" => $description
        ];
        $this->feats = $feats;
        $this->save();
    }

    // remove methods
    public function removeClassFeature($index)
    {
        $classFeatures = $this->class_features;
        unset($classFeatures[$index]);
        $this->class_features = array_values($classFeatures);
        $this->save();
    }

    public function removeSpeciesTrait($index)
    {
        $speciesTraits = $this->species_traits;
        unset($speciesTraits[$index]);
        $this->species_traits = array_values($speciesTraits);
        $this->save();
    }

    public function removeFeat($index)
    {
        $feats = $this->feats;
        unset($feats[$index]);
        $this->feats = array_values($feats);
        $this->save();
    }

    // update methods
    public function updateClassFeature($index, $name, $description)
    {
        $classFeatures = $this->class_features;
        $classFeatures[$index] = [
            "name" => $name,
            "description" => $description
        ];
        $this->class_features = $classFeatures;
        $this->save();
    }

    public function updateSpeciesTrait($index, $name, $description)
    {
        $speciesTraits = $this->species_traits;
        $speciesTraits[$index] = [
            "name" => $name,
            "description" => $description
        ];
        $this->species_traits = $speciesTraits;
        $this->save();
    }

    public function updateFeat($index, $name, $description)
    {
        $feats = $this->feats;
        $feats[$index] = [
            "name" => $name,
            "description" => $description
        ];
        $this->feats = $feats;
        $this->save();
    }
}
