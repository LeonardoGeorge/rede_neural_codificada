<?php

namespace App\Http\Controllers;

use App\Services\WhisperService;
use App\Jobs\ProcessTweetJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Note;

class VoiceCommandController extends Controller
{

        protected $whisperService;

        public function __construct(WhisperService $whisperService)
        {
            // whisperService é opcional se você não usa upload de áudio
            $this->whisperService = $whisperService;
        }

        // ... (mantém processVoiceCommand se precisar) ...

        public function handleCommand(Request $request)
        {
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

            $commandText = trim($request->input('command'));
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

            // 2) Criar nota (salva no banco)
            if (preg_match('/crie uma nota (.*)/i', $commandText, $matches)) {
                $noteText = trim($matches[1]);

                $note = Note::create([
                    'content' => $noteText
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Nota criada com sucesso!',
                    'action' => 'note_created',
                    'note' => $note
                ]);
            }

            // 3) Pesquisar no Google (retorna URL para o front abrir)
            if (preg_match('/pesquise(?: no google)? (.*)/i', $commandText, $matches)) {
                $query = trim($matches[1]);
                $url = 'https://www.google.com/search?q=' . urlencode($query);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Abrindo pesquisa no Google...',
                    'action' => 'open_url',
                    'url' => $url
                ]);
            }

            // 4) Raiz quadrada: "Qual a raiz quadrada de 25?"
            if (preg_match('/raiz quadrada de (\d+(\.\d+)?)/i', $commandText, $matches)) {
                $num = floatval($matches[1]);
                $result = sqrt($num);

                return response()->json([
                    'status' => 'success',
                    'message' => "Resultado: √{$num} = {$result}",
                    'action' => 'show_calculation',
                    'calculation' => "√{$num} = {$result}",
                    'value' => $result
                ]);
            }

            // Fallback: comando não reconhecido
            return response()->json([
                'status' => 'error',
                'message' => 'Desculpe, não entendi o comando. Tente: "Poste no Twitter ...", "Crie uma nota ..." ou "Pesquise ..."',
                'action' => 'unknown'
            ], 400);
        }

        // Se quiser manter o método processVoiceCommand para uploads de áudio, deixe aqui.
        public function processVoiceCommand(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'audio' => 'required|file|mimes:mp3,wav,m4a|max:10240', // max 10MB
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Arquivo de áudio inválido',
                    'errors' => $validator->errors()
                ], 422);
            }

            if (!$this->whisperService) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Serviço de transcrição não está disponível'
                ], 500);    
        }       
    }
}