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

// Rota para comando de texto (que é o que seu frontend está usando)
Route::post('/voice-command', [VoiceCommandController::class, 'handleCommand']);

// Rota para processamento de áudio (se for usar no futuro)
Route::post('/voice/process', [VoiceCommandController::class, 'processVoiceCommand']);

// Rota para health check
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
        'service' => 'RNH Voice Assistant'
    ]);
});