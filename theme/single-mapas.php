<?php

/**
 * The template for displaying single Mapas posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package numera_theme
 */

//  Inclui os dados necessários para o template
include_once __DIR__ . "/inc/template-single-mapa-functions.php";
include_once __DIR__ . "/inc/template-modals.php";

get_header();
?>

    <div class="container mx-auto p-4 max-w-[1400px]">
        <?php
        while (have_posts()) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header mb-4">
                <h1 class="entry-title text-2xl font-bold"><?php the_title(); ?></h1>
            </header>
            <div class="entry-content">
                <form id="edit-map-form" class="space-y-6">
                    <div class="flex gap-4">
                        <div style="width: 75%;" class="mb-4">
                            <input type="hidden" name="post_id" value="<?php echo get_the_ID() ?>">
                            <label for="nome_completo" class="block text-sm font-medium text-gray-700">Nome
                                Completo</label>
                            <input type="text" id="nome_completo" name="nome_completo"
                                   value="<?php echo esc_attr($nome_completo); ?>"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div style="width: 25%;" class="mb-4">
                            <label for="data_nascimento" class="block text-sm font-medium text-gray-700">Data de
                                Nascimento</label>
                            <input type="date" id="data_nascimento" name="data_nascimento"
                                   value="<?php echo transformDate($data_nascimento) ?>"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <button type="submit"
                                class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none">
                            Salvar Alterações
                        </button>
                        <a href="<?php echo add_query_arg('download_docx', '1') ?>"
                           class="w-[200px] bg-green-600 text-white text-center py-2 px-4 rounded-md hover:bg-green-700">Gerar Mapa
                        </a>
                    </div>
                </form>

                <!-- Tabs Layout -->
                <div class="mb-4 border-b border-gray-200">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 justify-center">
                        <li class="mr-2">
                            <button data-tab="tab1"
                                    class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300">
                                Análise de Assinatura
                            </button>
                        </li>
                        <li class="mr-2">
                            <button data-tab="tab2"
                                    class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300">
                                Geral
                            </button>
                        </li>
                        <li class="mr-2">
                            <button data-tab="tab3"
                                    class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300">
                                Energias / Fases da vida
                            </button>
                        </li>
                        <li class="mr-2">
                            <button data-tab="tab4"
                                    class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300">
                                Arcanos
                            </button>
                        </li>
                        <li class="mr-2">
                            <button data-tab="tab5"
                                    class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300">
                                Pirâmides
                            </button>
                        </li>
                        <li class="mr-2">
                            <button data-tab="tab6"
                                    class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300">
                                Vocacional
                            </button>
                        </li>
                    </ul>
                </div>

                <div id="tabs-content">
                    <!-- Tab 1 Content -->
                    <div data-tab-content="tab1" class="p-4">
                        <div class="mb-6">
                            <div class="text-center space-y-6 border border-gray-300 rounded-2xl bg-white p-6 shadow-sm mt-4"
                                 id="numerologia-results">
                                <h2 class="text-2xl font-semibold text-gray-900">Análise de Assinatura</h2>

                                <!-- Exibir números de consoantes (expressões) abaixo das letras -->
                                <div class="flex justify-center flex-wrap gap-2" id="consoantes-result">
                                    <span id="consoantes" class="hidden"><?php echo json_encode($consoantes); ?></span>
                                    <?php foreach ($letras_nome as $letra): ?>
                                        <div class="flex flex-col items-center w-8">
                                            <?php if (ctype_alpha($letra) || is_numeric($letra) && trim($letra) !== ' '): ?>
                                                <div class="bg-green-500 text-white rounded-lg shadow-md w-8 h-8 flex items-center justify-center">
                                                    <?php echo isset($consoantes[$letra]) ? $consoantes[$letra] : ' '; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="w-8 h-8"></div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Exibir letras do nome completo no meio -->
                                <div class="flex justify-center flex-wrap gap-2" id="letras-result">
                                    <?php foreach ($letras_nome as $letra): ?>
                                        <div class="flex flex-col items-center w-8">
                                            <div class="text-gray-900 font-medium">
                                                <?php echo esc_html($letra); ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Exibir números de vogais (motivações) acima das letras -->
                                <div class="flex justify-center flex-wrap gap-2" id="vogais-result">
                                    <span id="vogais" class="hidden"><?php echo json_encode($vogais); ?></span>
                                    <?php foreach ($letras_nome as $letra): ?>
                                        <div class="flex flex-col items-center w-8">
                                            <?php if (ctype_alpha($letra) || is_numeric($letra) && trim($letra) !== ' '): ?>
                                                <div class="bg-blue-500 text-white rounded-lg shadow-md w-8 h-8 flex items-center justify-center">
                                                    <?php echo isset($vogais[$letra]) ? $vogais[$letra] : ' '; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="w-8 h-8"></div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Exibir números de expressão (alfabeto) -->
                                <div class="flex justify-center flex-wrap gap-2" id="all-vl-result">
                                    <span id="alfabeto" class="hidden"><?php echo json_encode($alfabeto); ?></span>
                                    <?php foreach ($letras_nome as $letra): ?>
                                        <div class="flex flex-col items-center w-8">
                                            <?php if (ctype_alpha($letra) || is_numeric($letra) && trim($letra) !== ' '): ?>
                                                <div class="bg-purple-500 text-white rounded-lg shadow-md w-8 h-8 flex items-center justify-center">
                                                    <?php echo isset($alfabeto[$letra]) ? $alfabeto[$letra] : ' '; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="w-8 h-8"></div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Legendas -->
                                <div class="flex flex-wrap gap-6 justify-center py-6">
                                    <?php
                                    $legendas = [
                                        'Impressão' => 'bg-green-500',
                                        'Motivação' => 'bg-blue-500',
                                        'Expressão' => 'bg-purple-500',
                                        'Somatória das partes (Motivação)' => 'bg-yellow-500',
                                        'Somatória das partes (Expressão)' => 'bg-red-500',
                                    ];
                                    ?>
                                    <?php foreach ($legendas as $legenda => $cor): ?>
                                        <div class="flex items-center gap-2">
                                            <span class="block w-4 h-4 <?php echo esc_html($cor); ?> rounded-full shadow"></span>
                                            <p class="text-gray-600"><?php echo esc_html($legenda); ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-8 rounded-2xl shadow-lg mb-8 border border-gray-300">
                            <h3 class="text-2xl font-semibold mb-6 text-gray-900">Resultados dos Cálculos</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                <!-- Resultado de Motivação -->
                                <div class="border border-green-300 rounded-2xl p-6 bg-white shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <span id="resultado-motivacao"
                                              class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium">
                                            <?php echo $numero_motivacao ?>
                                        </span>
                                        <span class="text-lg font-medium text-gray-800">Motivação</span>
                                    </div>
                                    <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                       data-modal="modal-motivacao">Ver detalhes</a>
                                </div>
                                <?php render_modal('modal-motivacao', $numero_motivacao, $motivacao_content); ?>
                                <!-- Resultado de Impressão -->
                                <div class="border border-green-300 rounded-2xl p-6 bg-white shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <span id="resultado-impressao"
                                              class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium">
                                            <?php echo $numero_impressao ?>
                                        </span>
                                        <span class="text-lg font-medium text-gray-800">Impressão</span>
                                    </div>
                                    <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                       data-modal="modal-impressao">Ver detalhes</a>
                                </div>
                                <?php render_modal('modal-impressao', $numero_impressao, $impressao_content, $impressao_orientacao); ?>
                                <!-- Resultado de Expressão -->
                                <div class="border border-green-300 rounded-2xl p-6 bg-white shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <span id="resultado-expressao"
                                              class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium">
                                            <?php echo $numero_expressao ?>
                                        </span>
                                        <span class="text-lg font-medium text-gray-800">Expressão</span>
                                    </div>
                                    <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                       data-modal="modal-expressao">Ver detalhes</a>
                                </div>
                                <?php render_modal('modal-expressao', $numero_expressao, $expressao_content, $expressao_orientacao); ?>
                                <!-- Resultado de Arcano -->
                                <div class="border border-green-300 rounded-2xl p-6 bg-white shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <span id="resultado-arcano"
                                              class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium">
                                            <?php echo $arcanoAtual['arcano'] ?>
                                        </span>
                                        <span class="text-lg font-medium text-gray-800">Arcano</span>
                                    </div>
                                    <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                       data-modal="modal-arcano">Ver detalhes</a>
                                </div>
                                <!-- Modal Arcano -->
                                <div id="modal-arcano"
                                     class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                                    <div class="bg-white p-8 rounded-2xl shadow-lg max-w-4xl w-full">
                                        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Seu arcano atual é
                                            o <?php echo esc_html($arcanoAtual['arcano']); ?></h2>
                                        <div class="flex gap-6 items-center">
                                            <?php
                                            $dados = [];
                                            foreach ($arcano_basicavida_options as $arcano) {
                                                if ($arcano['numero_arcano_basicavida'] == $arcanoAtual['arcano']) {
                                                    $dados = $arcano;
                                                }
                                            }
                                            ?>
                                            <!-- Imagem -->
                                            <img src="<?php echo esc_url($dados['imagem_arcano']); ?>"
                                                 alt="Imagem Arcano" class="w-1/3 rounded-lg shadow-md">
                                            <!-- Texto -->
                                            <p class="text-gray-700 leading-relaxed"><?php echo esc_html($dados['texto_arcano_basicavida']); ?></p>
                                        </div>
                                        <div class="flex justify-end gap-4 mt-6">
                                            <button class="closeModal py-2 px-4 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                                Fechar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-6 mt-6">
                                <!-- Bloco Harmonia Conjugal -->
                                <div class="bg-gray-50 rounded-2xl">
                                    <div class="flex items-center mb-6">
                                        <h2 class="text-2xl font-semibold text-gray-800">Harmonia Conjugal</h2>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
                                        <!-- Vibra Com -->
                                        <div class="border border-green-300 rounded-lg p-4 bg-white shadow-sm">
                                            <div class="flex items-center">
                                                <span class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                    <?php echo $vibra_com ?>
                                                </span>
                                                <h3 class="font-semibold text-gray-800">Vibra Com</h3>
                                            </div>
                                        </div>

                                        <!-- Atrai -->
                                        <div class="border border-green-300 rounded-lg p-4 bg-white shadow-sm">
                                            <div class="flex items-center">
                                                <span class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                    <?php echo $atrai ?>
                                                </span>
                                                <h3 class="font-semibold text-gray-800">Atrai</h3>
                                            </div>
                                        </div>

                                        <!-- É Oposto -->
                                        <div class="border border-green-300 rounded-lg p-4 bg-white shadow-sm">
                                            <div class="flex items-center">
                                                <span class="bg-purple-50 border border-purple-300 rounded-lg px-4 py-2 text-purple-700 font-medium mr-4">
                                                    <?php echo $e_oposto ?>
                                                </span>
                                                <h3 class="font-semibold text-gray-800">É Oposto</h3>
                                            </div>
                                        </div>

                                        <!-- É Passivo -->
                                        <div class="border border-green-300 rounded-lg p-4 bg-white shadow-sm">
                                            <div class="flex items-center">
                                                <span class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                    <?php echo $e_passivo_em_relacao_a ?>
                                                </span>
                                                <h3 class="font-semibold text-gray-800">É Passivo em relação a</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bloco Numeros Harmônicos -->
                                <div class="bg-gray-50 rounded-2xl">
                                    <div class="flex flex-col gap-4">
                                        <h3 class="text-2xl font-semibold text-gray-800">Números Harmônicos</h3>
                                        <div class="flex flex-wrap gap-2">
                                            <?php foreach ($numeros_harmonicos as $num): ?>
                                                <span id="resultado-numeros-harmonicos"
                                                      class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium">
                                                    <?php echo $num ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                        <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                           data-modal="modal-numeros-harmonicos">Ver detalhes</a>
                                        <?php render_modal('modal-numeros-harmonicos', "Números Harmônicos", "Conteúdo temporário"); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 2 Content -->
                    <div data-tab-content="tab2" class="p-4 hidden">
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Bloco Pessoal -->
                                <div class="bg-gray-50 border border-yellow-300 rounded-2xl p-6 shadow-md">
                                    <div class="flex items-center mb-6">
                                        <h2 class="text-2xl font-semibold text-gray-800">Pessoal</h2>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                        <!-- Missão -->
                                        <div class="border border-green-300 rounded-lg p-4 bg-white shadow-sm">
                                            <div class="flex items-center">
                                                <span id="resultado-missao"
                                                      class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                    <?php echo $numero_missao ?>
                                                </span>
                                                <h3 class="font-semibold text-gray-800">Missão</h3>
                                            </div>
                                            <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                               data-modal="modal-missao">Ver detalhes</a>
                                        </div>
                                        <?php render_modal('modal-missao', "Número $numero_missao", $missao_content); ?>

                                        <!-- Destino -->
                                        <div class="border border-green-300 rounded-lg p-4 bg-white shadow-sm">
                                            <div class="flex items-center">
                                                <span id="resultado-destino"
                                                      class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                    <?php echo $numero_destino ?>
                                                </span>
                                                <h3 class="font-semibold text-gray-800">Destino</h3>
                                            </div>
                                            <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                               data-modal="modal-destino">Ver detalhes</a>
                                        </div>
                                        <?php render_modal('modal-destino', "Número $numero_destino", $destino_content); ?>

                                        <!-- Ano Pessoal -->
                                        <div class="border border-green-300 rounded-lg p-4 bg-white shadow-sm">
                                            <div class="flex items-center">
                                                <span id="resultado-ano-pessoal"
                                                      class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                    <?php echo $ano_pessoal ?>
                                                </span>
                                                <h3 class="font-semibold text-gray-800">Ano Pessoal</h3>
                                            </div>
                                            <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                               data-modal="modal-ano-pessoal">Ver detalhes</a>
                                        </div>
                                        <?php render_modal('modal-ano-pessoal', "Número $ano_pessoal", $ano_pessoal_content); ?>

                                        <!-- Mês Pessoal -->
                                        <div class="border border-green-300 rounded-lg p-4 bg-white shadow-sm">
                                            <div class="flex items-center">
                                                <span id="resultado-mes-pessoal"
                                                      class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                    <?php echo $mes_pessoal ?>
                                                </span>
                                                <h3 class="font-semibold text-gray-800">Mês Pessoal</h3>
                                            </div>
                                            <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                               data-modal="modal-mes-pessoal">Ver detalhes</a>
                                        </div>
                                        <?php render_modal('modal-mes-pessoal', "Número $mes_pessoal", $mes_pessoal_content); ?>

                                        <!-- Dia Pessoal -->
                                        <div class="border border-green-300 rounded-lg p-4 bg-white shadow-sm">
                                            <div class="flex items-center">
                                                <span id="resultado-dia-pessoal"
                                                      class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                    <?php echo $dia_pessoal ?>
                                                </span>
                                                <h3 class="font-semibold text-gray-800">Dia Pessoal</h3>
                                            </div>
                                            <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                               data-modal="modal-dia-pessoal">Ver detalhes</a>
                                        </div>
                                        <?php render_modal('modal-dia-pessoal', "Número $dia_pessoal", $dia_pessoal_content); ?>

                                        <!-- Anjo -->
                                        <div class="border border-green-300 rounded-lg p-4 bg-white shadow-sm">
                                            <div class="flex items-center">
                                                <span id="resultado-anjo"
                                                      class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                    <?php echo esc_html($anjo['numero']); ?>
                                                </span>
                                                <h3 class="font-semibold text-gray-800">Anjo</h3>
                                            </div>
                                            <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                               data-modal="modal-anjo">Ver detalhes</a>
                                        </div>
                                        <?php foreach ($anjo_options as $anjo_option): ?>
                                            <?php $anjo_ = []; ?>
                                            <?php if ($anjo_option['numero_anjo'] == $anjo['numero']): ?>
                                                <?php render_modal_anjo('modal-anjo', "Número {$anjo['numero']}", $anjo_option['texto_anjo'], $anjo_option['nome_anjo'], $anjo_option['numero_anjo'], $anjo_option['salmo_anjo'], $anjo_option['vela_anjo'], $anjo_option['incenso_anjo'], $anjo_option['cristal_anjo'], $anjo_option['categoria_anjo'], $anjo_option['horario_preces']); ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <!-- Bloco Carmas -->
                                <div class="bg-gray-50 border border-yellow-300 rounded-2xl p-6 shadow-md">
                                    <div class="flex items-center mb-6">
                                        <h2 class="text-2xl font-semibold text-gray-800">Carmas</h2>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
                                        <!-- Lições Cármicas -->
                                        <div class="border border-green-300 rounded-lg p-4 bg-white shadow-sm">
                                            <div class="flex items-center">
                                                <span id="resultado-licoes-carmicas"
                                                      class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                    <?php echo esc_html($licao_carmica['numero_licao_carmica']) ?>
                                                </span>
                                                <h3 class="font-semibold text-gray-800">Lições Cármicas</h3>
                                            </div>
                                            <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                               data-modal="modal-licoes-carmicas">Ver detalhes</a>
                                            <?php render_modal('modal-licoes-carmicas', $licao_carmica['numero_licao_carmica'], $licao_carmica['texto_licao_carmica']); ?>
                                        </div>

                                        <!-- Dívidas Cármicas -->
                                        <div class="border border-green-300 rounded-lg p-4 bg-white shadow-sm">
                                            <div class="flex items-center">
                                                <span id="resultado-dividas-carmicas"
                                                      class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                    <?php echo esc_html($divida_carmica['numero_divida_carmica']); ?>
                                                </span>
                                                <h3 class="font-semibold text-gray-800">Dívidas Cármicas</h3>
                                            </div>
                                            <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                               data-modal="modal-dividas-carmicas">Ver detalhes</a>
                                            <?php render_modal('modal-dividas-carmicas', $divida_carmica['numero_divida_carmica'], $divida_carmica['texto_divida_carmica']); ?>
                                        </div>

                                        <!-- Tendências Ocultas -->
                                        <div class="border border-green-300 rounded-lg p-4 bg-white shadow-sm w-full">
                                            <h3 class="font-semibold text-gray-800 mb-4">Tendências Ocultas</h3>
                                            <div class="flex items-center">
                                                <?php foreach ($resultado_tendencias as $tendencia): ?>
                                                    <span id="resultado-tendencias-ocultas"
                                                          class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                        <?php echo $tendencia['numero_tendencia_oculta'] ?>
                                                    </span>
                                                <?php endforeach; ?>
                                            </div>
                                            <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                               data-modal="modal-tendencias-ocultas">Ver detalhes</a>
                                            <?php render_modal_with_columns('modal-tendencias-ocultas', "Tendências Ocultas", $resultado_tendencias); ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- Bloco Desafios -->
                                <div class="bg-gray-50 border border-yellow-300 rounded-2xl p-6 shadow-md">
                                    <div class="flex items-center mb-6">
                                        <h2 class="text-2xl font-semibold text-gray-800">Desafios</h2>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                        <?php
                                        $nomes_desafios = ["Primeiro", "Segundo", "Terceiro"];
                                        $contador = 0;

                                        foreach ($resultado_desafios as $desafio): ?>
                                            <div class="border border-green-300 rounded-lg p-4 bg-white shadow-sm">
                                                <div class="flex items-center">
                                                    <span class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                        <?php echo esc_html($desafio['numero_do_desafio']); ?>
                                                    </span>
                                                    <h3 class="font-semibold text-gray-800">
                                                        <?php echo esc_html($nomes_desafios[$contador]); ?> Desafio
                                                    </h3>
                                                </div>
                                                <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                                   data-modal="modal-<?php echo strtolower($nomes_desafios[$contador]); ?>-desafio">
                                                    Ver detalhes
                                                </a>
                                                <?php render_modal("modal-" . strtolower($nomes_desafios[$contador]) . "-desafio", "{$nomes_desafios[$contador]} Desafio", $desafio["texto_desafio"]); ?>
                                            </div>
                                            <?php
                                            $contador++;
                                        endforeach; ?>
                                    </div>
                                </div>
                                <!-- Bloco Grau Ascenção -->
                                <div class="bg-gray-50 border border-yellow-300 rounded-2xl p-6 shadow-md">
                                    <div class="flex items-center mb-6">
                                        <h2 class="text-2xl font-semibold text-gray-800">Grau Ascenção</h2>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                        <!-- Espírito em Ascenção -->
                                        <div class="border border-green-300 rounded-lg p-4 bg-white shadow-sm">
                                            <div class="flex items-center">
                                                <h3 class="font-semibold text-gray-800"><?php echo $grau_ascensao ?></h3>
                                            </div>
                                            <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                               data-modal="modal-grau-ascencao">Ver detalhes</a>
                                            <?php render_modal('modal-grau-ascencao', "Grau de Ascenção", "Conteúdo temporário"); ?>
                                        </div>

                                        <!-- Talento Oculto -->
                                        <div class="border border-green-300 rounded-lg p-4 bg-white shadow-sm">
                                            <div class="flex items-center">
                                                <span class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                    <?php
                                                    echo $resultado_talento['numero_talento_oculto'] ?>
                                                </span>
                                                <h3 class="font-semibold text-gray-800">Talento Oculto</h3>
                                            </div>
                                            <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                               data-modal="modal-talento-oculto">Ver detalhes</a>
                                            <?php render_modal('modal-talento-oculto', "Talento Oculto", $resultado_talento['texto_talento_oculto']); ?>
                                        </div>

                                        <!-- Número Psíquico -->
                                        <div class="border border-green-300 rounded-lg p-4 bg-white shadow-sm">
                                            <div class="flex items-center">
                                                <span class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                    <?php echo $resultado_numero_psiquico['numero_psiquico'] ?>
                                                </span>
                                                <h3 class="font-semibold text-gray-800">Número Psíquico</h3>
                                            </div>
                                            <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                               data-modal="modal-numero-psiquico">Ver detalhes</a>
                                            <?php render_modal('modal-numero-psiquico', "Número Psíquico", $resultado_numero_psiquico['texto_numero_psiquico']); ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Tab 3 Content -->
                    <div data-tab-content="tab3" class="p-4 hidden">
                        <div class="space-y-4">
                            <h2 class="text-xl font-semibold">Energias</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="bg-gray-50 border border-yellow-300 rounded-2xl p-6 shadow-sm">
                                    <div class="flex flex-col gap-4">
                                        <h3 class="text-2xl font-semibold text-gray-800">Cores</h3>
                                        <div class="flex items-center">
                                            <span id="resultado-cores"
                                                  class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                <?php echo $cores ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bloco Dias Harmonicos -->
                                <div class="bg-gray-50 border border-yellow-300 rounded-2xl p-6 shadow-sm">
                                    <div class="flex flex-col gap-4">
                                        <h3 class="text-2xl font-semibold text-gray-800">Dias Harmônicos</h3>
                                        <div class="flex flex-wrap gap-2">
                                            <?php foreach ($dias_favoraveis as $dia): ?>
                                                <span id="resultado-dias-harmonicos"
                                                      class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium">
                                                    <?php echo $dia ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                        <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                           data-modal="modal-dias-modernos">Ver detalhes</a>
                                        <?php render_modal('modal-dias-modernos', "Dias Harmônicos", "Conteúdo temporário"); ?>
                                    </div>
                                </div>

                                <div class="bg-gray-50 border border-yellow-300 rounded-2xl p-6 shadow-sm">
                                    <div class="flex flex-col gap-4">
                                        <h3 class="text-2xl font-semibold text-gray-800">Resposta Subconsciente</h3>
                                        <div class="flex flex-wrap gap-2">
                                            <span id="resultado-numeros-harmonicos"
                                                  class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium">
                                                <?php echo $resposta_subconsciente ?>
                                            </span>
                                        </div>
                                        <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                           data-modal="modal-resposta-subconsciente">Ver detalhes</a>
                                        <?php render_modal('modal-resposta-subconsciente', "Resposta Subsconsciente", "Conteúdo temporário"); ?>
                                    </div>
                                </div>

                                <!-- Bloco ciclos de vida -->
                                <div class="bg-gray-50 border border-yellow-300 rounded-2xl p-6 shadow-sm">
                                    <div class="flex flex-col gap-4">
                                        <h3 class="text-2xl font-semibold text-gray-800">Ciclos da Vida</h3>
                                        <div class="space-y-4">
                                            <?php if (!empty($ciclos)): ?>
                                                <!-- Exibir ciclos -->
                                                <?php foreach ($ciclos['ciclos'] as $nome_ciclo => $dados_ciclo): ?>
                                                    <p class="text-gray-800">
                                                        <strong>Número:</strong> <?php echo $dados_ciclo['numero'] ?>,
                                                        <strong>Período:</strong> <?php echo $dados_ciclo['periodo'] ?>
                                                    </p>
                                                <?php endforeach; ?>

                                                <!-- Exibir alertas -->
                                                <?php if (!empty($ciclos['alertas'])): ?>
                                                    <?php foreach ($ciclos['alertas'] as $alerta): ?>
                                                        <?php var_dump($alerta); ?>
                                                        <p class="text-red-600"><?php echo $alerta ?></p>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <p class="text-gray-600">Nenhum ciclo encontrado.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 border border-yellow-300 rounded-2xl p-6 shadow-sm">
                                    <div class="flex flex-col gap-4">
                                        <h3 class="text-2xl font-semibold text-gray-800">Relações Intervalores</h3>
                                        <div class="flex flex-wrap gap-2">
                                            <span id="resultado-numeros-harmonicos"
                                                  class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium">
                                                <?php echo $relacoes_intervalores ?>
                                            </span>
                                        </div>
                                        <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                           data-modal="modal-relacoes-intervalores">Ver detalhes</a>
                                        <?php render_modal('modal-relacoes-intervalores', "Relações Intervalores", "Conteúdo temporário"); ?>
                                    </div>
                                </div>

                                <!-- Bloco Decisivos -->
                                <div class="bg-gray-50 border border-yellow-300 rounded-2xl p-6 shadow-sm">
                                    <div class="flex flex-col gap-4">
                                        <h3 class="text-2xl font-semibold text-gray-800">Momentos Decisivos</h3>
                                        <div class="space-y-2">
                                            <div class="flex items-center">
                                                <span class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                    <?php echo $momentos_decisivos['primeiroMomento'] ?>
                                                </span>
                                                <span class="text-gray-800">
                                                    <?php echo $momentos_decisivos['momentoInicial1'] . ' até ' . $momentos_decisivos['momentoFinal1'] ?>
                                                </span>
                                            </div>
                                            <div class="flex items-center">
                                                <span class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                    <?php echo $momentos_decisivos['segundoMomento'] ?>
                                                </span>
                                                <span class="text-gray-800">
                                                    <?php echo $momentos_decisivos['momentoInicial2'] . ' até ' . $momentos_decisivos['momentoFinal2'] ?>
                                                </span>
                                            </div>
                                            <div class="flex items-center">
                                                <span class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                    <?php echo $momentos_decisivos['terceiroMomento'] ?>
                                                </span>
                                                <span class="text-gray-800">
                                                    <?php echo $momentos_decisivos['momentoInicial3'] . ' até ' . $momentos_decisivos['momentoFinal3'] ?>
                                                </span>
                                            </div>
                                            <div class="flex items-center">
                                                <span class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                    <?php echo $momentos_decisivos['quartoMomento'] ?>
                                                </span>
                                                <span class="text-gray-800">
                                                    <?php echo $momentos_decisivos['momentoInicial4'] . ' até ' . $momentos_decisivos['momentoFinal4'] ?>
                                                </span>
                                            </div>
                                        </div>
                                        <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                           data-modal="modal-momentos-decisivos">Ver detalhes</a>
                                        <?php render_modal('modal-momentos-decisivos', "Momentos Decisivos", "Conteúdo temporário"); ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Tab 4 Content -->
                    <div data-tab-content="tab4" class="p-4 hidden">
                        <div class="tab-menu mb-6 flex justify-center space-x-4">
                            <button
                                    class="tab-link px-6 py-2 text-sm font-medium rounded-full bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring focus:ring-blue-300"
                                    onclick="openArcano(event, 'arcanoVida')">
                                Vida
                            </button>
                            <button
                                    class="tab-link px-6 py-2 text-sm font-medium rounded-full bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring focus:ring-blue-300"
                                    onclick="openArcano(event, 'arcanoTalento')">
                                Pessoal
                            </button>
                            <button
                                    class="tab-link px-6 py-2 text-sm font-medium rounded-full bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring focus:ring-blue-300"
                                    onclick="openArcano(event, 'arcanoAscensao')">
                                Social
                            </button>
                            <button
                                    class="tab-link px-6 py-2 text-sm font-medium rounded-full bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring focus:ring-blue-300"
                                    onclick="openArcano(event, 'arcanoOculta')">
                                Destino
                            </button>
                        </div>


                        <div id="arcanoVida" class="arcano-container bg-gray-50 rounded-2xl p-6 shadow-md">
                            <h2 class="text-xl font-semibold my-4 my-4">Arcanos (vida)</h2>
                            <div class="flex flex-wrap gap-4 justify-between">
                                <?php foreach ($arcanos as $key => $arcano): ?>
                                    <?php
                                    // Obtém a data atual no formato 'd/m/Y'
                                    $date = current_datetime()->format('d/m/Y');

                                    // Converte as datas de início e fim de 'd-m-Y' para 'd/m/Y'
                                    $dataInicio = DateTime::createFromFormat('d-m-Y', $arcano['inicio']);
                                    $dataFim = DateTime::createFromFormat('d-m-Y', $arcano['fim']);

                                    // Converte a data atual para DateTime para comparação
                                    $dataAtual = DateTime::createFromFormat('d/m/Y', $date);

                                    // Verifica se a data atual está entre a data de início e de fim
                                    $isCurrent = ($dataAtual >= $dataInicio && $dataAtual <= $dataFim);
                                    ?>
                                    <div class="border border-green-300 rounded-lg p-4 w-[18%] <?php echo $isCurrent ? 'bg-green-500 text-white' : 'bg-white'; ?> shadow-sm">
                                        <span class="border rounded-full px-4 py-2 font-medium <?php echo $isCurrent ? 'border-white' : 'border-orange-300 text-orange-700'; ?>">
                                            <?php echo $arcano['arcano']; ?>
                                        </span>
                                        <p class="mt-4 text-sm <?php echo $isCurrent ? 'text-white' : 'text-gray-800'; ?>">
                                            De <?php echo convertDate($arcano['inicio']); ?>
                                            até <?php echo convertDate($arcano['fim']); ?>
                                        </p>
                                        <p class="text-sm <?php echo $isCurrent ? 'text-white' : 'text-gray-800'; ?>">
                                            <?php echo $arcano['idadeInicio']; ?> a <?php echo $arcano['idadeFim']; ?>
                                        </p>
                                        <div class="flex justify-end">
                                            <a class="text-sm underline <?php echo $isCurrent ? 'text-white' : 'text-blue-600 hover:text-blue-800'; ?>"
                                               href="#" data-modal="<?php echo "modal-arcano-vida-$key" ?>">Ver
                                                detalhes...</a>
                                            <?php render_arcano_modal("modal-arcano-vida-$key", $arcano_basicavida_options, $arcano); ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div id="arcanoTalento" class="arcano-container bg-gray-50 rounded-2xl p-6 shadow-md"
                             style="display:none;">
                            <h2 class="text-xl font-semibold my-4">Arcanos (pessoal)</h2>
                            <div class="flex flex-wrap gap-4 justify-between">
                                <?php foreach ($arcanos_pessoais as $key => $arcano): ?>
                                    <?php
                                    // Obtém a data atual no formato 'd/m/Y'
                                    $date = current_datetime()->format('d/m/Y');

                                    // Converte as datas de início e fim de 'd-m-Y' para 'd/m/Y'
                                    $dataInicio = DateTime::createFromFormat('d-m-Y', $arcano['inicio']);
                                    $dataFim = DateTime::createFromFormat('d-m-Y', $arcano['fim']);

                                    // Converte a data atual para DateTime para comparação
                                    $dataAtual = DateTime::createFromFormat('d/m/Y', $date);

                                    // Verifica se a data atual está entre a data de início e de fim
                                    $isCurrent = ($dataAtual >= $dataInicio && $dataAtual <= $dataFim);
                                    ?>

                                    <div class="border border-green-300 rounded-lg p-4 w-[18%] <?php echo $isCurrent ? 'bg-green-500 text-white' : 'bg-white'; ?> shadow-sm">
                                        <span class="border rounded-full px-4 py-2 font-medium <?php echo $isCurrent ? 'border-white' : 'border-orange-300 text-orange-700'; ?>">
                                            <?php echo $arcano['arcano']; ?>
                                        </span>
                                        <p class="mt-4 text-sm <?php echo $isCurrent ? 'text-white' : 'text-gray-800'; ?>">
                                            De <?php echo convertDate($arcano['inicio']); ?>
                                            até <?php echo convertDate($arcano['fim']); ?>
                                        </p>
                                        <p class="text-sm <?php echo $isCurrent ? 'text-white' : 'text-gray-800'; ?>">
                                            <?php echo $arcano['idadeInicio']; ?> a <?php echo $arcano['idadeFim']; ?>
                                        </p>
                                        <div class="flex justify-end">
                                            <a class="text-sm underline <?php echo $isCurrent ? 'text-white' : 'text-blue-600 hover:text-blue-800'; ?>"
                                               href="#" data-modal="<?php echo "modal-arcano-pessoal-$key" ?>">Ver
                                                detalhes</a>
                                            <?php render_arcano_modal("modal-arcano-pessoal-$key", $arcano_basicavida_options, $arcano); ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div id="arcanoAscensao" class="arcano-container bg-gray-50 rounded-2xl p-6 shadow-md"
                             style="display:none;">
                            <h2 class="text-xl font-semibold my-4">Arcanos (social)</h2>
                            <div class="flex flex-wrap gap-4 justify-between">
                                <?php foreach ($arcanos_sociais as $key => $arcano): ?>
                                    <?php
                                    // Obtém a data atual no formato 'd/m/Y'
                                    $date = current_datetime()->format('d/m/Y');

                                    // Converte as datas de início e fim de 'd-m-Y' para 'd/m/Y'
                                    $dataInicio = DateTime::createFromFormat('d-m-Y', $arcano['inicio']);
                                    $dataFim = DateTime::createFromFormat('d-m-Y', $arcano['fim']);

                                    // Converte a data atual para DateTime para comparação
                                    $dataAtual = DateTime::createFromFormat('d/m/Y', $date);

                                    // Verifica se a data atual está entre a data de início e de fim
                                    $isCurrent = ($dataAtual >= $dataInicio && $dataAtual <= $dataFim);
                                    ?>

                                    <div class="border border-green-300 rounded-lg p-4 w-[18%] <?php echo $isCurrent ? 'bg-green-500 text-white' : 'bg-white'; ?> shadow-sm">
                                        <span class="border rounded-full px-4 py-2 font-medium <?php echo $isCurrent ? 'border-white' : 'border-orange-300 text-orange-700'; ?>">
                                            <?php echo $arcano['arcano']; ?>
                                        </span>
                                        <p class="mt-4 text-sm <?php echo $isCurrent ? 'text-white' : 'text-gray-800'; ?>">
                                            De <?php echo convertDate($arcano['inicio']); ?>
                                            até <?php echo convertDate($arcano['fim']); ?>
                                        </p>
                                        <p class="text-sm <?php echo $isCurrent ? 'text-white' : 'text-gray-800'; ?>">
                                            <?php echo $arcano['idadeInicio']; ?> a <?php echo $arcano['idadeFim']; ?>
                                        </p>
                                        <div class="flex justify-end">
                                            <a class="text-sm underline <?php echo $isCurrent ? 'text-white' : 'text-blue-600 hover:text-blue-800'; ?>"
                                               href="#" data-modal="<?php echo "modal-arcano-social-$key" ?>">Ver
                                                detalhes</a>
                                            <?php render_arcano_modal("modal-arcano-social-$key", $arcano_basicavida_options, $arcano); ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div id="arcanoOculta" class="arcano-container bg-gray-50 rounded-2xl p-6 shadow-md"
                             style="display:none;">
                            <h2 class="text-xl font-semibold my-4">Arcanos (destino)</h2>
                            <div class="flex flex-wrap gap-4 justify-between">
                                <?php foreach ($arcanos_destino as $key => $arcano): ?>
                                    <?php
                                    // Obtém a data atual no formato 'd/m/Y'
                                    $date = current_datetime()->format('d/m/Y');

                                    // Converte as datas de início e fim de 'd-m-Y' para 'd/m/Y'
                                    $dataInicio = DateTime::createFromFormat('d-m-Y', $arcano['inicio']);
                                    $dataFim = DateTime::createFromFormat('d-m-Y', $arcano['fim']);

                                    // Converte a data atual para DateTime para comparação
                                    $dataAtual = DateTime::createFromFormat('d/m/Y', $date);

                                    // Verifica se a data atual está entre a data de início e de fim
                                    $isCurrent = ($dataAtual >= $dataInicio && $dataAtual <= $dataFim);
                                    ?>

                                    <div class="border border-green-300 rounded-lg p-4 w-[18%] <?php echo $isCurrent ? 'bg-green-500 text-white' : 'bg-white'; ?> shadow-sm">
                                        <span class="border rounded-full px-4 py-2 font-medium <?php echo $isCurrent ? 'border-white' : 'border-orange-300 text-orange-700'; ?>">
                                            <?php echo $arcano['arcano']; ?>
                                        </span>
                                        <p class="mt-4 text-sm <?php echo $isCurrent ? 'text-white' : 'text-gray-800'; ?>">
                                            De <?php echo convertDate($arcano['inicio']); ?>
                                            até <?php echo convertDate($arcano['fim']); ?>
                                        </p>
                                        <p class="text-sm <?php echo $isCurrent ? 'text-white' : 'text-gray-800'; ?>">
                                            <?php echo $arcano['idadeInicio']; ?> a <?php echo $arcano['idadeFim']; ?>
                                        </p>
                                        <div class="flex justify-end">
                                            <a class="text-sm underline <?php echo $isCurrent ? 'text-white' : 'text-blue-600 hover:text-blue-800'; ?>"
                                               href="#" data-modal="<?php echo "modal-arcano-destino-$key" ?>">Ver
                                                detalhes</a>
                                            <?php render_arcano_modal("modal-arcano-destino-$key", $arcano_basicavida_options, $arcano); ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <script>
                            function openArcano(evt, arcanoName) {
                                console.log("openArcano chamado com: ", arcanoName);
                                var arcanoContainer = document.getElementsByClassName('arcano-container');
                                for (var i = 0; i < arcanoContainer.length; i++) {
                                    arcanoContainer[i].style.display = 'none'; // Oculta todos os arcanos
                                }

                                var tabLinks = document.getElementsByClassName('tab-link');
                                for (var i = 0; i < tabLinks.length; i++) {
                                    tabLinks[i].classList.remove('active'); // Remove a classe 'active'
                                }

                                document.getElementById(arcanoName).style.display = 'block'; // Mostra o arcano selecionado
                                evt.currentTarget.classList.add('active'); // Adiciona a classe 'active' ao botão clicado
                            }

                            document.addEventListener('DOMContentLoaded', function () {
                                // Código das abas e demais interações...
                            });
                        </script>
                    </div>

                    <!-- Tab 5 Content -->
                    <div data-tab-content="tab5" class="p-4 hidden">
                        <div class="tab-menu mb-6 flex justify-center space-x-4">
                            <button
                                    class="tab-link px-6 py-2 text-sm font-medium rounded-full bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring focus:ring-blue-300 transition duration-200"
                                    onclick="openPiramide(event, 'piramideVida', 'listaVida')">
                                Vida
                            </button>
                            <button
                                    class="tab-link px-6 py-2 text-sm font-medium rounded-full bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring focus:ring-blue-300 transition duration-200"
                                    onclick="openPiramide(event, 'piramideTalento', 'listaTalento')">
                                Pessoal
                            </button>
                            <button
                                    class="tab-link px-6 py-2 text-sm font-medium rounded-full bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring focus:ring-blue-300 transition duration-200"
                                    onclick="openPiramide(event, 'piramideAscensao', 'listaAscensao')">
                                Social
                            </button>
                            <button
                                    class="tab-link px-6 py-2 text-sm font-medium rounded-full bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring focus:ring-blue-300 transition duration-200"
                                    onclick="openPiramide(event, 'piramideOculta', 'listaOculta')">
                                Destino
                            </button>
                        </div>


                        <div class="flex">
                            <!-- Coluna da Pirâmide e Lista de Sequências - Vida -->
                            <div id="piramideVida"
                                 class="piramide-container w-full h-full flex items-center justify-center bg-gray-50">
                                <div class="flex w-full max-w-6xl p-6 space-x-6">
                                    <!-- Pirâmide Central -->
                                    <div class="flex-1 flex flex-col ">
                                        <?php
                                        // Imprimir a pirâmide invertida centralizada
                                        $totalLinhas = count($sequencia_piramide_vida);

                                        for ($i = 0; $i < $totalLinhas; $i++) {
                                            echo '<div class="flex justify-center">';
                                            echo '<p class="text-center text-purple-700 text-sm">';
                                            echo $sequencia_piramide_vida[$i];
                                            echo '</p>';
                                            echo '</div>';
                                        }
                                        ?>
                                    </div>

                                    <!-- Lista Sequências -->
                                    <div class="w-1/3 bg-white border border-gray-300 rounded-lg shadow-md p-6 overflow-auto">
                                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Sequências Vida</h2>
                                        <ul class="text-sm text-gray-700 space-y-4">
                                            <?php foreach ($sequencias_vida as $tipo => $sequencias): ?>
                                                <li class="border-b border-gray-200 pb-2">
                                                    <h3 class="text-lg font-medium text-gray-600 mb-2"><?php echo ucfirst($tipo); ?></h3>
                                                    <ul class="ml-4 flex gap-4 items-center">
                                                        <?php foreach ($sequencias as $sequencia): ?>
                                                            <li>
                                                                <?php $id = "modal-vida-$tipo-$sequencia" ?>
                                                                <a
                                                                        href="#"
                                                                        class="text-cor-numera hover:text-[#D6C8E3] font-medium"
                                                                        data-modal-target="<?php echo $id ?>">
                                                                    <?php echo $sequencia ?>
                                                                </a>
                                                                <?php echo render_piramid_sequences_modal($id, $sequencia, "Aqui você pode adicionar mais informações sobre a sequência") ?>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Coluna da Pirâmide e Lista de Sequências - Pessoal -->
                            <div id="piramideTalento"
                                 class="piramide-container w-full h-full flex items-center justify-center bg-gray-50 hidden"
                                 style="display: none">
                                <div class="flex w-full max-w-6xl p-6 space-x-6">
                                    <div class="flex-1 flex flex-col">
                                        <?php
                                        $totalLinhas = count($sequencia_piramide_pessoal);

                                        for ($i = 0; $i < $totalLinhas; $i++) {
                                            echo '<div class="flex justify-center">';
                                            echo '<p class="text-center text-purple-700 text-sm">';
                                            echo $sequencia_piramide_pessoal[$i];
                                            echo '</p>';
                                            echo '</div>';
                                        }
                                        ?>
                                    </div>
                                    <div class="w-1/3 bg-white border border-gray-300 rounded-lg shadow-md p-6 overflow-auto">
                                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Sequências Vida</h2>
                                        <ul class="text-sm text-gray-700 space-y-4">
                                            <?php foreach ($sequencias_pessoal as $tipo => $sequencias): ?>
                                                <li class="border-b border-gray-200 pb-2">
                                                    <h3 class="text-lg font-medium text-gray-600 mb-2"><?php echo ucfirst($tipo); ?></h3>
                                                    <ul class="ml-4 flex gap-4 items-center">
                                                        <?php foreach ($sequencias as $sequencia): ?>
                                                            <li>
                                                                <?php $id = "modal-pessoal-$tipo-$sequencia" ?>
                                                                <a
                                                                        href="<?php echo $id ?>"
                                                                        class="text-cor-numera hover:text-[#D6C8E3] font-medium"
                                                                        data-modal-target="<?php echo $id ?>">
                                                                    <?php echo $sequencia; ?>
                                                                </a>
                                                                <?php echo render_piramid_sequences_modal($id, $sequencia, "Aqui você pode adicionar mais informações sobre a sequência") ?>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Coluna da Pirâmide e Lista de Sequências - Social -->
                            <div id="piramideAscensao"
                                 class="piramide-container w-full h-full flex items-center justify-center bg-gray-50 hidden"
                                 style="display: none">
                                <div class="flex w-full max-w-6xl p-6 space-x-6">
                                    <div class="flex-1 flex flex-col">
                                        <?php
                                        $totalLinhas = count($sequencia_piramide_social);

                                        for ($i = 0; $i < $totalLinhas; $i++) {
                                            echo '<div class="flex justify-center">';
                                            echo '<p class="text-center text-purple-700 text-sm">';
                                            echo $sequencia_piramide_social[$i];
                                            echo '</p>';
                                            echo '</div>';
                                        }
                                        ?>
                                    </div>
                                    <div class="w-1/3 bg-white border border-gray-300 rounded-lg shadow-md p-6 overflow-auto">
                                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Sequências (Social)</h2>
                                        <ul class="text-sm text-gray-700 space-y-4">
                                            <?php foreach ($sequencias_social as $tipo => $sequencias): ?>
                                                <li class="border-b border-gray-200 pb-2">
                                                    <h3 class="text-lg font-medium text-gray-600 mb-2"><?php echo ucfirst($tipo); ?></h3>
                                                    <ul class="ml-4 flex gap-4 items-center">
                                                        <?php foreach ($sequencias as $sequencia): ?>
                                                            <li>
                                                                <?php $id = "modal-social-$tipo-$sequencia" ?>
                                                                <a
                                                                        href="<?php echo $id ?>"
                                                                        class="text-cor-numera hover:text-[#D6C8E3] font-medium"
                                                                        data-modal-target="<?php echo $id ?>">
                                                                    <?php echo $sequencia; ?>
                                                                </a>
                                                                <?php echo render_piramid_sequences_modal($id, $sequencia, "Aqui você pode adicionar mais informações sobre a sequência") ?>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>

                                </div>
                            </div>

                            <!-- Coluna da Pirâmide e Lista de Sequências - Destino -->
                            <div id="piramideOculta"
                                 class="piramide-container w-full h-full flex items-center justify-center bg-gray-50 hidden"
                                 style="display: none">
                                <div class="flex w-full max-w-6xl p-6 space-x-6">
                                    <div class="flex-1 flex flex-col">
                                        <?php
                                        $totalLinhas = count($sequencia_piramide_destino);

                                        for ($i = 0; $i < $totalLinhas; $i++) {
                                            echo '<div class="flex justify-center">';
                                            echo '<p class="text-center text-purple-700 text-sm">';
                                            echo $sequencia_piramide_destino[$i];
                                            echo '</p>';
                                            echo '</div>';
                                        }
                                        ?>
                                    </div>
                                    <div class="w-1/3 bg-white border border-gray-300 rounded-lg shadow-md p-6 overflow-auto">
                                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Sequências Vida</h2>
                                        <ul class="text-sm text-gray-700 space-y-4">
                                            <?php foreach ($sequencias_destino as $tipo => $sequencias): ?>
                                                <li class="border-b border-gray-200 pb-2">
                                                    <h3 class="text-lg font-medium text-gray-600 mb-2"><?php echo ucfirst($tipo); ?></h3>
                                                    <ul class="ml-4 flex gap-4 items-center">
                                                        <?php foreach ($sequencias as $sequencia): ?>
                                                            <li>
                                                                <?php $id = "modal-destino-$tipo-$sequencia" ?>
                                                                <a
                                                                        href="<?php echo $id ?>"
                                                                        class="text-cor-numera hover:text-[#D6C8E3] font-medium"
                                                                        data-modal-target="<?php echo $id ?>">
                                                                    <?php echo $sequencia; ?>
                                                                </a>
                                                                <?php echo render_piramid_sequences_modal($id, $sequencia, "Aqui você pode adicionar mais informações sobre a sequência") ?>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            // Abrir modal
                            document.querySelectorAll('[data-modal-target]').forEach(link => {
                                link.addEventListener('click', function (event) {
                                    event.preventDefault();
                                    const modalId = this.getAttribute('data-modal-target');
                                    document.getElementById(modalId).classList.remove('hidden');
                                });
                            });

                            // Fechar modal
                            function closeModal(modalId) {
                                document.getElementById(modalId).classList.add('hidden');
                            }
                        </script>
                    </div>

                    <style>
                        .sequecia {
                            letter-spacing: 0.5em;
                            padding-left: 0.5em;
                        }

                        .sequecia:last-child {
                            margin-right: -0.5em;
                            /* Ajuste conforme necessário */
                        }

                        .sequencias {
                            background-color: #f9f9f9;
                            padding: 1em;
                            border-radius: 8px;
                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                        }

                        .sequencias ul {
                            list-style-type: none;
                            padding: 0;
                        }

                        .sequencias li {
                            padding: 0.5em 0;
                        }
                    </style>

                    <!-- Tab 6 Content -->
                    <div data-tab-content="tab6" class="p-4 hidden">
                        <div class="flex justify-between">
                            <div class="flex flex-col gap-4 justify-between">
                                <?php
                                foreach ($vocacional as $profissao => $dados) {
                                    $profissao = ucfirst($profissao);
                                    if ($dados['contagem'] > 1) {
                                        $fontesUnicas = array_unique($dados['fontes']);
                                        echo '<div>' . "<strong>$profissao</strong>: {$dados['contagem']} vezes, em: " . implode(', ', $fontesUnicas) . '</div>';
                                    }
                                }
                                ?>
                            </div>

                            <table class="bg-white border border-collapse border-gray-300 rounded">
                                <thead>
                                <tr class="bg-gray-200 text-gray-700">
                                    <th class="py-2 px-4 border border-gray-300">Nº de destino</th>
                                    <th class="py-2 px-4 border border-gray-300">Nº de Expressão Favorável</th>
                                    <th class="py-2 px-4 border border-gray-300">Nº de Expressão Desfavorável</th>
                                    <th class="py-2 px-4 border border-gray-300">Números Neutros</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="text-center">
                                    <td class="py-2 px-4 border border-gray-300">1</td>
                                    <td class="py-2 px-4 border border-gray-300">3, 5 e 9</td>
                                    <td class="py-2 px-4 border border-gray-300">6</td>
                                    <td class="py-2 px-4 border border-gray-300">1, 2, 4, 7 e 8</td>
                                </tr>
                                <tr class="text-center">
                                    <td class="py-2 px-4 border border-gray-300">2</td>
                                    <td class="py-2 px-4 border border-gray-300">2, 4, 6 e 7</td>
                                    <td class="py-2 px-4 border border-gray-300">5 e 9</td>
                                    <td class="py-2 px-4 border border-gray-300">1, 3 e 8</td>
                                </tr>
                                <tr class="text-center">
                                    <td class="py-2 px-4 border border-gray-300">3</td>
                                    <td class="py-2 px-4 border border-gray-300">1, 3, 5 e 6</td>
                                    <td class="py-2 px-4 border border-gray-300">4, 7 e 8</td>
                                    <td class="py-2 px-4 border border-gray-300">2 e 9</td>
                                </tr>
                                <tr class="text-center">
                                    <td class="py-2 px-4 border border-gray-300">4</td>
                                    <td class="py-2 px-4 border border-gray-300">2, 6 e 8</td>
                                    <td class="py-2 px-4 border border-gray-300">3, 5, 7 e 9</td>
                                    <td class="py-2 px-4 border border-gray-300">1 e 4</td>
                                </tr>
                                <tr class="text-center">
                                    <td class="py-2 px-4 border border-gray-300">5</td>
                                    <td class="py-2 px-4 border border-gray-300">1, 3, 5, 7 e 9</td>
                                    <td class="py-2 px-4 border border-gray-300">2, 4, 6 e 8</td>
                                    <td class="py-2 px-4 border border-gray-300">xxxxxxxxxxxxxxxxxxx</td>
                                </tr>
                                <tr class="text-center">
                                    <td class="py-2 px-4 border border-gray-300">6</td>
                                    <td class="py-2 px-4 border border-gray-300">2, 3, 4, 8 e 9</td>
                                    <td class="py-2 px-4 border border-gray-300">1, 5 e 7</td>
                                    <td class="py-2 px-4 border border-gray-300">6</td>
                                </tr>
                                <tr class="text-center">
                                    <td class="py-2 px-4 border border-gray-300">7</td>
                                    <td class="py-2 px-4 border border-gray-300">2, 5 e 7</td>
                                    <td class="py-2 px-4 border border-gray-300">3, 4, 6, 8 e 9</td>
                                    <td class="py-2 px-4 border border-gray-300">1</td>
                                </tr>
                                <tr class="text-center">
                                    <td class="py-2 px-4 border border-gray-300">8</td>
                                    <td class="py-2 px-4 border border-gray-300">4 e 6</td>
                                    <td class="py-2 px-4 border border-gray-300">3, 5, 7, 8 e 9</td>
                                    <td class="py-2 px-4 border border-gray-300">1 e 2</td>
                                </tr>
                                <tr class="text-center">
                                    <td class="py-2 px-4 border border-gray-300">9</td>
                                    <td class="py-2 px-4 border border-gray-300">1, 5, 6, e 9</td>
                                    <td class="py-2 px-4 border border-gray-300">2, 4, 7 e 8</td>
                                    <td class="py-2 px-4 border border-gray-300">3</td>
                                </tr>
                                <tr class="text-center">
                                    <td class="py-2 px-4 border border-gray-300">11</td>
                                    <td class="py-2 px-4 border border-gray-300">1, 3, 5, 7, 9 e 11</td>
                                    <td class="py-2 px-4 border border-gray-300">2, 4, 6 e 8</td>
                                    <td class="py-2 px-4 border border-gray-300">22</td>
                                </tr>
                                <tr class="text-center">
                                    <td class="py-2 px-4 border border-gray-300">22</td>
                                    <td class="py-2 px-4 border border-gray-300">1, 2, 3, 4, 5, 6, 7, 8, 9 e 22</td>
                                    <td class="py-2 px-4 border border-gray-300">xxxxxxxxxxxxxxxxxxx</td>
                                    <td class="py-2 px-4 border border-gray-300">11</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Função para abrir e fechar o modal
            document.querySelectorAll('a[data-modal]').forEach(openModalButton => {
                const modalId = openModalButton.getAttribute('data-modal');
                const modal = document.getElementById(modalId);
                const closeModalButton = modal.querySelector('.closeModal');

                // Abrir o modal ao clicar no link
                openModalButton.addEventListener('click', function (event) {
                    event.preventDefault(); // Prevenir comportamento padrão do link
                    modal.style.display = 'flex'; // Mostrar o modal
                });

                // Fechar o modal ao clicar no botão de fechar
                closeModalButton.addEventListener('click', function () {
                    modal.style.display = 'none'; // Esconder o modal
                });

                // Fechar o modal ao clicar fora do conteúdo
                window.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        modal.style.display = 'none';
                    }
                });
            });

            // Ações de download do mapa
            const downloadForm = document.querySelector("#map-download form");
            console.log(downloadForm)
        });
    </script>

    <footer class="entry-footer mt-8">
        <?php
        if (has_post_thumbnail()) {
            the_post_thumbnail('large', ['class' => 'w-full h-auto mt-4']);
        }
        ?>
    </footer>
    </article>

<?php endwhile; ?>
    </div>

<?php
get_footer();