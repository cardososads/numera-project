<?php
include_once get_template_directory() . '/helpers/docx_download.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Style\Paragraph;
use PhpOffice\PhpWord\SimpleType\Jc;

function gerar_docx_com_infos() {
    if (isset($_GET['download_docx'])) {
        require_once get_template_directory() . '/inc/template-single-mapa-functions.php';

        $phpWord = start_php_word_docx();
        $section = $phpWord->addSection();

        // Adiciona informações básicas
        add_basic_info_section($section, $nome_completo, $data_nascimento);

        add_dia_natalicio_section($section, $dia_natalicio);
        // Análise de Assinatura    
        add_signature_analysis_section($section, $letras_nome, $vogais, $consoantes);

        // Resultados de cálculos
        add_calculations_section($section, $motivacao_content, $numero_impressao, $impressao_content, $numero_expressao, $expressao_content);

        // Arcano Atual
        add_arcano_section($section, $arcanoAtual, $arcano_basicavida_options);

        // Arcanos
        add_arcanos_section($section, 'Arcanos Pessoais', $arcanos_pessoais);
        add_arcanos_section($section, 'Arcanos Sociais', $arcanos_sociais);
        add_arcanos_section($section, 'Arcanos Destino', $arcanos_destino);

        // Sequência das Pirâmides
        add_pyramid_sequence_section($section, 'Vida', $sequencia_piramide_vida);
        add_pyramid_sequence_section($section, 'Pessoal', $sequencia_piramide_pessoal);
        add_pyramid_sequence_section($section, 'Social', $sequencia_piramide_social);
        add_pyramid_sequence_section($section, 'Destino', $sequencia_piramide_destino);

        // Vocacional
        add_vocational_section($section, $vocacional);

        // Tabela Vocacional
        add_vocational_table_section($section);

        // Energias/Fases da Vida
        add_energies_life_cycles_section($section, $cores, $dias_favoraveis, $numeros_harmonicos, $momentos_decisivos);

        // Ciclos da Vida
        add_life_cycles_section($section, $ciclos);

        // Pessoal
        add_personal_section($section, $missao_content, $destino_content, $ano_pessoal_content, $mes_pessoal_content, $dia_pessoal_content, $numero_psiquico, $resultado_numero_psiquico, $grau_ascensao, $resultado_talento, $talento_oculto);

        // Desafios
        add_challenges_section($section, $desafios, $resultado_desafios);

        // Harmonia Conjugal
        add_marital_harmony_section($section, $vibra_com, $atrai, $e_oposto, $e_passivo_em_relacao_a);

        // Anjo
        add_angel_section($section, $anjo, $anjo_options);

        // Lições e Dívidas Cármicas
        add_karmic_lessons_debts_section($section, $licoes_carmicas, $licao_carmica, $dividas_carmicas, $divida_carmica);

        // Tendências Ocultas
        add_hidden_tendencies_section($section, $tendencias_ocultas, $resultado_tendencias);

        // Envia o documento gerado
        send_php_word_docx($phpWord, 'analise_mapa');
    }
}

// Funções auxiliares

function add_basic_info_section($section, $nome_completo, $data_nascimento) {
    $titleStyle = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '000000'];
    $paragraphStyle = ['name' => 'Arial', 'size' => 12, 'color' => '333333'];
    $paragraphStyleJustify = ['alignment' => Jc::BOTH];

    $section->addText("Nome Completo: $nome_completo", $titleStyle);
    $section->addTextBreak(1);
    $section->addText("Data de Nascimento: " . transformDate($data_nascimento), $paragraphStyle, $paragraphStyleJustify);
    $section->addTextBreak(1);
}

function add_signature_analysis_section($section, $letras_nome, $vogais, $consoantes) {
    $section->addText("Análise de Assinatura:", 'Heading2Style');
    $section->addTextBreak(1);

    $table = $section->addTable();
    $paragraphStyleJustify = ['alignment' => Jc::BOTH];

    $table->addRow();
    foreach ($letras_nome as $letra) {
        $table->addCell()->addText($vogais[$letra] ?? ' ', 'ParagraphStyle', $paragraphStyleJustify);
    }

    $table->addRow();
    foreach ($letras_nome as $letra) {
        $table->addCell()->addText($letra, 'ParagraphStyle', $paragraphStyleJustify);
    }

    $table->addRow();
    foreach ($letras_nome as $letra) {
        $table->addCell()->addText($consoantes[$letra] ?? ' ', 'ParagraphStyle', $paragraphStyleJustify);
    }

    $section->addTextBreak(1);
}

