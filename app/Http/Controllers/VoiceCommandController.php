<?php

namespace App\Http\Controllers;

use App\jobs\ProcessTweetjob;
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
    public function handleCommand(Request $request)
    {
        //1. Validação de dados de entrada. Esperamop um JSON com {"command": "texto"}
        $validateData = $request->validate([
            'command' => 'required|string|max:280', // Limite de 280 caracteres para tweets
        ]);

        // Extrai o texto do comando
        $commandText = $validateData['command'];
        Log::info("Comando recebido: " . $commandText); // Registra o Log no Laravel

        //2. Processamento de Linguagem Natural (NPL) Simples
        // Extração da intenção e os parâmetros
        // Ex.: Comando "Poste no Twitter Hello World" -> INtenção: 'post_tweet', Parâmetro: 'Hello World'
        if (preg_match('/poste no twitter (.*)/i', $commandText, $matches)) {
            $tweetMessage = $matches[1]; // Captura "Hello World"


            //3. Dispara o job para fila, processado assíncronomente!
            // Isso é crucial: não trava a resposta para o usuário.
            ProcessTweetJob::dispatch($tweetMessage);

            //4. Responde imediatamente ao usuário (usuario)
            return response()->json([
                'status' => 'success',
                'message' => 'Seu Tweet está sendo processado e será postado em breve!',
                'command' => $commandText,
                'tweet_message' => $tweetMessage,
            ]);
        }

        //5. Se o comando não for reconhecido
        return response()->json([
            'status' => 'error',
            'message' => 'Desculpe, não entendi o comando. Tente algo como "Poste no Twitter Hello World".',
        ], 400); // Código 400: Bad Request
    }

}
