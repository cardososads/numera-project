<?php
include_once __DIR__ . "/Numerologia.php";
include_once __DIR__ . "/NumerologiaDados.php";
// Recupera todos os metadados da placa na query
$post_meta = get_post_meta(get_the_ID());

if ($post_meta !== "") {
    $data_nascimento = formatBrDate($post_meta['placas_details__placas_data_nascimento'][0]);
    $numero_telefone = formatPhoneNumber($post_meta['placas_details__placas_numero_telefone'][0]);
    $placa_veiculo = strtoupper($post_meta['placas_details__placas_placa_veiculo'][0]);
}

$post_meta = NULL;

function formatBrDate($date)
{
    $dateTime = DateTime::createFromFormat('Y-m-d', $date);
    if ($dateTime) {
        return $dateTime->format('Y-m-d'); // Retorna no formato adequado para o input type="date"
    }
    return ''; // Ou retorne uma data padrão se necessário
}


function formatPhoneNumber($number)
{
    $number = (string) $number;
    if (strlen($number) !== 11) {
        return ''; // Retorna vazio ou pode retornar um valor padrão
    }

    $areaCode = substr($number, 0, 2);
    $firstPart = substr($number, 2, 5);
    $secondPart = substr($number, 7);

    return "($areaCode) $firstPart-$secondPart";
}

$numerologia = new Numerologia();
$calculo_placa = $numerologia->calcularPlaca($placa_veiculo);

