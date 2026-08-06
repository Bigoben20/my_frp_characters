<?php

namespace App\Http\Controllers;

use App\Models\DndWeapon;
use App\Models\DndWeaponProperty;
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
            'notes' => 'sometimes|nullable|string|max:255',
            'properties' => 'sometimes|nullable|string|max:255',
            'cost' => 'sometimes|string|max:100',
            'weight' => 'sometimes|string|max:100',
            'mastery' => 'sometimes|int|exists:dnd_weapon_properties,id',
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

    public function weaponProperties()
    {
        return response()->json(DndWeaponProperty::all());
    }
}