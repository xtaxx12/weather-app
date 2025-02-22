<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\WeatherService;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    protected $weatherService;

    // Inyectar el servicio WeatherService en el constructor
    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function getWeather($userId)
    {
        // Obtener el usuario por su ID
        $user = User::findOrFail($userId);

        // Obtener el clima usando el servicio
        $weather = $this->weatherService->getWeather($user->latitude, $user->longitude);

        // Transformar la respuesta de OpenWeatherMap
        $formattedWeather = [
            'id' => $user->id,
            'name' => $user->name,
            'weather' => [
                'condition' => $weather['weather'][0]['description'], // Descripción del clima
                'temperature' => $weather['main']['temp'] - 273.15,   // Convertir de Kelvin a Celsius
                'humidity' => $weather['main']['humidity'],          // Humedad
                'windSpeed' => $weather['wind']['speed'],            // Velocidad del viento
                'lastUpdated' => now()->toDateTimeString(),          // Fecha y hora de la última actualización
            ],
        ];

        // Devolver la respuesta en formato JSON
        return response()->json($formattedWeather);
    }
}