function add_calculations_section($section, $motivacao_content, $numero_impressao, $impressao_content, $numero_expressao, $expressao_content) {
    $paragraphStyleWithSpacing = ['align' => 'both', 'spaceAfter' => 240];

    $section->addText("Resultado dos cálculos:", 'Heading2Style');
    $section->addText($motivacao_content, 'ParagraphStyle', $paragraphStyleWithSpacing);
    $section->addText("Impressão - $numero_impressao: $impressao_content", 'ParagraphStyle', $paragraphStyleWithSpacing);
    $section->addText("Expressão - $numero_expressao: $expressao_content", 'ParagraphStyle', $paragraphStyleWithSpacing);
}

function add_arcano_section($section, $arcanoAtual, $arcano_basicavida_options) {
    $section->addText("Arcano Atual: ", 'Heading2Style');
    $dados = '';
    foreach ($arcano_basicavida_options as $arcano) {
        if ($arcano['numero_arcano_basicavida'] == $arcanoAtual['arcano']) {
            $dados = $arcano;
            break;
        }
    }

    if (!empty($dados)) {
        $section->addImage($dados['imagem_arcano'], ['width' => 150, 'height' => 225]);
        $section->addText($dados['texto_arcano_basicavida'], 'ParagraphStyle');
    } else {
        $section->addText("Arcano não encontrado.", 'ParagraphStyle');
    }
}

function add_arcanos_section($section, $titulo, $arcanos) {
    $section->addText("$titulo: ", 'Heading2Style');
    foreach ($arcanos as $arcano) {
        $section->addText("Arcano: {$arcano['arcano']} (De " . convertDate($arcano['inicio']) . " até " . convertDate($arcano['fim']) . ")", 'ParagraphStyle');
    }
}

function add_pyramid_sequence_section($section, $titulo, $sequencia) {
    $section->addText("Sequência da Pirâmide $titulo:", 'Heading2Style');
    foreach ($sequencia as $linha) {
        $section->addText(trim(preg_replace('/[^\d]/', '', $linha)), 'ParagraphStyle');
    }
}

function add_vocational_section($section, $vocacional) {
    $section->addText("Vocacional:", 'Heading2Style');
    foreach ($vocacional as $profissao => $dados) {
        $section->addText("$profissao: {$dados['contagem']} vezes, em: " . implode(', ', array_unique($dados['fontes'])), 'ParagraphStyle');
    }
}

function add_vocational_table_section($section) {
    $headers = ["Nº de destino", "Nº de Expressão Favorável", "Nº de Expressão Desfavorável", "Números Neutros"];
    $values = [
        ["1", "3, 5 e 9", "6", "1, 2, 4, 7 e 8"],
        ["2", "2, 4, 6 e 7", "5 e 9", "1, 3 e 8"],
        ["3", "1, 5 e 9", "4 e 8", "2, 3, 6 e 7"],
        ["4", "2, 6 e 7", "3 e 5", "1, 4, 8 e 9"],
        ["5", "1 e 3", "2, 4 e 6", "5, 7, 8 e 9"],
        ["6", "2, 4 e 7", "1 e 5", "3, 6, 8 e 9"],
        ["7", "2 e 4", "6 e 9", "1, 3, 5, 7 e 8"],
        ["8", "4", "3 e 7", "1, 2, 5, 6 e 9"],
        ["9", "1 e 3", "5 e 8", "2, 4, 6, 7 e 9"]
    ];

    $table = $section->addTable();
    $table->addRow();
    foreach ($headers as $header) {
        $table->addCell()->addText($header, 'ParagraphStyleBold');
    }

    foreach ($values as $value) {
        $table->addRow();
        foreach ($value as $v) {
            $table->addCell()->addText($v, 'ParagraphStyle');
        }
    }
}

