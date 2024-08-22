<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Day;
use App\Models\Pit;
use Illuminate\Support\Facades\Storage;

class DayTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Day :: factory() -> count(1) -> make() -> each(function($day) {

            $imageUrl = "https://picsum.photos/640/400";
            // Scarica l'immagine dall'URL
            $imageData = file_get_contents($imageUrl);

            // Genera un nome univoco per il file immagine
            $fileName = uniqid() . '.jpg';

            // Salva l'immagine scaricata nella directory di archiviazione pubblica
            Storage::disk('public')->put('images/day_image/' . $fileName, $imageData);

            // Costruisci l'URL completo per l'immagine salvata
            $imgPath = 'images/day_image/' . $fileName;

            // Assegna l'URL dell'immagine al campo corrispondente nel modello Teacher
            $day->immagine = $imgPath;
            
            $day -> save();
        });
    }
}
