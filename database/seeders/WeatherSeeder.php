<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Weather;
use Illuminate\Database\Seeder;

class WeatherSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            Weather::create([
                'user_id' => $user->id,
                'condition' => 'Soleado', // Ejemplo de condición climática
                'temperature' => rand(15, 30), // Temperatura aleatoria entre 15 y 30°C
            ]);
        }
    }
}