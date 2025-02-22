<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Obtener todos los usuarios con sus datos climáticos
        $users = User::with('weather')->get();

        // Devolver la respuesta en formato JSON
        return response()->json($users);
    }
}