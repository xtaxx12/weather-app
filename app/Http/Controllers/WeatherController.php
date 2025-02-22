<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\WeatherService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    protected $weatherService;

    /**
     * Constructor para inyectar el servicio WeatherService.
     *
     * @param WeatherService $weatherService
     */
    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }
    public function fetchWeather($lat, $lon) {
        $cacheKey = "weather_{$lat}_{$lon}";
        return Cache::remember($cacheKey, 3600, function () use ($lat, $lon) {
            return Http::get("https://api.openweathermap.org/data/2.5/weather", [
                'lat' => $lat, 'lon' => $lon, 'appid' => env('WEATHER_API_KEY'), 'units' => 'metric'
            ])->json();
        });
    }

    /**
     * Muestra el clima de un usuario específico.
     *
     * @param int $userId
     * @return \Illuminate\View\View
     */


    public function show($userId)
    {
        // Busca el usuario por su ID o lanza una excepción 404 si no existe
        $user = User::findOrFail($userId);

        // Usa el caché para almacenar los datos del clima durante 60 minutos
        $weather = Cache::remember("weather_{$user->id}", 60, function() use ($user) {
            return $this->weatherService->getWeather($user->latitude, $user->longitude);
        });

        // Retorna la vista con los datos del usuario y el clima
        return view('weather.show', compact('user', 'weather'));
    }
}