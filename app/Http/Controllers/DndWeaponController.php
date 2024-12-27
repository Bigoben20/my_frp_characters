<?php

namespace App\Http\Controllers;

use App\Models\DndWeapon;
use Illuminate\Http\Request;

class DndWeaponController extends Controller
{
    public function index()
    {
        return response()->json(DndWeapon::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'atk_bonus' => 'required|string|max:4',
            'dc' => 'required|string|max:4',
            'damage_and_type' => 'required|string|max:255',
        ]);

        DndWeapon::create($request->all());

        return response()->json(['message' => 'Weapon added successfully'], 201);
    }

    public function destroy($id)
    {
        DndWeapon::findOrFail($id)->delete();

        return response()->json(['message' => 'Weapon deleted successfully'], 200);
    }
}