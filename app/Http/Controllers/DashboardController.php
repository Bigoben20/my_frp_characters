<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\DndCharacter;
use App\Models\DndClasses;
use App\Models\Skills;
use App\Models\Note;
use App\Models\SkillLabel;
use App\Services\ChatGPTService;
use Collator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $characters = Character::where("user_id", Auth::user()->id)->orderBy("id", "DESC")->paginate("15", ["*"], "characters");
        $allCharacters = Character::with('user')->where("user_id", "<>", Auth::user()->id)->orderBy("id", "Desc")->paginate(15);
        $dndClasses = DndClasses::orderBy('name', 'asc')->get();
        $dndCharacters = DndCharacter::where("user_id", Auth::user()->id)->orderBy("id", "DESC")->paginate("15", ["*"], "dndCharacters");

        return Inertia::render('Dashboard', compact("characters", "allCharacters", "dndCharacters","dndClasses"));
    }

    public function gptChat()
    {
        return Inertia::render('GPTChat');
    }
    public function sendGptChat(Request $request, ChatGPTService $chatGPTService)
    {
        $response = $chatGPTService->getChatResponse($request);
        return response()->json($response);
    }

    public function storeCharacter(Request $request)
    {
        $validateData = $request->validate([
            'name' => ['required', 'max:50'],
            'high_concept' => ['required', 'max:255'],
        ], [
            'name.required' => 'Lütfen isim giriniz',
            'name.max' => 'İsim en fazla 50 karakter olabilir',
            'high_concept.required' => 'Lütfen high concept giriniz',
            'high_concept.max' => 'High concept alanı en fazla 255 karakter olabilir'
        ]);
        $validateData["user_id"] = Auth::id();

        try {
            $character = Character::create($validateData);
            $skills = new Skills();
            $skills->character_id = $character->id;
            $skills->save();

            $notes = new Note();
            $notes->character_id = $character->id;
            $notes->save();

            return redirect()->back()->with('success', 'Karakter başarıyla oluşturuldu');;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Karakter oluşturulamadı; ' . $e->getMessage());;
        }
    }

    public function deleteCharacter(Request $request)
    {
        $validateData = $request->validate([
            'id' => ['required']
        ]);

        $character = Character::where([["user_id", Auth::id()], ["id", $validateData["id"]]])->first();
        if (!$character) {
            return redirect()->back()->with('warning', 'Karakter bulunamadı');
        }
        try {
            $character->delete();
            return redirect()->back()->with('success', 'Karakter başarıyla silindi');;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Karakter silinemedi; ' . $e->getMessage());;
        }
    }

    public function detailsCharacter($id)
    {
        $character = Character::join('notes', 'characters.id', '=', 'notes.character_id')->where("characters.id", $id)->first();
        $skills = Skills::where("character_id", $id)->first();
        $skillLabels = SkillLabel::pluck('title');

        return Inertia::render('CharacterDetails', compact("character", "skills", "skillLabels"));
    }

    public function updateCharacter(Request $request)
    {
        if (!Auth::user()) {
            return redirect()->back()->with('warning', 'Üye girişi yapılmamış!');
        }

        $character = (object) $request->characterData;
        $skills = (object) $request->skills;
        $characterDB = Character::find($character->id);
        if (!$characterDB) {
            return redirect()->back()->with('error', 'Karakter bulunamadı!');
        } else if ($characterDB->user_id != Auth::user()->id) {
            return redirect()->back()->with('error', 'Buna yetkiniz bulunmamaktadır!');
        }
        $skillsDB = Skills::where("character_id", $character->id)->first();



        try {
            $characterDB->name = $character->name;
            $characterDB->high_concept = $character->high_concept;
            $characterDB->trouble = $character->trouble;
            $characterDB->relationship = $character->relationship;
            $characterDB->aspect = $character->aspect;
            $characterDB->aspect2 = $character->aspect2;
            $characterDB->stunts = $character->stunts;
            $characterDB->physical_stress = $character->physical_stress;
            $characterDB->mental_stress = $character->mental_stress;
            $characterDB->fate_point = $character->fate_point;
            $characterDB->refresh = $character->refresh;
            $characterDB->save();

            $skillsDB->skills_data = $skills->skills_data;
            $skillsDB->save();


            $notes = Note::updateOrCreate(
                ['character_id' => $character->id],
                ['notes' => $character->notes]
            );
            return redirect()->back()->with('success', 'Karakter başarıyla güncellendi');;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Karakter güncellenemedi; ' . $e->getMessage());;
        }
    }

    public function updateCharacterImg(Request $request)
    {
        if (!Auth::user()) {
            return redirect()->back()->with('warning', 'Üye girişi yapılmamış!');
        }

        $image_url = $request->imgUrl;
        $characterId = $request->id;

        $characterDB = Character::find($characterId);
        if (!$characterDB) {
            return redirect()->back()->with('error', 'Karakter bulunamadı!');
        } else if ($characterDB->user_id != Auth::user()->id) {
            return redirect()->back()->with('error', 'Buna yetkiniz bulunmamaktadır!');
        }


        try {
            $characterDB->img_url = $image_url;
            $characterDB->save();

            return redirect()->back()->with('success', 'Resim başarıyla güncellendi');;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Resim güncellenemedi; ' . $e->getMessage());;
        }
    }


}
