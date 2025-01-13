<?php
include_once __DIR__ . "/Numerologia.php";
include_once __DIR__ . "/NumerologiaDados.php";


$post_meta = get_post_meta(get_the_ID());

if ($post_meta !== "") {
    $nome_completo = $post_meta['mapas_details__mapas_nome_completo'][0];
    $data_nascimento = $post_meta['mapas_details__mapas_data_nascimento'][0];
}

$post_meta = NULL;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_completo_post = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $data_nascimento_post = isset($_POST['dob']) ? sanitize_text_field($_POST['dob']) : '';

    // Se os valores foram enviados via POST, substitua os valores padrão
    $nome_completo = !empty($nome_completo_post) ? $nome_completo_post : $nome_completo;
    $data_nascimento = !empty($data_nascimento_post) ? $data_nascimento_post : $data_nascimento;
}

// Dados
$vogais = NumerologiaDados::obterVogais();
$consoantes = NumerologiaDados::obterConsoantes();
$alfabeto = NumerologiaDados::obterAlfabeto();
$tabelaPiramides = NumerologiaDados::obterTabelaPiramides();
// Calcula os valores baseados nos dados de entrada
$letras_nome = str_split($nome_completo);

$numerologia = new Numerologia();

$partes_nome = $numerologia->separarNomeCompleto($nome_completo);

$numero_destino = $numerologia->calcularNumeroDestino($data_nascimento);  // Baseado na data de nascimento
$numero_expressao = $numerologia->calcularNumeroExpressao($nome_completo);  // Baseado no nome completo
$numero_motivacao = $numerologia->calcularNumeroMotivacao($nome_completo);  // Baseado no nome completo
$numero_impressao = $numerologia->calcularNumeroImpressao($nome_completo);  // Baseado no nome completo
$numero_psiquico = $numerologia->calcularNumeroPsiquico($data_nascimento);  // Baseado na data de nascimento
$partes_nome_com_dados = [];

foreach ($partes_nome as $parte) {
    // Calcula a somatória de motivação (vogais)
    $soma_motivacao = $numerologia->calcularNumeroMotivacao($parte);

    // Calcula a somatória de expressão (todas as letras)
    $soma_expressao = $numerologia->calcularNumeroExpressao($parte);

    // Adiciona a parte com suas somatórias ao novo array
    $partes_nome_com_dados[] = [
        'parte' => $parte,
        'motivacao' => $soma_motivacao,
        'expressao' => $soma_expressao
    ];
}

// Agora $partes_nome_com_dados contém um array onde cada elemento é um array com 3 dados:

$numero_missao = $numerologia->calcularNumeroMissao($numero_destino, $numero_expressao);  // Depende de destino e expressão

$licoes_carmicas = explode(', ', $numerologia->calcularLicoesCarmicas($nome_completo));  // Baseado no nome completo
$dividas_carmicas = explode(', ', $numerologia->calculoDividasCarmicas($nome_completo, $data_nascimento));  // Baseado em ambos
$tendencias_ocultas = explode(', ', $numerologia->calcularTendenciaOculta($nome_completo));  // Baseado no nome completo

$harmonia_conjugal = $numerologia->calcularNumeroAmor($numero_destino, $numero_expressao);  // Depende de destino e expressão
$vibra_com = $harmonia_conjugal['vibra_com'];
$atrai = $harmonia_conjugal['atrai'];
$e_oposto = $harmonia_conjugal['e_oposto'];
$e_passivo_em_relacao_a = $harmonia_conjugal['e_passivo_em_relação_a'];

$resposta_subconsciente = $numerologia->calcularRespostaSubconsciente($nome_completo);
$relacoes_intervalores = $numerologia->relacoesIntervalores($nome_completo);

$ano_pessoal = $numerologia->calcularAnoPessoal($data_nascimento);  // Depende do número de destino
$mes_pessoal = $numerologia->mesPessoalCalc($data_nascimento);  // Baseado na data de nascimento
$dia_pessoal = $numerologia->calcularDiaPessoal($data_nascimento);  // Baseado na data de nascimento

$grau_ascensao = $numerologia->grauAscensao($nome_completo);  // Baseado no nome completo
$talento_oculto = $numerologia->talentoOculto($numero_motivacao, $numero_expressao);  // Depende de motivação e expressão

$cores = $numerologia->coresFavoraveis($nome_completo);  // Baseado no nome completo
$arcanos = $numerologia->calcularArcanos($nome_completo, $data_nascimento);
$arcanos = $arcanos['arcanos'];
$arcanoAtual = $numerologia->getArcanoAtual($arcanos);
$arcanos_pessoais = $numerologia->calcularArcanoPessoal($nome_completo, $data_nascimento);
$arcanos_sociais = $numerologia->calcularArcanoSocial($nome_completo, $data_nascimento);
$arcanos_destino = $numerologia->calcularArcanoDestino($nome_completo, $data_nascimento);

$resultado = $numerologia->obterDiasFavoraveis($data_nascimento);

