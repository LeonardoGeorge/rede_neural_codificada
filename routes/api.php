<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoiceCommandController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Esta rota será: POST http://sua-app.com/api/voice-command
Route::post('/voice-command', [VoiceCommandController::class, 'handleCommand']);

// Rota para processamento de comando de voz
Route::post('/voice/process', [VoiceCommandController::class, 'processVoiceCommand']);

// Rota para health check
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
        'service' => 'RNH Voice Assistant'
    ]);
});