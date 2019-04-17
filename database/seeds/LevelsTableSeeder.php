<?php

use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $levels = [
            [
                'name' => 'Easy',
                'description' => '',
            ],
            [
                'name' => 'Normal',
                'description' => '',
            ],
            [
                'name' => 'Hard',
                'description' => '',
            ],
        ];

        foreach ($levels as $level) {
            Level::create($level);
        }
    }
}
