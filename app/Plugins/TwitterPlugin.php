<?php

namespace App\Plugins;

use App\Jobs\ProcessTweetJob;

class TwitterPlugin
{
    public function canHandle($command)
    {
        return preg_match('/poste no twitter|tweetar|twitter/i', $command);
    }

    public function execute($parameters)
    {
        if (preg_match('/poste no twitter:\s*(.*)/i', $parameters, $matches)) {
            $message = trim($matches[1]);

            if (strlen($message) > 280) {
                return "❌ A mensagem é muito longa para o Twitter (máximo 280 caracteres)";
            }

            // Usa seu sistema EXISTENTE - não muda nada!
            ProcessTweetJob::dispatch($message);

            return "🐦 Tweet enviado para publicação: \"{$message}\"";
        }

        return "❌ Formato: 'Poste no Twitter: Sua mensagem aqui'";
    }
}