function add_energies_life_cycles_section($section, $cores, $dias_favoraveis, $numeros_harmonicos, $momentos_decisivos) {
    $section->addText("Energias/Fases da vida:", 'Heading2Style');

    if (is_array($cores)) {
        $section->addText("Cores: " . implode(', ', $cores), 'ParagraphStyle');
    } else {
        $section->addText("Cores: $cores", 'ParagraphStyle');
    }

    if (is_array($dias_favoraveis)) {
        $section->addText("Dias Harmônicos: " . join(", ", $dias_favoraveis), 'ParagraphStyle');
    } else {
        $section->addText("Dias Harmônicos: $dias_favoraveis", 'ParagraphStyle');
    }

    if (is_array($numeros_harmonicos)) {
        $section->addText("Números Harmônicos: " . join(", ", $numeros_harmonicos), 'ParagraphStyle');
    } else {
        $section->addText("Números Harmônicos: $numeros_harmonicos", 'ParagraphStyle');
    }

    $section->addText("Momentos Decisivos:", 'Heading3Style');
    if (is_array($momentos_decisivos)) {
        foreach ($momentos_decisivos as $momento => $dados) {
            if (isset($dados['momentoInicial'], $dados['momentoFinal'])) {
                $section->addText("$momento: {$dados['momentoInicial']} até {$dados['momentoFinal']}", 'ParagraphStyle');
            }
        }
    } else {
        $section->addText("Momentos Decisivos: $momentos_decisivos", 'ParagraphStyle');
    }
}

function add_life_cycles_section($section, $ciclos) {
    $section->addText("Ciclos da Vida", 'Heading3Style');
    if (!empty($ciclos)) {
        foreach ($ciclos['ciclos'] as $dados_ciclo) {
            $section->addText("Número: {$dados_ciclo['numero']}, Período: {$dados_ciclo['periodo']}", 'ParagraphStyle');
        }
        foreach ($ciclos['alertas'] as $alerta) {
            $section->addText("Alerta: $alerta", 'ParagraphStyle');
        }
    }
}

function add_dia_natalicio_section($section, $dia_natalicio)
{
    $section->addText("Dia Natalicio", 'Heading3Style');
    if (!empty($dia_natalicio)) {
        foreach ($dia_natalicio as $dados_dia) {
            $section->addText($dados_dia, 'ParagraphStyle');
        }
    }
}

function add_personal_section($section, $missao_content, $destino_content, $ano_pessoal_content, $mes_pessoal_content, $dia_pessoal_content, $numero_psiquico, $resultado_numero_psiquico, $grau_ascensao, $resultado_talento, $talento_oculto) {
    $section->addText("Pessoal:", 'Heading2Style');
    $section->addText("Missão: $missao_content", 'ParagraphStyle');
    $section->addText("Destino: $destino_content", 'ParagraphStyle');
    $section->addText($ano_pessoal_content, 'ParagraphStyle');
    $section->addText($mes_pessoal_content, 'ParagraphStyle');
    $section->addText($dia_pessoal_content, 'ParagraphStyle');
    $section->addText("Número Psíquico: $numero_psiquico - " . $resultado_numero_psiquico['texto_numero_psiquico'], 'ParagraphStyle');
    $section->addText("Grau de Ascensão: $grau_ascensao", 'ParagraphStyle');
    $section->addText("Talento Oculto: $talento_oculto - " . $resultado_talento['texto_talento_oculto'], 'ParagraphStyle');
}

function add_challenges_section($section, $desafios, $resultado_desafios) {
    $section->addText("Desafios:", 'Heading2Style');
    foreach ($desafios as $desafio) {
        $section->addText("Desafio: $desafio", 'ParagraphStyle');
        foreach ($resultado_desafios as $desafio_info) {
            if ($desafio_info['numero_do_desafio'] == $desafio) {
                $section->addText($desafio_info['texto_do_desafio'], 'ParagraphStyle');
                break;
            }
        }
    }
}

