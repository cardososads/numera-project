<?php

/**
 * numera_theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package numera_theme
 */

if (! defined('NUMERA_THEME_VERSION')) {
	/*
     * Set the theme’s version number.
     *
     * This is used primarily for cache busting. If you use `npm run bundle`
     * to create your production build, the value below will be replaced in the
     * generated zip file with a timestamp, converted to base 36.
     */
	define('NUMERA_THEME_VERSION', '0.1.0');
}

if (! defined('NUMERA_THEME_TYPOGRAPHY_CLASSES')) {
	/*
     * Set Tailwind Typography classes for the front end, block editor and
     * classic editor using the constant below.
     *
     * For the front end, these classes are added by the `numera_theme_content_class`
     * function. You will see that function used everywhere an `entry-content`
     * or `page-content` class has been added to a wrapper element.
     *
     * For the block editor, these classes are converted to a JavaScript array
     * and then used by the `./javascript/block-editor.js` file, which adds
     * them to the appropriate elements in the block editor (and adds them
     * again when they’re removed.)
     *
     * For the classic editor (and anything using TinyMCE, like Advanced Custom
     * Fields), these classes are added to TinyMCE’s body class when it
     * initializes.
     */
	define(
		'NUMERA_THEME_TYPOGRAPHY_CLASSES',
		'prose prose-neutral max-w-none prose-a:text-primary'
	);
}

