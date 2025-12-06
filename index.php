<?php

declare(strict_types=1);

const ARQUIVO_TAREFAS = 'tarefas.json';

// --- Funções de Resistência ---
function carregarTarefas(): array
{
    if (!file_exists(ARQUIVO_TAREFAS)) {
        return [];
    }

    // Lê o conteúdo do arquivo como texto
    $conteudoJson = file_get_contents(ARQUIVO_TAREFAS);

    // Converte o texto JSON de volta para Array PHP
    $lista = json_decode($conteudoJson, true);

    // Se o arquivo estiver vazio, garante que devolve um array vazio
    return is_array($lista) ? $lista : [];
}

function salvarTarefas(array $lista): void
{
    // Converte o Array PHP para texto JSON
    $conteudoJson = json_encode($lista, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    // Escreve o texto no arquivo
    file_put_contents(ARQUIVO_TAREFAS, $conteudoJson);
}

// --- Funções de Exibição ---
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

function adicionarTarefa(array $listaAtual): array
{
    $novaTarefa = readline("Digite a nova tarefa: ");

    // Validação simples: Não aceitar tarefa vazia
    if (trim($novaTarefa) === "") {
        echo "Erro: A tarefa não pode ser vazia!\n";
        return $listaAtual;
    }

    $listaAtual[] = $novaTarefa;
    salvarTarefas($listaAtual);

    echo "Tarefa salva com sucesso! 💾\n";
    return $listaAtual;
}

function editarTarefa(array $listaAtual): array
{
    exibirTarefas($listaAtual);

    if (count($listaAtual) === 0) {
        return $listaAtual;
    }

    $numero = readline("Digite o número da tarefa para editar: ");
    $index = (int)$numero - 1;

    if (!isset($listaAtual[$index])) {
        echo "Erro: Tarefa não encontrada!\n";
        return $listaAtual;
    }

    $tarefaAntiga = $listaAtual[$index];
    echo "Tarefa atual: $tarefaAntiga\n";

    $novoTexto = readline("Digite o novo texto (ou ENTER para manter): ");

    // Se o usuário digitou apenas espaços ou nada, mantemos o antigo
    if (trim($novoTexto) === "") {
        echo "Edição cancelada (texto vazio).\n";
        return $listaAtual;
    }

    // Atualizamos a posição específica do array
    $listaAtual[$index] = $novoTexto;

    salvarTarefas($listaAtual);
    echo "Tarefa atualizada com sucesso! ✏️\n";

    return $listaAtual;
}

// --- Concluir Tarefa ---
function concluirTarefa(array $listaAtual): array
{
    // Mostrar a lista para o usuário saber qual número escolher
    exibirTarefas($listaAtual);

    if (count($listaAtual) === 0) {
        return $listaAtual;
    }

    $numero = readline("Digite o número da tarefa para concluir: ");

    // Converter o texto para número
    $index = (int)$numero - 1;

    if (!isset($listaAtual[$index])) {
        echo "Erro: Tarefa número $index não existe!\n";
        return $listaAtual;
    }

    // Guardar o nome da tarefa para mostrar na mensagem
    $tarefaRemovida = $listaAtual[$index];

    unset($listaAtual[$index]);

    // Re-organiza os índices
    $listaAtual = array_values($listaAtual);

    salvarTarefas($listaAtual);

    echo "Tarefa '$tarefaRemovida' concluída! ✅\n";

    return $listaAtual;
}

// --- Fluxo Principal ---

// Antes de começar o loop, carrega o que estava salvo no disco
$tarefas = carregarTarefas();

while (true) {
    echo "\n--- MENU ---\n";
    echo "1. Listar Tarefas\n";
    echo "2. Adicionar Tarefa\n";
    echo "3. Editar Tarefa\n";
    echo "4. Concluir Tarefa (Remover)\n";
    echo "5. Sair\n";

    $opcao = readline("Escolha uma opção: ");

    match ($opcao) {
        "1" => exibirTarefas($tarefas),
        "2" => $tarefas = adicionarTarefa($tarefas),
        "3" => $tarefas = editarTarefa($tarefas),
        "4" => $tarefas = concluirTarefa($tarefas),
        "5" => die("Adeus! 👋\n"),
        default => print "Opção inválida!\n"
    };
}