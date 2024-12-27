<?php

namespace App\Http\Controllers;

use App\Models\DndSpell;
use Illuminate\Http\Request;

class DndSpellController extends Controller
{
    public function index()
    {
        return response()->json(DndSpell::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|integer',
            'school' => 'required|string|max:255',
            'casting_time' => 'required|string|max:255',
            'range' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'components' => 'required|string|max:255',
            'concentration' => 'required|boolean',
            'ritual' => 'required|boolean',
            'classes' => 'required|string|max:255',
            'description' => 'required|string',
            'higher_levels' => 'nullable|string',
            'img_url' => 'nullable|string|max:255',
        ]);

        DndSpell::create($request->all());

        return response()->json(['message' => 'Spell added successfully'], 201);
    }

    public function destroy($id)
    {
        DndSpell::findOrFail($id)->delete();

        return response()->json(['message' => 'Spell deleted successfully'], 200);
    }
}