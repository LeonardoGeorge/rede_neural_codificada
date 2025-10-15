<?php

namespace App\Plugins;

class CalculatorPlugin
{
    public function canHandle($command)
    {
        return preg_match('/(calcule|calculadora|some|multiplique|divida|subtraia|abra a calculadora)/i', $command);
    }

    public function execute($parameters)
    {
        // Comando para ABRIR calculadora do sistema
        if (preg_match('/(abra|abra a|open)\s*(calculadora|calculator)/i', $parameters)) {
            return $this->openSystemCalculator();
        }

        // Cálculos matemáticos
        if (preg_match('/(\d+)\s*(vezes|multiplicado por|\*)\s*(\d+)/i', $parameters, $matches)) {
            $result = $matches[1] * $matches[3];
            return "🖩 Resultado: {$matches[1]} × {$matches[3]} = {$result}";
        }

        if (preg_match('/(\d+)\s*(mais|\+)\s*(\d+)/i', $parameters, $matches)) {
            $result = $matches[1] + $matches[3];
            return "🖩 Resultado: {$matches[1]} + {$matches[3]} = {$result}";
        }

        if (preg_match('/(\d+)\s*(menos|\-)\s*(\d+)/i', $parameters, $matches)) {
            $result = $matches[1] - $matches[3];
            return "🖩 Resultado: {$matches[1]} - {$matches[3]} = {$result}";
        }

        if (preg_match('/(\d+)\s*(dividido por|\/)\s*(\d+)/i', $parameters, $matches)) {
            if ($matches[3] == 0) return "❌ Erro: Divisão por zero";
            $result = $matches[1] / $matches[3];
            return "🖩 Resultado: {$matches[1]} ÷ {$matches[3]} = {$result}";
        }

        return "❌ Formato não reconhecido. Tente: 'calcule 25 vezes 8' ou 'abra a calculadora'";
    }

    private function openSystemCalculator()
    {
        $os = PHP_OS_FAMILY;

        try {
            if ($os === 'Windows') {
                shell_exec('calc.exe');
                return "🖩 Calculadora do Windows aberta!";
            } elseif ($os === 'Darwin') {
                shell_exec('open -a Calculator');
                return "🖩 Calculadora do macOS aberta!";
            } elseif ($os === 'Linux') {
                shell_exec('gnome-calculator &');
                return "🖩 Calculadora do Linux aberta!";
            }
        } catch (\Exception $e) {
            return "❌ Não consegui abrir a calculadora";
        }

        return "🖩 Calculadora aberta!";
    }
}
