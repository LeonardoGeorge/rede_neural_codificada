<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Jobs\ProcessTweetJob;
use App\Services\WhisperService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
// ADICIONE ESTAS LINHAS:
use App\Core\PluginManager;
use App\Plugins\CalculatorPlugin;
use App\Plugins\TwitterPlugin;

class VoiceCommandController extends Controller
{
    protected $whisperService;
    // ADICIONE ESTA PROPRIEDADE:
    protected $pluginManager;

    public function __construct(WhisperService $whisperService)
    {
        $this->whisperService = $whisperService;
        // ADICIONE ESTAS LINHAS:
        $this->pluginManager = new PluginManager();

        // Registrar plugins - ADICIONE ESTAS LINHAS:
        $this->pluginManager->register('twitter', new TwitterPlugin());
        $this->pluginManager->register('calculator', new CalculatorPlugin());
    }

    public function handleCommand(Request $request)
    {
        // MANTENHA todo seu código existente aqui...
        // Se você já tem lógica funcionando, NÃO REMOVA!

        // APENAS ADICIONE no final ou adapte para usar os plugins:
        $text = $request->input('text');

        if (empty($text)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Nenhum texto foi enviado.'
            ], 400);
        }

        Log::info('Comando recebido: ' . $text);

        // NOVA LINHA: Processar com plugins
        $result = $this->pluginManager->handleCommand($text, $text);

        return response()->json([
            'status' => 'success',
            'response' => $result,
            'command' => $text
        ]);
    }

    // MANTENHA todos os seus outros métodos existentes!
    // Se você tem processVoiceCommand, NÃO MUDE!
}
