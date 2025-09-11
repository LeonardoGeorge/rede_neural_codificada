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
        // 1. Recupera a mensagem passada como argumento
        $message = $this->argument('message');

        //2. Simulação de postagem no Twitter
        $this->info("Postando tweet: '$message'");



        // TODO [FASE 2]: Substituir por lógica real da API do Twitter v2
        // $response = Http::withToken(config('services.twitter.access_token'))
        //     ->post('https://api.twitter.com/2/tweets', ['text' => $message]);
        //
        // if ($response->successful()) {
        //     $this->info('Tweet postado com sucesso!');
        //     $this->info('ID do Tweet: ' . $response->json()['data']['id']);
        // } else {
        //     $this->error('Falha ao postar tweet: ' . $response->body());
        // }

        //3. Simulação de sucesso (Teste de fluxo)
        // Em produção, remover essa linha e usar a lógica real da API
        $this->info("✅ Simulação: Tweet '$message' postado com sucesso!");

    }
}
