<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SimulatorController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/simulator', function (\Illuminate\Http\Request $request) {
    if ($request->expectsJson() || str_contains($request->header('User-Agent', ''), 'Postman') || str_contains($request->header('User-Agent', ''), 'curl')) {
        return response()->json([
            'status' => 'success',
            'message' => 'Connection is established. Smart city vehicle simulator is ready.',
            'endpoints' => [
                'auth' => 'POST /simulate/auth',
                'localization' => 'POST /simulate/localization',
                'messages' => 'POST /simulate/messages',
                'stats' => 'GET /stats'
            ],
            'timestamp' => now()->toIso8601String()
        ]);
    }
    return view('simulator');
});

Route::post('/simulate/auth', [SimulatorController::class, 'auth']);
Route::post('/simulate/localization', [SimulatorController::class, 'localization']);
Route::post('/simulate/messages', [SimulatorController::class, 'messages']);
Route::get('/stats', [SimulatorController::class, 'stats']);
Route::get('/simulate/vehicle-info/{uid}', [SimulatorController::class, 'getVehicleInfo']);
Route::post('/simulate/reset', [SimulatorController::class, 'reset']);