function add_marital_harmony_section($section, $vibra_com, $atrai, $e_oposto, $e_passivo_em_relacao_a)
{
    $section->addText("Harmonia Conjugal:", 'Heading2Style');
    $section->addText("Vibra com: $vibra_com", 'ParagraphStyle');
    $section->addText("Atrai: $atrai", 'ParagraphStyle');
    $section->addText("É oposto a: $e_oposto", 'ParagraphStyle');
    $section->addText("É passivo em relação a: $e_passivo_em_relacao_a", 'ParagraphStyle');
}

function add_angel_section($section, $anjo, $anjo_options) {
    $section->addText("Anjo:", 'Heading2Style');

    if (!empty($anjo)) {
        $section->addText("Número do Anjo: " . $anjo['numero'], 'ParagraphStyle');

        foreach ($anjo_options as $anj) {
            if ($anj['numero_anjo'] == $anjo['numero']) {
                // Adiciona o texto do anjo
                $section->addText("Texto do Anjo: " . $anj['texto_anjo'], 'ParagraphStyle');

                // Adiciona o nome do anjo
                $section->addText("Nome do Anjo: " . $anj['nome_anjo'], 'ParagraphStyle');

                // Adiciona o número do anjo
                $section->addText("Número do Anjo: " . $anj['numero_anjo'], 'ParagraphStyle');

                // Adiciona o salmo do anjo
                $section->addText("Salmo do Anjo: " . $anj['salmo_anjo'], 'ParagraphStyle');

                // Adiciona a vela do anjo
                $section->addText("Vela do Anjo: " . $anj['vela_anjo'], 'ParagraphStyle');

                // Adiciona o incenso do anjo
                $section->addText("Incenso do Anjo: " . $anj['incenso_anjo'], 'ParagraphStyle');

                // Adiciona o cristal do anjo
                $section->addText("Cristal do Anjo: " . $anj['cristal_anjo'], 'ParagraphStyle');

                // Adiciona a categoria do anjo
                $section->addText("Categoria do Anjo: " . $anj['categoria_anjo'], 'ParagraphStyle');

                // Adiciona o horário de preces do anjo
                $section->addText("Horário de Preces: " . $anj['horario_preces'], 'ParagraphStyle');

                break; // Encerra o loop após encontrar o anjo correspondente
            }
        }
    } else {
        $section->addText("Anjo não encontrado.", 'ParagraphStyle');
    }
}


function add_karmic_lessons_debts_section($section, $licoes_carmicas, $licao_carmica, $dividas_carmicas, $divida_carmica) {
    $section->addText("Lições e Dívidas Cármicas:", 'Heading2Style');

    $section->addText("Lições Cármicas:", 'Heading3Style');
    if (!empty($licoes_carmicas)) {
        foreach ($licoes_carmicas as $licao) {
            $section->addText("Número: $licao", 'ParagraphStyle');
        }
        if (!empty($licao_carmica)) {
            $section->addText($licao_carmica['texto_licao_carmica'], 'ParagraphStyle');
        }
    } else {
        $section->addText("Nenhuma lição cármica encontrada.", 'ParagraphStyle');
    }

    $section->addText("Dívidas Cármicas:", 'Heading3Style');
    if (!empty($dividas_carmicas)) {
        foreach ($dividas_carmicas as $divida) {
            $section->addText("Número: $divida", 'ParagraphStyle');
        }
        if (!empty($divida_carmica)) {
            $section->addText($divida_carmica['texto_divida_carmica'], 'ParagraphStyle');
        }
    } else {
        $section->addText("Nenhuma dívida cármica encontrada.", 'ParagraphStyle');
    }
}

function add_hidden_tendencies_section($section, $tendencias_ocultas, $resultado_tendencias) {
    $section->addText("Tendências Ocultas:", 'Heading2Style');
    if (!empty($tendencias_ocultas)) {
        foreach ($tendencias_ocultas as $tendencia) {
            $section->addText("Tendência: $tendencia", 'ParagraphStyle');
        }
        foreach ($resultado_tendencias as $tendencia) {
            $section->addText($tendencia['texto_tendencia_oculta'], 'ParagraphStyle');
        }
    } else {
        $section->addText("Nenhuma tendência oculta encontrada.", 'ParagraphStyle');
    }
}

add_action('template_redirect', 'gerar_docx_com_infos');