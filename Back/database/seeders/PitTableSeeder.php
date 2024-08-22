<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Day;
use App\Models\Pit;

class PitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pit :: factory() -> count(1) -> make() -> each(function($pit) {
            $day = Day :: inRandomOrder() -> first();
            $pit -> save();
            $pit -> days() -> attach($day);
            
        });
    }
}
