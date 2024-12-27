<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DndCharacterController;
use App\Http\Controllers\DndSpellController;
use App\Http\Controllers\DndWeaponController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::get('/character-detail/{id}', [DashboardController::class, 'detailsCharacter'])->name('character.details');
Route::get('/dnd/character-detail/{id}', [DndCharacterController::class, 'dndCharacterDetail'])->name('dnd.character.detail');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    
    // GPT
    Route::get('/dnd-gpt', [DashboardController::class, 'gptChat'])->name('gptChat');
    Route::post('/send-dnd-gpt', [DashboardController::class, 'sendGptChat'])->name('gptChat.send');

    // Character
    Route::post('/character-create', [DashboardController::class, 'storeCharacter'])->name('character.create');
    Route::post('/character-delete', [DashboardController::class, 'deleteCharacter'])->name('character.delete');
    Route::post('/character-update', [DashboardController::class, 'updateCharacter'])->name('character.update');
    Route::post('/character-img-update', [DashboardController::class, 'updateCharacterImg'])->name('character.update-img');
    
    // DND Character
    Route::prefix('dnd')->group(function () {
        Route::post('/character-create', [DndCharacterController::class, 'dndCharacterStore'])->name('dnd.character.store');
        Route::post('/character-update', [DndCharacterController::class, 'dndCharacterUpdate'])->name('dnd.character.update');
        Route::post('/character-delete', [DndCharacterController::class, 'dndCharacterDelete'])->name('dnd.character.delete');
        Route::post('/character-spell-add', [DndCharacterController::class, 'dndCharacterSpellAdd'])->name('dnd.character.spell.add');
        Route::post('/character-spell-delete', [DndCharacterController::class, 'dndCharacterSpellDelete'])->name('dnd.character.spell.delete');
        Route::post('/character-weapon-add', [DndCharacterController::class, 'dndCharacterWeaponAdd'])->name('dnd.character.weapon.add');
        Route::post('/character-weapon-delete', [DndCharacterController::class, 'dndCharacterWeaponDelete'])->name('dnd.character.weapon.delete');
        Route::post('/character-equipment-add', [DndCharacterController::class, 'dndCharacterEquipmentAdd'])->name('dnd.character.equipment.add');
        Route::post('/character-equipment-delete', [DndCharacterController::class, 'dndCharacterEquipmentDelete'])->name('dnd.character.equipment.delete');
        Route::post('/character-feature-update', [DndCharacterController::class, 'dndCharacterFeatureUpdate'])->name('dnd.character.feature.update');

        Route::get('/weapons', [DndWeaponController::class, 'index']);
        Route::post('/weapons', [DndWeaponController::class, 'store']);
        Route::delete('/weapons/{id}', [DndWeaponController::class, 'destroy']);    
        Route::get('/weapon-properties', [DndWeaponController::class, 'weaponProperties']);

        Route::get('/spells', [DndSpellController::class, 'index']);
        Route::post('/spells', [DndSpellController::class, 'store']);
        Route::delete('/spells/{id}', [DndSpellController::class, 'destroy']);
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
