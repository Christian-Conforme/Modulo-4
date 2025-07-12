<?php
use App\Http\Controllers\GeminiController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\VehiculoSucursalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('sucursales', SucursalController::class);
    Route::apiResource('vehiculos', VehiculoController::class);
    Route::apiResource('vehiculo-sucursal', VehiculoSucursalController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('roles', RolController::class);
    Route::apiResource('empleados', EmpleadoController::class);
    Route::post('/gemini/preguntar', [GeminiController::class, 'preguntar']);


});

// Registro y login públicos
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
