<?php

declare(strict_types=1);

// Base de Dados na memória
$tarefas = [
    "Aprender a sintaxe de Arrays",
    "Configurar o VS Code para PHP",
    "Beber água (importante!)"
];

// Função para mostrar as tarefas
function exibirTarefas(array $lista): void
{
    echo "--- AS TUAS TAREFAS ---\n";

    foreach ($lista as $index => $tarefa) {
        $numeroVisual = $index + 1;
        echo "[{$numeroVisual}] - {$tarefa}\n";
    }

    echo "-----------------------\n";
}

exibirTarefas($tarefas);