if (is_string($resultado)) {
    $dias_favoraveis = explode(', ', $resultado);
} else {
    // Tratamento alternativo caso não seja string
    $dias_favoraveis = is_array($resultado) ? $resultado : [];
}
$numeros_harmonicos = $numerologia->numerosHarmonicos($data_nascimento);
$ciclos = $numerologia->calcularCiclos($data_nascimento, $licoes_carmicas);
$fim_primeiro_ciclo = $ciclos['fim_primeiro_ciclo'];
$momentos_decisivos = $numerologia->momentosDecisivos($data_nascimento, $fim_primeiro_ciclo);

$desafios = $numerologia->carcularDesafios($data_nascimento);

$piramide_vida = $numerologia->calcularPiramdeVida($nome_completo);
$sequencia_piramide_vida = $numerologia->sequenciaVibracional($piramide_vida);
$sequencias_vida = $numerologia->sequenciasEncontradas($sequencia_piramide_vida);

$piramide_pessoal = $numerologia->calcularPiramdePessoal($nome_completo, $data_nascimento);
$sequencia_piramide_pessoal = $numerologia->sequenciaVibracional($piramide_pessoal);
$sequencias_pessoal = $numerologia->sequenciasEncontradas($sequencia_piramide_pessoal);

$piramide_social = $numerologia->calcularPiramdeSocial($nome_completo, $data_nascimento);
$sequencia_piramide_social = $numerologia->sequenciaVibracional($piramide_social);
$sequencias_social = $numerologia->sequenciasEncontradas($sequencia_piramide_social);


$piramide_destino = $numerologia->calcularPiramdeDestino($nome_completo, $data_nascimento);
$sequencia_piramide_destino = $numerologia->sequenciaVibracional($piramide_destino);
$sequencias_destino = $numerologia->sequenciasEncontradas($sequencia_piramide_destino);

$vocacional = $numerologia->calcularTesteVocacional($numero_destino, $numero_missao, $numero_expressao, $data_nascimento);

$anjo = $numerologia->buscaAnjo($data_nascimento);

// Retorna o conteúdo da array de MOTIVACAO do usuário
$motivacao_options = get_field('motivacao', 'option');
$motivacao_content = getUserCalculusResultContent($motivacao_options, $numero_motivacao, "", 'numero_motivacao', 'texto_motivacao');

// Retorna o conteúdo da array de IMPRESSAO do usuário
$impressao_options = get_field('impressao', 'option');
$impressao_content = getUserCalculusResultContent($impressao_options, $numero_impressao, "", 'numero_impressao', 'texto_impressao');
$impressao_orientacao = getUserCalculusResultContent($impressao_options, $numero_impressao, "", 'numero_impressao', 'orientacao');

// Retorna o conteúdo da array de EXPRESSAO do usuário
$expressao_options = get_field('expressao', 'option');
$expressao_content = getUserCalculusResultContent($expressao_options, $numero_expressao, "", 'numero_expressao', 'texto_expressao');
$expressao_orientacao = getUserCalculusResultContent($expressao_options, $numero_expressao, "", 'numero_expressao', 'orientacao');

// Retorna o conteúdo da array de ARCANOS do usuário
$arcano_basicavida_options = get_field('arcano_basicavida', 'option');
$arcano_basicavida_content = getUserArcanosCalculusResultContent($arcano_basicavida_options, $arcanos, "");

// Retorna o conteúdo da array de MISSAO do usuário
$missao_options = get_field('missao', 'option');
$missao_content = getUserCalculusResultContent($missao_options, $numero_missao, "", 'numero_missao', 'texto_missao');

// Retorna o conteúdo da array de DESTINO do usuário
$destino_options = get_field('destino', 'option');
$destino_content = getUserCalculusResultContent($destino_options, $numero_destino, "", 'numero_destino', 'texto_destino');

// Retorna o conteúdo da array de ANO PESSOAL do usuário
$ano_pessoal_options = get_field('ano_pessoal', 'option');
$ano_pessoal_content = getUserCalculusResultContent($ano_pessoal_options, $ano_pessoal, "", 'numero_ano_pessoal', 'texto_ano_pessoal');

// Retorna o conteúdo da array de MES PESSOAL do usuário
$numeros_mes_pessoal_options = get_field('numeros_mes_pessoal', 'option');
$mes_pessoal_content = getUserCalculusResultContent($numeros_mes_pessoal_options, $mes_pessoal, "", 'numero_mes_pessoal', 'texto_mes_pessoal');

// Retorna o conteúdo da array de DIA PESSOAL do usuário
$numeros_dia_pessoal_options = get_field('numeros_dia_pessoal', 'option');
$dia_pessoal_content = getUserCalculusResultContent($numeros_dia_pessoal_options, $dia_pessoal, "", 'numero_dia_pessoal', 'texto_dia_pessoal');

