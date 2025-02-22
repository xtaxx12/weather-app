<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController; // Importa el controlador
use App\Http\Controllers\UserController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Ruta principal (página de bienvenida)
Route::get('/', function () {
    return view('welcome');
});
Route::get('api/users', [UserController::class, 'index']);
// Ruta para mostrar el clima de un usuario específico


Route::get('api/weather/{userId}', [WeatherController::class, 'getWeather']);