<?php

namespace App\Services;

use GuzzleHttp\Client;

class WeatherService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('WEATHER_API_KEY');
    }

    public function getWeather($lat, $lon)
    {
        $response = $this->client->get("https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&appid={$this->apiKey}&units=metric");
        return json_decode($response->getBody(), true);
    }
}