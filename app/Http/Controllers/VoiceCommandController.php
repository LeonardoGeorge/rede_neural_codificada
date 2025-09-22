<?php

namespace App\Http\Controllers;

use App\Services\WhisperService;
use App\Jobs\ProcessTweetJob;
use App\Models\Note; // ← IMPORT ADICIONADO
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

            // Retornar o texto transcrito
            return response()->json([
                'success' => true,
                'transcribed_text' => $transcribedText,
                'message' => 'Áudio transcrito com sucesso'
            ]);
        } catch (\Exception $e) {
            Log::error('Erro no processamento de voz: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro interno do servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Processa o comando de texto (NLP) e dispara o job para postar no Twitter
     */
    public function handleCommand(Request $request)
    {
        // Validar se o comando foi enviado no JSON
        $validator = Validator::make($request->all(), [
            'command' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Comando não fornecido',
                'errors' => $validator->errors()
            ], 422);
        }

        $commandText = $request->input('command');
        Log::info("Comando recebido via API: " . $commandText);

        // 1) Postar no Twitter
        if (preg_match('/poste no twitter (.*)/i', $commandText, $matches)) {
            $tweetMessage = trim($matches[1]);

            // Se ainda não quer publicar, basta logar ou enfileirar.
            ProcessTweetJob::dispatch($tweetMessage);

            return response()->json([
                'status' => 'success',
                'message' => 'Seu tweet está sendo processado e será postado em breve!',
                'action' => 'tweet_queued',
                'tweet_message' => $tweetMessage,
            ]);
        }

        // 2) Criar Notas (Salvar no banco de dados)
        if (preg_match('/crie uma nota (.*)/i', $commandText, $matches)) {
            $noteText = trim($matches[1]);

            // Validação basica
            if (empty($noteText)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'O texto da nota não pode estar vazio.',
                ], 400);
            }

            try {
                $note = Note::create(['content' => $noteText]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Nota criada com sucesso!',
                    'action' => 'note_created',
                    'note' => $note,
                ]);
            } catch (\Exception $e) {
                Log::error('Erro ao criar nota: ' . $e->getMessage());
                return response()->json([
                    'status' => 'error',
                    'message' => 'Erro ao criar a nota. Tente novamente mais tarde.',
                ], 500);
            } // ← CHAVE DO catch FECHADA
        } // ← CHAVE DO if DA NOTA FECHADA

    } 
} 