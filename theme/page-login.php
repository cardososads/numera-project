<?php
/* Template Name: Login Page */

// Custom redirect after login
function custom_login_redirect($redirect_to, $request, $user) {
	if (isset($user->roles) && is_array($user->roles)) {
		if (in_array('administrator', $user->roles)) {
			return admin_url(); // Redireciona para a área administrativa
		} else {
			return home_url(); // Redireciona para a página inicial
		}
	} else {
		return $redirect_to;
	}
}
add_filter('login_redirect', 'custom_login_redirect', 10, 3);
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div class="min-h-screen flex">
	<!-- Coluna da esquerda: Formulário de Login -->
	<div class="w-full md:w-1/2 bg-[#F8DDE1] flex flex-col justify-center items-center p-8">
		<h2 class="text-2xl font-bold mb-6">Login</h2>

		<form method="post" action="<?php echo esc_url( wp_login_url() ); ?>" class="w-full max-w-md">
			<div class="mb-4">
				<label for="user_login" class="block text-sm font-medium text-gray-700">Usuário ou E-mail</label>
				<input type="text" name="log" id="user_login" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
			</div>
			<div class="mb-6">
				<label for="user_pass" class="block text-sm font-medium text-gray-700">Senha</label>
				<input type="password" name="pwd" id="user_pass" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
			</div>
			<div>
				<input type="submit" name="wp-submit" value="Login" class="w-full bg-[#42275C] text-white py-2 px-4 rounded-md hover:bg-[#633A8A] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
				<input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url() ); ?>">
			</div>
		</form>

		<?php
		// Verificar se há erros de login
		if (isset($_GET['login']) && $_GET['login'] == 'failed') {
			echo '<p class="mt-4 text-red-500">Erro: Nome de usuário ou senha incorretos.</p>';
		}
		?>

	</div>

	<!-- Coluna da direita: Imagem -->
	<div class="flex bg-[#E2CBEA] bg-contain md:w-1/2 justify-center items-center">
		<!-- Placeholder para a imagem -->
		<div><img class="w-[400px] h-auto" src="<?php echo get_template_directory_uri() . '/images/logo.png'; ?>" alt=""></div>
	</div>
</div>

<?php wp_footer(); ?>
</body>
</html>
