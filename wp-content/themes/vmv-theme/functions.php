<?php
// Добавление расширенных воможностей
if ( ! function_exists( 'vmv_theme_setup' ) ) :
	
function vmv_theme_setup() {
	// Добавление тега title
	add_theme_support( 'title-tag' );
	// Добавление пользоватьского логотипа
	add_theme_support( 'custom-logo', [
			'width'       => 163,
			'flex-height' => true,
			'header-text' => 'Vmv',
			'unlink-homepage-logo' => false, // WP 5.5
		] ); 
		// Регистрация меню
		register_nav_menus( [
			'header_menu' => 'Меню в шапке',
			'footer_menu' => 'Меню в подвале'
		] );
}
endif;
add_action( 'after_setup_theme', 'vmv_theme_setup' );

// Подключение стилей и скриптов; при time() - файл стилей не попадает в кэш на время разработки 
function enqueue_vmv_style() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_enqueue_style( 'vmv-theme', get_template_directory_uri( ) . '/assets/css/vmv-theme.css', 'style', time());
	wp_enqueue_style( 'Roboto-Slab', "https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap",);
}
add_action( 'wp_enqueue_scripts', 'enqueue_vmv_style' );