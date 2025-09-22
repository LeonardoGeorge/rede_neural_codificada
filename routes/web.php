<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoiceCommandController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Pagina de apresentação
Route::get('/', function () {
    return view('welcome');
});

// Rota para uso dos comandos de voz e transcrição
Route::view('/rnh', 'rnh');

// Rota para processar o comando de voz vindo do frontend
Route::post('/api/voice-command', [VoiceCommandController::class, 'handleCommand']);

