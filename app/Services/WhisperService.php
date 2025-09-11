<?php

namespace App\Services;

use OpenAI;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Providers\OpenAIServiceProvider;


class WhisperService
{
    protected $client;
    protected $model;

    public function __construct()
    {
        $this->client = OpenAI::client(env('OPENAI_API_KEY'));
        $this->model = env('WHISPER_MODEL', 'whisper-1');
    }

    public function transcribeAudio($audioPath, $language = 'pt')
    {
        try {
            // Verificar se o arquivo existe
            if (!file_exists($audioPath)) {
                throw new \Exception("Arquivo de áudio não encontrado: " . $audioPath);
            }

            // Abrir o arquivo de áudio
            $audioFile = fopen($audioPath, 'r');

            // Fazer a requisição para a API Whisper
            $response = $this->client->audio()->transcribe([
                'model' => $this->model,
                'file' => $audioFile,
                'response_format' => 'json',
                'language' => $language, // Opcional: forçar idioma português
            ]);

            // Fechar o arquivo
            fclose($audioFile);

            return $response->text;
        } catch (\Exception $e) {
            Log::error('Erro na transcrição Whisper: ' . $e->getMessage());
            return false;
        }
    }

    public function transcribeAudioFromBlob($audioBlob, $extension = 'webm')
    {
        try {
            // Salvar blob temporariamente
            $tempFilename = 'temp_audio_' . time() . '.' . $extension;
            $tempPath = storage_path('app/temp/' . $tempFilename);

            // Garantir que o diretório existe
            if (!file_exists(storage_path('app/temp'))) {
                mkdir(storage_path('app/temp'), 0755, true);
            }

            // Salvar arquivo temporário
            file_put_contents($tempPath, $audioBlob);

            // Transcrever
            $transcription = $this->transcribeAudio($tempPath);

            // Limpar arquivo temporário
            unlink($tempPath);

            return $transcription;
        } catch (\Exception $e) {
            Log::error('Erro no processamento do blob de áudio: ' . $e->getMessage());
            return false;
        }
    }
}
