<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillLabelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $skills = [
            'Akademik',
            'Aldatma',
            'Atıcılık',
            'Bağlantılar',
            'Beden',
            'Çeviklik',
            'Empati',
            'Farkındalık',
            'Gizlilik',
            'Gözlem',
            'Hırsızlık',
            'İlim',
            'İrade',
            'Kaynaklar',
            'Kışkırtma',
            'Muhabbet',
            'Sürücülük',
            'Yakın Dövüş',
            'Zanaat'
        ];

        foreach ($skills as $skill) {
            DB::table('skill_labels')->insert([
                'title' => $skill,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
