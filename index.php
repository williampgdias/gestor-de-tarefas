<?php

declare(strict_types=1);

function boasVindas(string $nome): string
{
    return "Olá, $nome! O ambiente PHP 8+ está configurado e pronto.";
}

echo "--- INICIANDO SISTEMA ---\n";
echo boasVindas("Desenvolvedor");
echo "\n";