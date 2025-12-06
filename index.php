<?php

declare(strict_types=1);

// --- Base de Dados na memória ---
$tarefas = [
    "Estudar PHP",
    "Beber café"
];

// --- Função para mostrar as tarefas ---
function exibirTarefas(array $lista): void
{
    echo "\n--- AS TUAS TAREFAS ---\n";

    if (count($lista) === 0) {
        echo "Nenhuma tarefa pendente.\n";
    }

    foreach ($lista as $index => $tarefa) {
        echo "[" . ($index + 1) . "] " . $tarefa . "\n";
    }

    echo "-----------------------\n";
}

// --- Fluxo Principal (O Loop) ---
while (true) {
    echo "\n--- MENU ---\n";
    echo "1. Listar Tarefas\n";
    echo "2. Adicionar Tarefa\n";
    echo "3. Sair\n";

    $opcao = readline("Escolha uma opção: ");

    match ($opcao) {
        "1" => exibirTarefas($tarefas),
        "2" => $tarefas = adicionarTarefa($tarefas),
        "3" => die("Adeus! 👋\n"),
        default => print "Opção inválida!\n"
    };
}

function adicionarTarefa(array $listaAtual): array
{
    $novaTarefa = readline("Digite a nova tarefa: ");

    // Validação simples: Não aceitar tarefa vazia
    if ($novaTarefa === "") {
        echo "Erro: A tarefa não pode ser vazia!\n";
        return $listaAtual;
    }

    $listaAtual[] = $novaTarefa;

    echo "Tarefa adicionada com sucesso! ✅\n";

    return $listaAtual;
}