$arcano_pessoal_options = get_field('arcano_pessoal', 'option');
$arcano_social_options = get_field('arcano_social', 'option');
$arcano_destino_options = get_field('arcano_destino', 'option');
$piramide_basicavida_options = get_field('piramide_basicavida', 'option');
$piramide_social_options = get_field('piramide_social', 'option');
$piramide_pessoal_options = get_field('piramide_pessoal', 'option');
$piramide_destino_options = get_field('piramide_destino', 'option');
$sequencias_positivas_options = get_field('sequencias_positivas', 'option');
$sequencias_negativas_options = get_field('sequencias_negativas', 'option');
$dias_favoraveis_options = get_field('dias_favoraveis', 'option');
$numeros_harmonicos_options = get_field('numeros_harmonicos', 'option');
$numeros_desafios_options = get_field('numeros_desafios', 'option');
$numeros_psiquicos_options = get_field('numeros_psiquicos', 'option');
$grau_ascenssao_options = get_field('grau_ascenssao', 'option');
$resposta_subconsciente_options = get_field('resposta_subconsciente', 'option');
$momentos_decisivos_options = get_field('momentos_decisivos', 'option');
$relacoes_intervalores_options = get_field('relacoes_intervalos', 'option');
$licoes_carmicas_options = get_field('licoes_carmicas', 'option');
$dividas_carmicas_options = get_field('dividas_carmicas', 'option');
$primeiro_ciclo_de_vida_options = get_field('primeiro_ciclo_de_vida', 'option');
$segundo_ciclo_de_vida_options = get_field('segundo_ciclo_de_vida', 'option');
$terceiro_ciclo_de_vida_options = get_field('terceiro_ciclo_de_vida', 'option');
$hamonia_conjugal_options = get_field('hamonia_conjugal', 'option');
$tendencias_ocultas_options = get_field('tendencias_ocultas', 'option');
$talento_oculto_options = get_field('talento_oculto', 'option');
$cores_options = get_field('cores', 'option');
$anjo_options = get_field('anjo', 'option');
$dia_natalicio_options = get_field('dia_natalicio', 'option');
$anjo = $anjo[0];
$dia_natalicio = getDiaNatalicio($data_nascimento, $dia_natalicio_options);
$descricao_docx_options = get_field('descricao_docx', 'option');

 echo '<pre>';
 var_dump ($descricao_docx_options[]);
 die();
$numero_anjo = $anjo['numero'];

$licao_carmica = [];
foreach ($licoes_carmicas_options as $licao) {
    if($licao['numero_licao_carmica'] == $licoes_carmicas[0]){
        $licao_carmica = $licao;
    }
}

$divida_carmica = [];
foreach ($dividas_carmicas_options as $divida) {
    if($divida['numero_divida_carmica'] == $dividas_carmicas[0]){
        $divida_carmica = $divida;
    }
}

$resultado_tendencias = array_filter($tendencias_ocultas_options, function ($item) use ($tendencias_ocultas) {
    return in_array($item["numero_tendencia_oculta"], $tendencias_ocultas);
});

$resultado_desafios = array_filter($numeros_desafios_options, function ($item) use ($desafios) {
    return in_array($item["numero_do_desafio"], $desafios);
});

$resultado_talento = [];
foreach ($talento_oculto_options as $talento) {
    if($talento['numero_talento_oculto'] == $talento_oculto){
        $resultado_talento = $talento;
    }
}

$resultado_numero_psiquico = [];
foreach ($numeros_psiquicos_options as $numero) {
    if($numero['numero_psiquico'] == $numero_psiquico){
        $resultado_numero_psiquico = $numero;
    }
}

function transformDate($date)
{
    $dateTime = DateTime::createFromFormat('Ymd', $date);
    return $dateTime ? $dateTime->format('Y-m-d') : 'Invalid date format';
}

function formatBrDate($date)
{
    $dateObj = DateTime::createFromFormat('Y-m-d', $date);
    return $dateObj ? $dateObj->format('d/m/Y') : $date;
}

function convertDate($date)
{
    return str_replace('-', '/', $date);
}

function getUserCalculusResultContent($options, $numero, $content, $index, $select_index)
{
    foreach ($options as $option):
        if ($option[$index] == $numero):
            $content = $option[$select_index];
            break;
        endif;
    endforeach;

    return $content;
}

function getUserArcanosCalculusResultContent($arcano_basicavida_options, $arcanoAtual, $arcano_basicavida_content)
{
    foreach ($arcano_basicavida_options as $arcano_basicavida_option):
        if ($arcano_basicavida_option['numero_arcano_basicavida'] == $arcanoAtual):
            $arcano_basicavida_content = array(
                "img" => $arcano_basicavida_option['imagem_arcano'],
                "text" => $arcano_basicavida_option['texto_arcano_basicavida']
            );
            break;
        endif;
    endforeach;

    return $arcano_basicavida_content;
}
function getDiaNatalicio($data_nascimento, $dia_natalicio)
{
    // Obtém o dia do nascimento como um número inteiro
    $diaNascimento = (int)date('d', strtotime($data_nascimento));

    // Procura no array o elemento correspondente ao dia
    foreach ($dia_natalicio as $dia) {
        if ((int)$dia['dia'] === $diaNascimento) {
            return $dia; // Retorna o array do dia correspondente
        }
    }

    // Caso o dia não seja encontrado, retorna null ou uma mensagem padrão
    return null;
}

