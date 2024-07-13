<?php

namespace App\Console\Commands;

use App\Models\Character;
use App\Models\Skills;
use Collator;
use Illuminate\Console\Command;

class FixSkills extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-skills';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix skills';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Mevcut veriler
        $skills_labels = [
            'Athletics', 'Burglary', 'Contacts', 'Crafts', 'Deceive', 'Drive', 'Empathy', 'Fight',
            'Investigate', 'Lore', 'Notice', 'Physique', 'Provoke', 'Rapport', 'Resources', 'Shoot',
            'Stealth', 'Will', 'Wisdom'
        ];

        // Türkçe karşılıklar
        $skills_turkish = [
            'Athletics' => 'Çeviklik',
            'Burglary' => 'Hırsızlık',
            'Contacts' => 'Bağlantılar',
            'Crafts' => 'Zanaat',
            'Deceive' => 'Aldatma',
            'Drive' => 'Sürücülük',
            'Empathy' => 'Empati',
            'Fight' => 'Yakın Dövüş',
            'Investigate' => 'Gözlem',
            'Lore' => 'Akademik',
            'Notice' => 'Farkındalık',
            'Physique' => 'Beden',
            'Provoke' => 'Kışkırtma',
            'Rapport' => 'Muhabbet',
            'Resources' => 'Kaynaklar',
            'Shoot' => 'Atıcılık',
            'Stealth' => 'Gizlilik',
            'Will' => 'İrade',
            'Wisdom' => 'İlim'
        ];

        $characters = Character::get();
        
        foreach ($characters as $character) {
            $skills = Skills::find($character->skills->id); 
            $skills_data = json_decode($skills->getSkillsData());

            // Türkçe label'ları ve orijinal indexlerini tutan array
            $turkish_labels_with_index = [];
            foreach ($skills_labels as $index => $label) {
                $turkish_labels_with_index[] = [
                    'turkish' => $skills_turkish[$label],
                    'index' => $index
                ];
            }

            // Türkçe karakterlere göre sıralama
            $collator = new Collator('tr_TR');
            usort($turkish_labels_with_index, function ($a, $b) use ($collator) {
                return $collator->compare($a['turkish'], $b['turkish']);
            });

            // Sıralanan verilerle yeni array'leri oluşturma
            $sorted_labels = [];
            $sorted_data = [];
            foreach ($turkish_labels_with_index as $item) {
                $sorted_labels[] = $skills_labels[$item['index']];
                $sorted_data[] = $skills_data[$item['index']];
            }

            $skills->skills_data = $sorted_data;
            $skills->save();
            $this->info($character->name.' done');
        }
    }
}
