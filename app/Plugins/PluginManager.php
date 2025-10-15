<?php

namespace App\Core;

class PluginManager
{
    protected $plugins = [];

    public function register($name, $plugin)
    {
        $this->plugins[$name] = $plugin;
    }

    public function handleCommand($command, $parameters)
    {
        foreach ($this->plugins as $plugin) {
            if ($plugin->canHandle($command)) {
                return $plugin->execute($parameters);
            }
        }
        return "Desculpe, não entendi o comando. Tente: 'abra a calculadora' ou 'poste no Twitter: sua mensagem'";
    }
}
