<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessTweetJob; // Corrigi o "jobs" para "Jobs" (Linux é case-sensitive)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VoiceCommandController extends Controller
{
    /**
     * Método principal que recebe o comando de voz (já convertido em texto)
     * via uma requisição POST da sua interface ou assistente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function handleCommand(Request $request) // O método precisa receber a Request
    {
        // 1. Validação do dado de entrada. Esperamos um JSON com { "command": "texto" }
        $validatedData = $request->validate([
            'command' => 'required|string|max:280', // Max de chars do Twitter
        ]);

        // Extrai o texto do comando
        $commandText = $validatedData['command'];
        Log::info("Comando de voz recebido: " . $commandText);

        // 2. Processamento de Linguagem Natural (NLP) SIMPLES.
        // Aqui você vai extrair a intenção e os parâmetros.
        // Ex: Comando "Poste no Twitter Hello World" -> Intenção: 'post_tweet', Parâmetro: 'Hello World'
        if (preg_match('/poste no twitter (.*)/i', $commandText, $matches)) {
            $tweetMessage = $matches[1]; // Captura "Hello World"

            // 3. Dispara o job para a fila, processando assincronamente!
            // Isso é crucial: não trava a resposta para o usuário.
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
