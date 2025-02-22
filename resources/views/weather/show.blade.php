<!-- resources/views/weather/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Clima para {{ $user->name }}</h1>
    <p>Ubicación: Latitud {{ $user->latitude }}, Longitud {{ $user->longitude }}</p>
    <h2>Información del Clima</h2>
    <ul>
        <li>Temperatura: {{ $weather['main']['temp'] }}°C</li>
        <li>Estado: {{ $weather['weather'][0]['description'] }}</li>
        <li>Humedad: {{ $weather['main']['humidity'] }}%</li>
        <li>Viento: {{ $weather['wind']['speed'] }} m/s</li>
    </ul>
</div>
@endsection