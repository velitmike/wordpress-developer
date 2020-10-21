<?php
// Добавление расширенных воможностей
if (!function_exists('vmv_theme_setup')) :

	function vmv_theme_setup()
	{
		// Добавление тега title
		add_theme_support('title-tag');
		// Добавления миниатюр
		add_theme_support('post-thumbnails', array('post'));
		// Добавление пользоватьского логотипа
		add_theme_support('custom-logo', [
			'width'       => 163,
			'flex-height' => true,
			'header-text' => 'VMV_developer',
			'unlink-homepage-logo' => false, // WP 5.5
		]);
		// Регистрация меню
		register_nav_menus([
			'header_menu' => 'Menu in header',
			'footer_menu' => 'Menu in footer'
		]);
	}
endif;
add_action('after_setup_theme', 'vmv_theme_setup');

/**
 * Подключаем сайдбара (widget area).
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function vmv_theme_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar on main', 'vmv_theme'),
			'id'            => 'main-sidebar',
			'description'   => esc_html__('Add widgets here.', 'vmv_theme'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'vmv_theme_widgets_init');

// Подключение стилей и скриптов; при time() - файл стилей не попадает в кэш на время разработки 
function enqueue_vmv_style()
{
	wp_enqueue_style('style', get_stylesheet_uri());
	wp_enqueue_style('vmv-theme', get_template_directory_uri() . '/assets/css/vmv-theme.css', 'style', time());
	wp_enqueue_style('Roboto-Slab', "https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap",);
}
add_action('wp_enqueue_scripts', 'enqueue_vmv_style');

## отключаем создание миниатюр файлов для указанных размеров
add_filter('intermediate_image_sizes', 'delete_intermediate_image_sizes');
function delete_intermediate_image_sizes($sizes)
{
	// размеры которые нужно удалить
	return array_diff($sizes, [
		'medium_large',
		'large',
		'1536x1536',
		'2048x2048',
	]);
}
