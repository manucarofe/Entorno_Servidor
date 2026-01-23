<?php
function duplicarValor($numero)
{
    $numero = $numero * 2;
    echo "Dentro de duplicarValor: $numero\n";
}
function duplicarReferencia(&$numero)
{
    $numero = $numero * 2;
    echo "Dentro de duplicarReferencia: $numero\n";
}
$valor = 10;
echo "Valor inicial: $valor\n\n";

// Paso por valor
duplicarValor($valor);

echo "Después de duplicarValor: $valor\n\n";

// Paso por referencia
duplicarReferencia($valor);

echo "Después de duplicarReferencia: $valor\n";
