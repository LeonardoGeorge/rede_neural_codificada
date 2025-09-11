<?php

namespace App\Http\Controllers;

use App\Services\WhisperService;
use App\Jobs\ProcessTweetJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class VoiceCommandController extends Controller
{
    protected $whisperService;

    public function __construct(WhisperService $whisperService)
    {
        $this->whisperService = $whisperService;
    }

    /**
     * Processa áudio de comando de voz e transcreve usando Whisper API
     */
    public function processVoiceCommand(Request $request)
    {
        // Validar se o arquivo de áudio foi enviado
        $validator = Validator::make($request->all(), [
            'audio' => 'required|file|mimes:mp3,wav,m4a,ogg,webm|max:10240'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Arquivo de áudio inválido',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Salvar arquivo temporariamente
            $audioFile = $request->file('audio');
            $tempPath = $audioFile->storeAs('temp', 'voice_command_' . time() . '.' . $audioFile->extension());

            // Transcrição com Whisper
            $fullPath = storage_path('app/' . $tempPath);
            $transcribedText = $this->whisperService->transcribeAudio($fullPath);

            // Limpar arquivo temporário
            unlink($fullPath);

            if (!$transcribedText) {
                return response()->json([
                    'success' => false,
                    'message' => 'Falha na transcrição do áudio'
                ], 500);
            }

            // Processar comando de texto transcrito
            return $this->handleCommand($transcribedText);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro interno do servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Processa o comando de texto (NLP) e dispara o job para postar no Twitter
     */
    public function handleCommand($commandText)
    {
        Log::info("Comando de voz recebido: " . $commandText);

        // 2. Processamento de Linguagem Natural (NLP) SIMPLES.
        // Ex: Comando "Poste no Twitter Hello World" -> Intenção: 'post_tweet', Parâmetro: 'Hello World'
        if (preg_match('/poste no twitter (.*)/i', $commandText, $matches)) {
            $tweetMessage = trim($matches[1]); // Captura "Hello World"

            // 3. Dispara o job para a fila, processando assincronamente!
            ProcessTweetJob::dispatch($tweetMessage);

            // 4. Responde imediatamente para o cliente (usuário)
            return response()->json([
                'status' => 'success',
                'message' => 'Seu tweet está sendo processado e será postado em breve!',
                'command' => $commandText,
                'tweet_message' => $tweetMessage,
            ]);
        }

        // 5. Se o comando não for reconhecido
        return response()->json([
            'status' => 'error',
            'message' => 'Desculpe, não entendi o comando. Tente algo como: "Poste no Twitter Minha mensagem"',
        ], 400); // Código HTTP 400 Bad Request
    }
}
