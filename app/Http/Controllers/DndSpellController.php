<?php

namespace App\Http\Controllers;

use App\Models\DndSpell;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DndSpellController extends Controller
{
    public function index(Request $request)
    {
        $query = DndSpell::query();

        // Arama işlemi
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('school', 'like', '%' . $search . '%')
                  ->orWhere('classes', 'like', '%' . $search . '%');
            });
        }

        // Level filtresi
        if ($request->has('level') && !empty($request->level)) {
            $query->where('level', $request->level);
        }

        // School filtresi
        if ($request->has('school') && !empty($request->school)) {
            $query->where('school', $request->school);
        }

        // Class filtresi
        if ($request->has('class') && !empty($request->class)) {
            $query->where('classes', 'like', '%' . $request->class . '%');
        }

        // Concentration filtresi
        if ($request->has('concentration') && $request->concentration !== null) {
            $query->where('concentration', $request->concentration == 'true');
        }

        // Ritual filtresi
        if ($request->has('ritual') && $request->ritual !== null) {
            $query->where('ritual', $request->ritual == 'true');
        }

        // Sıralama
        $sortBy = $request->get('sort_by', 'name');
        $sortDir = $request->get('sort_direction', 'asc');
        $query->orderBy($sortBy, $sortDir);

        // Sayfalama
        $perPage = $request->get('per_page', 20);
        $spells = $query->get();

        return response()->json(["success" => true, "data" => $spells]);
    }

    public function showSpellList()
    {
        return Inertia::render('DndSpellList');
    }

    public function getFilterOptions()
    {
        $schools = DndSpell::distinct()->pluck('school')->filter()->sort()->values();
        $levels = DndSpell::distinct()->pluck('level')->filter()->sort()->values();
        $classes = DndSpell::distinct()->pluck('classes')->filter()->flatMap(function($class) {
            return explode(',', $class);
        })->map(function($class) {
            return trim($class);
        })->unique()->sort()->values();

        return response()->json([
            'schools' => $schools,
            'levels' => $levels,
            'classes' => $classes
        ]);
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