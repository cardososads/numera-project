<?php
/* Template Name: Perfil do Usuário */

get_header();
$current_user = wp_get_current_user();

if (!$current_user->exists()) {
    echo '<div class="container mx-auto mt-10 text-center text-red-600">';
    echo '<p>Você precisa estar logado para acessar essa página.</p>';
    echo '</div>';
    get_footer();
    exit;
}

// Lógica de upload de imagem
function handle_profile_picture_upload() {
    // Verifica o nonce para segurança
    if (!isset($_POST['upload_profile_picture_nonce']) ||
        !wp_verify_nonce($_POST['upload_profile_picture_nonce'], 'upload_profile_picture')) {
        wp_die(__('Falha ao verificar a solicitação de upload. Tente novamente.', 'textdomain'));
    }

    // Verifica se o usuário está logado
    if (!is_user_logged_in()) {
        wp_die(__('Você precisa estar logado para fazer o upload.', 'textdomain'));
    }

    // Verifica se o arquivo foi enviado
    if (isset($_FILES['profile_picture']) && !empty($_FILES['profile_picture']['name'])) {
        // Inclui a biblioteca de upload do WordPress
        if (!function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }

        $uploadedfile = $_FILES['profile_picture'];

        // Argumentos para upload
        $upload_overrides = ['test_form' => false];
        $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

        if ($movefile && !isset($movefile['error'])) {
            // Sucesso no upload
            $attachment = [
                'guid' => $movefile['url'],
                'post_mime_type' => $movefile['type'],
                'post_title' => basename($movefile['file']),
                'post_content' => '',
                'post_status' => 'inherit',
            ];

            $attachment_id = wp_insert_attachment($attachment, $movefile['file']);

            if (!is_wp_error($attachment_id)) {
                // Adiciona os meta dados da imagem
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                $attach_data = wp_generate_attachment_metadata($attachment_id, $movefile['file']);
                wp_update_attachment_metadata($attachment_id, $attach_data);

                // Atualiza o campo de imagem de perfil do usuário
                update_user_meta(get_current_user_id(), 'profile_picture', $movefile['url']);

                // Redireciona com sucesso
                wp_redirect(home_url('/profile?upload_success=1'));
                exit;
            } else {
                wp_die(__('Erro ao salvar os metadados da imagem.', 'textdomain'));
            }
        } else {
            wp_die(__('Erro no upload: ', 'textdomain') . $movefile['error']);
        }
    } else {
        wp_die(__('Por favor, selecione um arquivo para fazer o upload.', 'textdomain'));
    }
}

// Hook para o formulário de upload
add_action('admin_post_upload_profile_picture', 'handle_profile_picture_upload');


?>

<div class="container mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Perfil do Usuário</h2>

    <div class="flex items-center space-x-6 mb-6">
        <?php
        // Exibe a imagem de perfil, se houver
        $profile_picture = get_user_meta($current_user->ID, 'profile_picture', true);
        $profile_picture_url = $profile_picture ? esc_url($profile_picture) : get_avatar_url($current_user->ID, ['size' => '64']);
        ?>

        <div class="relative group">
            <img src="<?php echo $profile_picture_url; ?>" alt="Foto de Perfil" class="w-32 h-32 rounded-full border border-gray-300 cursor-pointer">
            <button class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 text-white text-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity duration-300" onclick="toggleModal('modal-profile-picture')">
                Trocar Imagem
            </button>
        </div>

        <div>
            <p class="text-lg"><strong>Nome:</strong> <?php echo esc_html($current_user->display_name); ?></p>
            <p class="text-lg"><strong>Email:</strong> <?php echo esc_html($current_user->user_email); ?></p>
        </div>
    </div>
</div>

<!-- Modal para Upload de Imagem -->
<div id="modal-profile-picture" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h3 class="text-xl font-bold mb-4">Carregar Nova Foto de Perfil</h3>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <input type="file" name="profile_picture" accept="image/*" required class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
            </div>
            <?php wp_nonce_field('upload_profile_picture', 'upload_profile_picture_nonce'); ?>
            <div class="flex justify-end space-x-4">
                <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50" onclick="toggleModal('modal-profile-picture')">Cancelar</button>
                <button type="submit" name="upload_profile_picture" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Confirmar</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Função para abrir/fechar o modal
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
    }
</script>

<?php
get_footer();
?>
