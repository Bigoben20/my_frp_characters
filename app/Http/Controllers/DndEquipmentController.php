<?php

namespace App\Http\Controllers;

use App\Models\DndEquipment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DndEquipmentController extends Controller
{
    /**
     * Display a listing of equipments.
     */
    public function index(): JsonResponse
    {
        $equipments = DndEquipment::orderBy('name')->get();
        return response()->json($equipments);
    }

    /**
     * Store a newly created equipment in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'notes' => 'nullable|string|max:255',
        ]);

        $equipment = DndEquipment::create([
            'name' => $request->name,
            'type' => $request->type,
            'notes' => $request->notes,
        ]);

        return response()->json($equipment, 201);
    }

    /**
     * Remove the specified equipment from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $equipment = DndEquipment::findOrFail($id);
        $equipment->delete();

        return response()->json(['message' => 'Equipment deleted successfully']);
    }
}