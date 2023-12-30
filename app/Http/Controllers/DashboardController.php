<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function dashboard() {
        $characters = Character::where("user_id", Auth::user()->id)->orderBy("id","DESC")->get();

        return Inertia::render('Dashboard',compact("characters"));
    }

    public function storeCharacter(Request $request)
    {
        $validateData = $request->validate([
            'name' => ['required', 'max:50'],
            'high_concept' => ['required', 'max:255'],
        ],[
            'name.required' => 'Lütfen isim giriniz',
            'name.max' => 'İsim en fazla 50 karakter olabilir',
            'high_concept.required' => 'Lütfen high concept giriniz',
            'high_concept.max' => 'High concept alanı en fazla 255 karakter olabilir'
        ]);
        $validateData["user_id"] = Auth::id();
        Character::create($validateData);

        return redirect()->back()->with('success','Karakter başarıyla oluşturuldu');
    }

    public function deleteCharacter(Request $request) {
        $validateData = $request->validate([
            'id' => ['required']
        ]);

        $character = Character::where([["user_id",Auth::id()],["id",$validateData["id"]]])->first();
        if (!$character) {
            return redirect()->back()->with('error','Karakter silinemedi');
        }
        try {
            $character->delete();
            return redirect()->back()->with('success','Karakter başarıyla silindi');;
        } catch (\Exception $e) {
            return redirect()->back()->with('error','Karakter silinemedi');;
        }
    }
}
