<?php
// app/Core/PluginManager.php

namespace App\Core;

class PluginManager
{
    protected $plugins = [];

    public function register($name, $plugin)
    {
        $this->plugins[$name] = $plugin;
    }

    public function handleCommand($command)
    {
        foreach ($this->plugins as $plugin) {
            if ($plugin->canHandle($command)) {
                return $plugin->execute($command);
            }
        }
        return "Desculpe, não entendi o comando.";
    }
}