if (! function_exists('numera_theme_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function numera_theme_setup()
	{
		/*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on numera_theme, use a find and replace
         * to change 'numera_theme' to the name of your theme in all the template files.
         */
		load_theme_textdomain('numera_theme', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
		add_theme_support('title-tag');

		/*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'menu-1' => __('Primary', 'numera_theme'),
				'menu-2' => __('Footer Menu', 'numera_theme'),
			)
		);

		/*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		// Add support for editor styles.
		add_theme_support('editor-styles');

		// Enqueue editor styles.
		add_editor_style('style-editor.css');
		add_editor_style('style-editor-extra.css');

		// Add support for responsive embedded content.
		add_theme_support('responsive-embeds');

		// Remove support for block templates.
		remove_theme_support('block-templates');
	}
endif;
add_action('after_setup_theme', 'numera_theme_setup');

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function numera_theme_widgets_init()
{
	register_sidebar(
		array(
			'name'          => __('Footer', 'numera_theme'),
			'id'            => 'sidebar-1',
			'description'   => __('Add widgets here to appear in your footer.', 'numera_theme'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'numera_theme_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function numera_theme_scripts()
{
	wp_enqueue_style('numera_theme-style', get_stylesheet_uri(), array(), NUMERA_THEME_VERSION);
	wp_enqueue_script('numera_theme-script', get_template_directory_uri() . '/js/script.min.js', array(), NUMERA_THEME_VERSION, true);

	wp_enqueue_script('mobile-toggle-off-canvas', get_theme_file_uri() . '/js/mobile-toggle-off-canvas.js', 10);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'numera_theme_scripts');

/**
 * Enqueue the block editor script.
 */
function numera_theme_enqueue_block_editor_script()
{
	if (is_admin()) {
		wp_enqueue_script(
			'numera_theme-editor',
			get_template_directory_uri() . '/js/block-editor.min.js',
			array(
				'wp-blocks',
				'wp-edit-post',
			),
			NUMERA_THEME_VERSION,
			true
		);
		wp_add_inline_script('numera_theme-editor', "tailwindTypographyClasses = '" . esc_attr(NUMERA_THEME_TYPOGRAPHY_CLASSES) . "'.split(' ');", 'before');
	}
}
add_action('enqueue_block_assets', 'numera_theme_enqueue_block_editor_script');

/**
 * Add the Tailwind Typography classes to TinyMCE.
 *
 * @param array $settings TinyMCE settings.
 * @return array
 */
function numera_theme_tinymce_add_class($settings)
{
	$settings['body_class'] = NUMERA_THEME_TYPOGRAPHY_CLASSES;
	return $settings;
}
add_filter('tiny_mce_before_init', 'numera_theme_tinymce_add_class');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

//--------------------------------------------------------------------------------------------------------------

function enqueue_dashicons()
{
	wp_enqueue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'enqueue_dashicons');

function enqueue_scripts()
{
	wp_enqueue_script('my-custom-script', get_template_directory_uri() . '/js/custom-script.js', array('jquery'), null, true);
	wp_enqueue_script('ajax-placas', get_template_directory_uri() . '/js/ajax-placas.js', array('jquery'), null, true);
	wp_enqueue_script('ajax-enderecos', get_template_directory_uri() . '/js/ajax-enderecos.js', array('jquery'), null, true);
	wp_enqueue_script('ajax-empresas', get_template_directory_uri() . '/js/ajax-empresas.js', array('jquery'), null, true);
	wp_enqueue_script('ajax-assinatura', get_template_directory_uri() . '/js/ajax-assinaturas.js', array('jquery'), null, true);
	wp_enqueue_script('ajax-single-posts', get_template_directory_uri() . '/js/ajax-single-posts.js', array('jquery'), null, true);

	if (is_home()) {
		wp_enqueue_script("template-map-search", get_theme_file_uri() . "/js/template-map-search.js");
	}

	if (is_single()) {
		wp_enqueue_style('single', get_theme_file_uri() . '/css/single.css');
	}

	if (is_singular('mapas')) {
		wp_enqueue_script("single-map", get_theme_file_uri() . "/js/single-mapa.js");
	}

	if (is_singular('placas')) {
		wp_enqueue_script("single-placa", get_theme_file_uri() . "/js/single-placa.js");
	}

	if (is_singular('enderecos')) {
		wp_enqueue_script("single-endereco", get_theme_file_uri() . "/js/single-endereco.js");
	}

	if (is_singular('empresarial')) {
		wp_enqueue_script("single-empresa", get_theme_file_uri() . "/js/single-empresarial.js");
	}

    if (is_singular('assinatura')) {
        wp_enqueue_script("single-assinatura", get_theme_file_uri() . "/js/single-assinatura.js");
    }
}
add_action('wp_enqueue_scripts', 'enqueue_scripts');


require get_template_directory() . '/inc/Numerologia.php';

// Função para restringir o acesso a membros logados
function restrict_access_to_members()
{
	if (!is_user_logged_in() && !is_page('login')) {
		wp_redirect(site_url('/login/'));
		exit();
	}
}
add_action('template_redirect', 'restrict_access_to_members');

// Registro de posts customizados
require get_template_directory() . '/inc/custom-posts.php';

// Controla as requisições AJAX do tema
include get_theme_file_path() . "/inc/numera-ajax-requests.php";

//require_once get_template_directory() . '/vendor/autoload.php';
require_once get_template_directory() . '/../vendor/autoload.php';

include_once get_theme_file_path() . "/inc/handle-map-download.php";
include_once get_theme_file_path() . "/inc/handle-placa-download.php";
include_once get_theme_file_path() . "/inc/handle-endereco-download.php";
include_once get_theme_file_path() . "/inc/handle-empresarial-download.php";

// Função para bloquear o acesso ao admin para assinantes e redirecioná-los
function block_wp_admin_access()
{
	if (current_user_can('subscriber') && (is_admin() || strpos($_SERVER['PHP_SELF'], 'wp-login.php') !== false)) {
		if (defined('DOING_AJAX') && DOING_AJAX) {
			return; // Skip redirection for AJAX requests
		}

		if (is_user_logged_in() && strpos($_SERVER['REQUEST_URI'], 'wp-login.php?action=logout') !== false) {
			error_log("Logout process started.");
			return;
		}

		wp_redirect(home_url());
		exit;
	}
}
add_action('init', 'block_wp_admin_access');


// Função para remover a barra de administração para usuários não administradores
function remover_admin_bar_para_usuarios()
{
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}
add_action('init', 'remover_admin_bar_para_usuarios');

function enqueue_font_awesome() {
    // Enfileira o script do Font Awesome
    wp_enqueue_script(
        'font-awesome', // Handle do script
        'https://kit.fontawesome.com/a076d05399.js', // URL do script
        array(), // Dependências (nenhuma neste caso)
        null, // Versão (null para não versionar)
        false // Carregar no header (true para footer, false para header)
    );
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');

function custom_acf_options_page_tabs()
{
?>
	<style>
		/* Estilo básico das abas */
		.acf-tab-nav {
			margin-bottom: 20px;
			display: flex;
			list-style: none;
		}

		.acf-tab-nav li {
			margin-right: 10px;
		}

		.acf-tab-nav li a {
			padding: 10px 15px;
			background: #f1f1f1;
			border: 1px solid #ccc;
			text-decoration: none;
			color: #0073aa;
		}

		.acf-tab-nav li a.active {
			background: #0073aa;
			color: #fff;
		}

		/* Esconde todas as seções por padrão */
		.acf-field-group {
			display: none;
		}

		/* Mostra a primeira seção ao carregar */
		.acf-field-group.active {
			display: block;
		}
	</style>

	<script type="text/javascript">
		jQuery(document).ready(function($) {
			// Cria a barra de navegação com abas
			var $groups = $('.acf-field-group');
			var $nav = $('<ul class="acf-tab-nav"></ul>');

			// Cria a navegação para cada grupo de campos
			$groups.each(function(index) {
				var groupTitle = $(this).find('h2').text(); // Captura o título do grupo de campos
				var groupId = 'acf-group-' + index;

				// Adiciona uma classe de identificador ao grupo
				$(this).attr('id', groupId);

				// Cria a aba e associa ao grupo
				var $tab = $('<li><a href="#" data-group="#' + groupId + '">' + groupTitle + '</a></li>');
				$nav.append($tab);
			});

			// Insere a navegação antes dos grupos
			$nav.insertBefore($groups.first());

			// Função de clique para alternar entre abas
			$nav.find('a').on('click', function(e) {
				e.preventDefault();

				// Remove a classe 'active' de todas as abas e grupos
				$nav.find('a').removeClass('active');
				$groups.removeClass('active');

				// Ativa a aba e o grupo selecionados
				$(this).addClass('active');
				$($(this).data('group')).addClass('active');
			});

			// Ativa a primeira aba e grupo ao carregar a página
			$nav.find('a').first().addClass('active');
			$groups.first().addClass('active');
		});
	</script>
<?php
}
add_action('admin_footer', 'custom_acf_options_page_tabs');

