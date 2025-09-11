<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan; 
use Illuminate\Support\Facades\Log; 

class ProcessTweetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * A mensagem do tweet que será passada para o comando.
     * O Laravel automaticamente serializa e desserializa propriedades públicas para a fila.
     *
     * @var string
     */
    public $tweetMessage;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $tweetMessage)
    {
        // Armazena a mensagem na propriedade pública
        // Ela será serializada e amazenada no Redis, e recuperada depois pelo worker
        $this->tweetMessage = $tweetMessage;
    }

    /**
     * Execute o job.
     * Este método é chamado automaticamente pelo worker quando ele pega este job da fila.
     * Aqui colocamos a lógica que queremos executar em segundo plano.
     *
     * @return void
     */
    public function handle()
    {
        //1. Registra no log que o job começou a ser processado (útil para debug)
        Log::info("ProcessTweetJob iniciando para a mensagem: '{$this->tweetMessage}'");
        
        //2. Chamando o comando artisan 'tweet:post' com a mensagem do tweet
        //2.1. Passando mensagem como argumento
        // 2.2. O comando será executado pelo worker, em segundo plano.
        Artisan::call('tweet:post', [
            'message' => $this->tweetMessage
        ]);

        //3. Registra no log que o job foi concluído
        Log::info("ProcessTweetJob concluído para a mensagem: '{$this->tweetMessage}'");

        // Para o futuro: TOFO [FASE 2] Aqui você pode adicionar notificações de sucesso (email, push, etc)
        
    }
}
