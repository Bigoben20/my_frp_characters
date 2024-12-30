<?php

namespace App\Http\Controllers;

use App\Models\DndAbility;
use App\Models\DndCharacter;
use App\Models\DndClasses;
use App\Models\DndFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DndCharacterController extends Controller
{


    public function dndCharacterDetail($id)
    {
        $character = DndCharacter::with('weapons', 'spells', 'equipments', 'features','abilities')->find($id);
        if (!$character) {
            return redirect()->back()->with('error', 'Karakter bulunamadı');
        } else if ($character->user_id != Auth::user()->id) {
            return redirect()->back()->with('error', 'Buna yetkiniz bulunmamaktadır!');
        }
        $classes = DndClasses::orderBy('name','asc')->get();

        return Inertia::render('DNDCharacterDetails', compact("character","classes"));
    }

    public function dndCharacterStore(Request $request)
    {
        $character = new DndCharacter();
        $character->name = $request->name;
        $character->user_id = Auth::id();

        try {
            $character->save();
            $features = new DndFeature();
            $features->character_id = $character->id;
            $features->save();

            $abilities = new DndAbility();
            $abilities->character_id = $character->id;
            $abilities->save();

            $character->spells()->sync([]); // Boş spell kaydı
            $character->weapons()->sync([]); // Boş weapon kaydı
            $character->equipments()->sync([]); // Boş equipment kaydı (eğer varsa)
            return redirect()->back()->with('success', 'Karakter başarıyla oluşturuldu');;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Karakter oluşturulamadı; ' . $e->getMessage());;
        }
    }

    public function dndCharacterUpdate(Request $request)
    {
        $characterData = $request->characterData;
        $character = DndCharacter::find($characterData["id"]);
        if (!$character) {
            return redirect()->back()->with('error', 'Karakter bulunamadı!');
        } else if ($character->user_id != Auth::user()->id) {
            return redirect()->back()->with('error', 'Buna yetkiniz bulunmamaktadır!');
        }

        $character->name = $characterData["name"];
        $character->class = $characterData["class"];
        $character->background = $characterData["background"];
        $character->species = $characterData["species"];
        $character->subclass = $characterData["subclass"];
        $character->level = $characterData["level"];
        $character->xp = $characterData["xp"];
        $character->ac = $characterData["ac"];
        $character->shield = $characterData["shield"];
        $character->current_hp = $characterData["current_hp"];
        $character->temp_hp = $characterData["temp_hp"];
        $character->max_hp = $characterData["max_hp"];
        $character->spent_hit_dice = $characterData["spent_hit_dice"];
        $character->max_hit_dice = $characterData["max_hit_dice"];
        $character->success_death_save = $characterData["success_death_save"];
        $character->fail_death_save = $characterData["fail_death_save"];
        $character->initiative = $characterData["initiative"];
        $character->speed = $characterData["speed"];
        $character->size = $characterData["size"];
        $character->passive_perception = $characterData["passive_perception"];
        $character->appearance = $characterData["appearance"];
        $character->backstory = $characterData["backstory"];
        $character->alignment = $characterData["alignment"];
        $character->languages = $characterData["languages"];
        $character->spellcasting_ability = $characterData["spellcasting_ability"];
        $character->spell_slots = $characterData["spell_slots"];
        $character->is_public = $characterData["is_public"];
        
        try {
            DndAbility::updateOrCreate(
                ['character_id' => $character->id],
                [
                    'abilities' => $request->abilities,
                    'proficiencies' => $request->proficiencies,
                    'heroic_inspiration' => $characterData["abilities"]["heroic_inspiration"],
                    'proficiency_bonus' => $characterData["abilities"]["proficiency_bonus"],
                ]
            );
    
            DndFeature::updateOrCreate(
                ['character_id' => $character->id],
                [
                    'class_features' => $characterData["features"]["class_features"],
                    'species_traits' => $characterData["features"]["species_traits"],
                    'feats' => $characterData["features"]["feats"],
                ]
            );

            $character->save();
            return redirect()->back()->with('success', 'Karakter başarıyla güncellendi');;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Karakter güncellenemedi; ' . $e->getMessage());;
        }
    }

    public function dndCharacterDelete(Request $request)
    {
        $character = DndCharacter::where([["user_id", Auth::id()], ["id", $request->id]])->first();
        if (!$character) {
            return redirect()->back()->with('warning', 'Karakter bulunamadı');
        }
        try {
            $character->delete();
            return redirect()->to("/dashboard")->with('success', 'Karakter başarıyla silindi');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Karakter silinemedi; ' . $e->getMessage());
        }
    }

    // DND DndCharacter Spell Update
    public function dndCharacterSpellAdd(Request $request)
    {
        $character = DndCharacter::find($request->character_id);
        if (!$character) {
            return redirect()->back()->with('error', 'Karakter bulunamadı!');
        } else if ($character->user_id != Auth::user()->id) {
            return redirect()->back()->with('error', 'Buna yetkiniz bulunmamaktadır!');
        }

        $character->spells()->attach($request->spell_id);

        return redirect()->back()->with('success', 'Büyü başarıyla eklendi');
    }

    public function dndCharacterSpellDelete(Request $request)
    {
        $character = DndCharacter::find($request->character_id);
        if (!$character) {
            return redirect()->back()->with('error', 'Karakter bulunamadı!');
        } else if ($character->user_id != Auth::user()->id) {
            return redirect()->back()->with('error', 'Buna yetkiniz bulunmamaktadır!');
        }

        $character->spells()->detach($request->spell_id);

        return redirect()->back()->with('success', 'Büyü başarıyla silindi');
    }

    // DND DndCharacter Weapon Update
    public function dndCharacterWeaponAdd(Request $request)
    {
        $character = DndCharacter::find($request->character_id);
        if (!$character) {
            return redirect()->back()->with('error', 'Karakter bulunamadı!');
        } else if ($character->user_id != Auth::user()->id) {
            return redirect()->back()->with('error', 'Buna yetkiniz bulunmamaktadır!');
        }

        $character->weapons()->attach($request->weapon_id);

        return redirect()->back()->with('success', 'Silah başarıyla eklendi');
    }

    public function dndCharacterWeaponDelete(Request $request)
    {
        $character = DndCharacter::find($request->character_id);
        if (!$character) {
            return redirect()->back()->with('error', 'Karakter bulunamadı!');
        } else if ($character->user_id != Auth::user()->id) {
            return redirect()->back()->with('error', 'Buna yetkiniz bulunmamaktadır!');
        }

        $character->weapons()->detach($request->weapon_id);

        return redirect()->back()->with('success', 'Silah başarıyla silindi');
    }

    // DND DndCharacter Equipment Update
    public function dndCharacterEquipmentAdd(Request $request)
    {
        $character = DndCharacter::find($request->character_id);
        if (!$character) {
            return redirect()->back()->with('error', 'Karakter bulunamadı!');
        } else if ($character->user_id != Auth::user()->id) {
            return redirect()->back()->with('error', 'Buna yetkiniz bulunmamaktadır!');
        }

        $character->equipments()->attach($request->equipment_id);

        return redirect()->back()->with('success', 'Ekipman başarıyla eklendi');
    }

    public function dndCharacterEquipmentDelete(Request $request)
    {
        $character = DndCharacter::find($request->character_id);
        if (!$character) {
            return redirect()->back()->with('error', 'Karakter bulunamadı!');
        } else if ($character->user_id != Auth::user()->id) {
            return redirect()->back()->with('error', 'Buna yetkiniz bulunmamaktadır!');
        }

        $character->equipments()->detach($request->equipment_id);

        return redirect()->back()->with('success', 'Ekipman başarıyla silindi');
    }

    // DND DndCharacter Feature Update
    public function dndCharacterFeatureUpdate(Request $request)
    {
        $character = DndCharacter::find($request->character_id);
        if (!$character) {
            return redirect()->back()->with('error', 'Karakter bulunamadı!');
        } else if ($character->user_id != Auth::user()->id) {
            return redirect()->back()->with('error', 'Buna yetkiniz bulunmamaktadır!');
        }

        $character->features->class_features = $request->class_features;
        $character->features->species_traits = $request->species_traits;
        $character->features->feats = $request->feats;

        try {
            $character->features->save();
            return redirect()->back()->with('success', 'Özellikler başarıyla güncellendi');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Özellikler güncellenemedi; ' . $e->getMessage());
        }
    }
}
