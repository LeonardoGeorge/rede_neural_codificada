<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http; // fazer chamadas à API do Twitter
use Illuminate\Support\Facades\Log; // Para Log::info() e Log::error()
use GuzzleHttp\Client; // Para new Client()
use GuzzleHttp\Exception\ClientException; // Para catch (ClientException $e)
use Exception; // Para catch (Exception $e)


class PostTweet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tweet:post {message}'; 
    // Exemplo: php artisan tweet:post "Hello World"

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Posta um tweet na conta autorizada';
    // Descrição para ajudar

    /**
     * Execute the console command.
     * AQUI É ONDE A MÁGICA ACONTECE: A lógica para postar no Twitter.
     * @return int
     */
    public function handle()
    {
        $message = $this->argument('message');

        // 1. Validação Básica
        if (strlen($message) > 280) {
            $this->error('A mensagem excede o limite de 280 caracteres do Twitter.');
            return;
        }

        // 2. Configuração do Cliente HTTP Guzzle com OAuth 1.0a
        $stack = \GuzzleHttp\HandlerStack::create();

$middleware = new \GuzzleHttp\Subscriber\Oauth\Oauth1([
    'consumer_key'    => env('TWITTER_CONSUMER_KEY'),
    'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),
    'token'           => env('TWITTER_ACCESS_TOKEN'),
    'token_secret'    => env('TWITTER_ACCESS_TOKEN_SECRET'),
]);
        $stack->push($middleware);

        $client = new Client([
            'base_uri' => 'https://api.twitter.com/2/',
            'handler' => $stack,
            'auth' => 'oauth' // Isso diz ao Guzzle para usar o middleware OAuth
        ]);

        try {
            $this->info("Enviando tweet para a API do Twitter: '$message'");

            // 3. Faz a requisição POST para a API v2
            $response = $client->post('tweets', [
                'json' => ['text' => $message]
            ]);

            // 4. Processa a resposta de sucesso
            $body = json_decode($response->getBody(), true);
            $tweetId = $body['data']['id'];

            $this->info("✅ Tweet postado com sucesso!");
            $this->info("🔗 ID do Tweet: " . $tweetId);
            $this->info("👀 Veja em: https://twitter.com/user/status/" . $tweetId);

            Log::info('Tweet postado', ['id' => $tweetId, 'text' => $message]);
        } catch (ClientException $e) {
            $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
            $this->error('❌ Erro da API do Twitter: ' . $e->getMessage());
            $this->error('Detalhes: ' . print_r($errorResponse, true));
            Log::error('Erro ao postar tweet', ['error' => $errorResponse]);
        } catch (Exception $e) {
            $this->error('❌ Erro inesperado: ' . $e->getMessage());
            Log::error('Erro inesperado ao postar tweet', ['error' => $e->getMessage()]);
        }
    }
}
