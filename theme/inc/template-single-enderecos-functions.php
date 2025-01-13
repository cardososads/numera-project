<?php
include_once __DIR__ . "/Numerologia.php";
include_once __DIR__ . "/NumerologiaDados.php";
include_once __DIR__ . "/NumerologiaCalculos.php";
// Recupera todos os metadados do endereço na query
$post_meta = get_post_meta(get_the_ID());

if ($post_meta !== "") {
    $cep = $post_meta['cep'][0];
    $endereco = $post_meta['endereco'][0];
    $numero = $post_meta['numero'][0];
    $complemento = $post_meta['complemento'][0];
}

$post_meta = NULL;

$numerologia = new Numerologia();

$vibracoes_options = get_field('vibracoes', 'option');

$calc_endereco = $numerologia->calcularEndereco($numero, $endereco);