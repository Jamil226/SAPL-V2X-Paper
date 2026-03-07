<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [VehicleController::class, 'register']);
Route::post('/authenticate', [VehicleController::class, 'authenticate']);
Route::post('/localize', [VehicleController::class, 'localize']);

Route::post('/log-metrics', function (\Illuminate\Http\Request $request) {
    $metrics = $request->input('metrics');
    \Illuminate\Support\Facades\File::put(storage_path('logs/performance_metrics.json'), json_encode($metrics, JSON_PRETTY_PRINT));
    return response()->json(['status' => 'success']);
});
