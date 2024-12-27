<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DndWeaponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $weapons = [
            // Simple Melee Weapons
            ['name' => 'Club', 'damage_and_type' => '1d4 Bludgeoning', 'properties' => json_encode([1]), 'mastery' => 6, 'weight' => '2 lb.', 'cost' => '1 SP'],
            ['name' => 'Dagger', 'damage_and_type' => '1d4 Piercing', 'properties' => json_encode([2, 3, 8]), 'mastery' => 2, 'weight' => '1 lb.', 'cost' => '2 GP'],
            ['name' => 'Greatclub', 'damage_and_type' => '1d8 Bludgeoning', 'properties' => json_encode([9]), 'mastery' => 3, 'weight' => '10 lb.', 'cost' => '2 SP'],
            ['name' => 'Handaxe', 'damage_and_type' => '1d6 Slashing', 'properties' => json_encode([3, 8]), 'mastery' => 7, 'weight' => '2 lb.', 'cost' => '5 GP'],
            ['name' => 'Javelin', 'damage_and_type' => '1d6 Piercing', 'properties' => json_encode([8]), 'mastery' => 6, 'weight' => '2 lb.', 'cost' => '5 SP'],
            ['name' => 'Light Hammer', 'damage_and_type' => '1d4 Bludgeoning', 'properties' => json_encode([3, 8]), 'mastery' => 2, 'weight' => '2 lb.', 'cost' => '2 GP'],
            ['name' => 'Mace', 'damage_and_type' => '1d6 Bludgeoning', 'properties' => json_encode([]), 'mastery' => 5, 'weight' => '4 lb.', 'cost' => '5 GP'],
            ['name' => 'Quarterstaff', 'damage_and_type' => '1d6 Bludgeoning', 'properties' => json_encode([10]), 'mastery' => 8, 'weight' => '4 lb.', 'cost' => '2 SP'],
            ['name' => 'Sickle', 'damage_and_type' => '1d4 Slashing', 'properties' => json_encode([3]), 'mastery' => 2, 'weight' => '2 lb.', 'cost' => '1 GP'],
            ['name' => 'Spear', 'damage_and_type' => '1d6 Piercing', 'properties' => json_encode([8, 10]), 'mastery' => 5, 'weight' => '3 lb.', 'cost' => '1 GP'],

            // Simple Ranged Weapons
            ['name' => 'Dart', 'damage_and_type' => '1d4 Piercing', 'properties' => json_encode([2, 8]), 'mastery' => 7, 'weight' => '1/4 lb.', 'cost' => '5 CP'],
            ['name' => 'Light Crossbow', 'damage_and_type' => '1d8 Piercing', 'properties' => json_encode([6, 11, 9]), 'mastery' => 6, 'weight' => '5 lb.', 'cost' => '25 GP'],
            ['name' => 'Shortbow', 'damage_and_type' => '1d6 Piercing', 'properties' => json_encode([6, 9]), 'mastery' => 7, 'weight' => '2 lb.', 'cost' => '25 GP'],
            ['name' => 'Sling', 'damage_and_type' => '1d4 Bludgeoning', 'properties' => json_encode([6]), 'mastery' => 6, 'weight' => '—', 'cost' => '1 SP'],

            // Martial Melee Weapons
            ['name' => 'Battleaxe', 'damage_and_type' => '1d8 Slashing', 'properties' => json_encode([10]), 'mastery' => 8, 'weight' => '4 lb.', 'cost' => '10 GP'],
            ['name' => 'Flail', 'damage_and_type' => '1d8 Bludgeoning', 'properties' => json_encode([]), 'mastery' => 5, 'weight' => '2 lb.', 'cost' => '10 GP'],
            ['name' => 'Glaive', 'damage_and_type' => '1d10 Slashing', 'properties' => json_encode([4, 5, 9]), 'mastery' => 6, 'weight' => '6 lb.', 'cost' => '20 GP'],
            ['name' => 'Greataxe', 'damage_and_type' => '1d12 Slashing', 'properties' => json_encode([4, 9]), 'mastery' => 7, 'weight' => '7 lb.', 'cost' => '30 GP'],
            ['name' => 'Greatsword', 'damage_and_type' => '2d6 Slashing', 'properties' => json_encode([4, 9]), 'mastery' => 7, 'weight' => '6 lb.', 'cost' => '50 GP'],
            ['name' => 'Halberd', 'damage_and_type' => '1d10 Slashing', 'properties' => json_encode([4, 5, 9]), 'mastery' => 7, 'weight' => '6 lb.', 'cost' => '20 GP'],
            ['name' => 'Lance', 'damage_and_type' => '1d12 Piercing', 'properties' => json_encode([4, 5, 9]), 'mastery' => 8, 'weight' => '6 lb.', 'cost' => '10 GP'],
            ['name' => 'Longsword', 'damage_and_type' => '1d8 Slashing', 'properties' => json_encode([10]), 'mastery' => 6, 'weight' => '3 lb.', 'cost' => '15 GP'],
            ['name' => 'Maul', 'damage_and_type' => '2d6 Bludgeoning', 'properties' => json_encode([4, 9]), 'mastery' => 7, 'weight' => '10 lb.', 'cost' => '10 GP'],
            ['name' => 'Morningstar', 'damage_and_type' => '1d8 Piercing', 'properties' => json_encode([]), 'mastery' => 5, 'weight' => '4 lb.', 'cost' => '15 GP'],
            ['name' => 'Pike', 'damage_and_type' => '1d10 Piercing', 'properties' => json_encode([4, 5, 9]), 'mastery' => 6, 'weight' => '18 lb.', 'cost' => '5 GP'],
            ['name' => 'Rapier', 'damage_and_type' => '1d8 Piercing', 'properties' => json_encode([2]), 'mastery' => 6, 'weight' => '2 lb.', 'cost' => '25 GP'],
            ['name' => 'Scimitar', 'damage_and_type' => '1d6 Slashing', 'properties' => json_encode([2, 3]), 'mastery' => 2, 'weight' => '3 lb.', 'cost' => '25 GP'],
            ['name' => 'Shortsword', 'damage_and_type' => '1d6 Piercing', 'properties' => json_encode([2, 3]), 'mastery' => 6, 'weight' => '2 lb.', 'cost' => '10 GP'],
            ['name' => 'Trident', 'damage_and_type' => '1d8 Piercing', 'properties' => json_encode([8, 10]), 'mastery' => 8, 'weight' => '4 lb.', 'cost' => '5 GP'],
            ['name' => 'Warhammer', 'damage_and_type' => '1d8 Bludgeoning', 'properties' => json_encode([10]), 'mastery' => 6, 'weight' => '5 lb.', 'cost' => '15 GP'],
            ['name' => 'War Pick', 'damage_and_type' => '1d8 Piercing', 'properties' => json_encode([10]), 'mastery' => 6, 'weight' => '2 lb.', 'cost' => '5 GP'],
            ['name' => 'Whip', 'damage_and_type' => '1d4 Slashing', 'properties' => json_encode([2, 5]), 'mastery' => 6, 'weight' => '3 lb.', 'cost' => '2 GP'],

            // Martial Ranged Weapons
            ['name' => 'Blowgun', 'damage_and_type' => '1 Piercing', 'properties' => json_encode([6, 11]), 'mastery' => 7, 'weight' => '1 lb.', 'cost' => '10 GP'],
            ['name' => 'Hand Crossbow', 'damage_and_type' => '1d6 Piercing', 'properties' => json_encode([6, 3, 11]), 'mastery' => 7, 'weight' => '3 lb.', 'cost' => '75 GP'],
            ['name' => 'Heavy Crossbow', 'damage_and_type' => '1d10 Piercing', 'properties' => json_encode([6, 4, 11]), 'mastery' => 6, 'weight' => '18 lb.', 'cost' => '50 GP'],
            ['name' => 'Longbow', 'damage_and_type' => '1d8 Piercing', 'properties' => json_encode([6, 4, 9]), 'mastery' => 6, 'weight' => '2 lb.', 'cost' => '50 GP'],
            ['name' => 'Musket', 'damage_and_type' => '1d12 Piercing', 'properties' => json_encode([6, 11]), 'mastery' => 7, 'weight' => '10 lb.', 'cost' => '500 GP'],
            ['name' => 'Pistol', 'damage_and_type' => '1d10 Piercing', 'properties' => json_encode([6, 11]), 'mastery' => 7, 'weight' => '3 lb.', 'cost' => '250 GP'],
        ];

        DB::table('dnd_weapons')->insert($weapons);
    }
}
