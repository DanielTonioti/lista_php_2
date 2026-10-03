<?php

function contarLetrasMaiusculas(string $senha): int
{
    return preg_match_all('/\p{Lu}/u', $senha) ?: 0;
}

function contarLetrasMinusculas(string $senha): int
{
    return preg_match_all('/\p{Ll}/u', $senha) ?: 0;
}

function contarNumerosSenha(string $senha): int
{
    return preg_match_all('/\p{N}/u', $senha) ?: 0;
}

function contarCaracteresEspeciais(string $senha): int
{
    return preg_match_all('/[^\p{L}\p{N}\s]/u', $senha) ?: 0;
}

function classificarSenha(int $tamanho, int $maiusculas, int $minusculas, int $numeros, int $especiais): string
{
    if ($tamanho < 8) {
        return 'Fraca';
    }

    $criterios = (int) ($maiusculas > 0)
        + (int) ($minusculas > 0)
        + (int) ($numeros > 0)
        + (int) ($especiais > 0)
        + (int) ($tamanho >= 8);

    if ($criterios == 5) {
        return 'Muito Forte';
    } elseif ($criterios == 4) {
        return 'Forte';
    } elseif ($criterios == 3) {
        return 'Média';
    }

    return 'Fraca';
}

function analisarSenha(string $senha): array
{
    $tamanho = preg_match_all('/./us', $senha) ?: 0;
    $maiusculas = contarLetrasMaiusculas($senha);
    $minusculas = contarLetrasMinusculas($senha);
    $numeros = contarNumerosSenha($senha);
    $especiais = contarCaracteresEspeciais($senha);

    return [
        'maiusculas' => $maiusculas,
        'minusculas' => $minusculas,
        'numeros' => $numeros,
        'especiais' => $especiais,
        'tamanho' => $tamanho,
        'nivel' => classificarSenha($tamanho, $maiusculas, $minusculas, $numeros, $especiais)
    ];
}

$senha = 'Senha@2026';
$resultado = analisarSenha($senha);

echo "Senha analisada: " . $senha . "<br>";
echo "Letras maiúsculas: " . $resultado['maiusculas'] . "<br>";
echo "Letras minúsculas: " . $resultado['minusculas'] . "<br>";
echo "Números: " . $resultado['numeros'] . "<br>";
echo "Caracteres especiais: " . $resultado['especiais'] . "<br>";
echo "Tamanho: " . $resultado['tamanho'] . "<br>";
echo "Nível de segurança: " . $resultado['nivel'] . "<br>";
