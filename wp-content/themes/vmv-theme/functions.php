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
 * Подключаем сайдбар (widget area).
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function vmv_theme_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar on main top', 'vmv_theme'),
			'id'            => 'main-sidebar',
			'description'   => esc_html__('Add widgets here.', 'vmv_theme'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar on main bottom', 'vmv_theme'),
			'id'            => 'main-sidebar-bottom',
			'description'   => esc_html__('Add widgets here.', 'vmv_theme'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'vmv_theme_widgets_init');


/**
 * Добавление нового виджета Downloader_Widget.
 */
class Downloader_Widget extends WP_Widget
{

	// Регистрация виджета используя основной класс
	function __construct()
	{
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'downloader_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: downloader_widget
			'Полезные файлы',
			array('description' => 'Файлы для скачивания', 'classname' => 'widget-downloader',)
		);

		// скрипты/стили виджета, только если он активен
		if (is_active_widget(false, false, $this->id_base) || is_customize_preview()) {
			add_action('wp_enqueue_scripts', array($this, 'add_downloader_widget_scripts'));
			add_action('wp_head', array($this, 'add_downloader_widget_style'));
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget($args, $instance)
	{
		// $title = apply_filters('widget_title', $instance['title']);
		$title = $instance['title'];
		$description = $instance['description'];
		$link = $instance['link'];

		echo $args['before_widget'];
		if (!empty($title)) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		if (!empty($description)) {
			echo '<p>' . $description . '</p>';
		}
		if (!empty($link)) {
			echo '<a target="_blank" class="widget-link" href="' . $link . '">
			<img class="widget-link-icon" src="' . get_template_directory_uri() . '/assets/images/download.svg">
			Скачать</a>';
		}
		// echo __('Hello, World!', 'text_domain');
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form($instance)
	{
		$title = @$instance['title'] ?: 'Полезные файлы';
		$description = @$instance['description'] ?: 'Описание';
		$link = @$instance['link'] ?: 'http://yandex.ru';
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Описание:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>" type="text" value="<?php echo esc_attr($description); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Ссылка на файл:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>">
		</p>
	<?php
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update($new_instance, $old_instance)
	{
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['description'] = (!empty($new_instance['description'])) ? strip_tags($new_instance['description']) : '';
		$instance['link'] = (!empty($new_instance['link'])) ? strip_tags($new_instance['link']) : '';

		return $instance;
	}

	// скрипт виджета
	function add_downloader_widget_scripts()
	{
		// фильтр чтобы можно было отключить скрипты
		if (!apply_filters('show_my_widget_script', true, $this->id_base))
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url . '/my_widget_script.js');
	}

	// стили виджета
	function add_downloader_widget_style()
	{
		// фильтр чтобы можно было отключить стили
		if (!apply_filters('show_my_widget_style', true, $this->id_base))
			return;
	?>
		<style type="text/css">
			.my_widget a {
				display: inline;
			}
		</style>
	<?php
	}
}
// конец класса Downloader_Widget
// регистрация Downloader_Widget в WordPress
function register_downloader_widget()
{
	register_widget('Downloader_Widget');
}
add_action('widgets_init', 'register_downloader_widget');
// Конец регистрация Downloader_Widget в WordPress



/**
 * Добавление нового виджета SocialNetworks_Widget.
 */
class SocialNetworks_Widget extends WP_Widget
{

	// Регистрация виджета используя основной класс
	function __construct()
	{
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'socialNetworks_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: socialNetworks_widget
			'Социальные сети',
			array('description' => 'Ссылки на соцсети', 'classname' => 'widget-socialNetworks',)
		);

		// скрипты/стили виджета, только если он активен
		if (is_active_widget(false, false, $this->id_base) || is_customize_preview()) {
			add_action('wp_enqueue_scripts', array($this, 'add_socialNetworks_widget_scripts'));
			add_action('wp_head', array($this, 'add_socialNetworks_widget_style'));
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget($args, $instance)
	{
		$title = $instance['title'];
		$facebook = $instance['facebook'];
		$twitter = $instance['twitter'];
		$youtube = $instance['youtube'];

		echo $args['before_widget'];
		if (!empty($title)) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		if (!empty($facebook)) {
			echo '<a target="_blank" class="widget-link" href="' . $facebook . '">
			<img class="widget-facebook-icon" src="' . get_template_directory_uri() . '/assets/images/facebook.svg">
			</a>';
		}
		if (!empty($twitter)) {
			echo '<a target="_blank" class="widget-link" href="' . $twitter . '">
			<img class="widget-twitter-icon" src="' . get_template_directory_uri() . '/assets/images/twitter.svg">
			</a>';
		}
		if (!empty($youtube)) {
			echo '<a target="_blank" class="widget-link" href="' . $youtube . '">
		<img class="widget-youtube-icon" src="' . get_template_directory_uri() . '/assets/images/youtube.svg">
			</a>';
		}
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form($instance)
	{
		$title = @$instance['title'] ?: 'Наши соцсети';
		$facebook = @$instance['facebook'] ?: 'http://facebook.com';
		$twitter = @$instance['twitter'] ?: 'http://twitter.com';
		$youtube = @$instance['youtube'] ?: 'http://youtube.com';
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Фейсбук'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo esc_attr($facebook); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Твиттер'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo 	esc_attr($twitter); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e('Youtube'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" name="<?php echo $this->get_field_name('youtube'); ?>" type="text" value="<?php echo
			esc_attr($youtube); ?>">
		</p>
	<?php
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update($new_instance, $old_instance)
	{
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['facebook'] = (!empty($new_instance['facebook'])) ? strip_tags($new_instance['facebook']) : '';
		$instance['twitter'] = (!empty($new_instance['twitter'])) ? strip_tags($new_instance['twitter']) : '';
		$instance['youtube'] = (!empty($new_instance['youtube'])) ? strip_tags($new_instance['youtube']) : '';

		return $instance;
	}

	// скрипт виджета
	function add_socialNetworks_widget_scripts()
	{
		// фильтр чтобы можно было отключить скрипты
		if (!apply_filters('show_my_widget_script', true, $this->id_base))
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url . '/my_widget_script.js');
	}

	// стили виджета
	function add_socialNetworks_widget_style()
	{
		// фильтр чтобы можно было отключить стили
		if (!apply_filters('show_my_widget_style', true, $this->id_base))
			return;
	?>
		<style type="text/css">
			.my_widget a {
				display: inline;
			}
		</style>
<?php
	}
}
// конец класса SocialNetworks_Widget

// регистрация SocialNetworks_Widget в WordPress
function register_socialNetworks_widget()
{
	register_widget('SocialNetworks_Widget');
}
add_action('widgets_init', 'register_socialNetworks_widget');


// Подключение стилей и скриптов; при time() - файл стилей не попадает в кэш на время разработки 
function enqueue_vmv_style()
{
	wp_enqueue_style('style', get_stylesheet_uri());
	wp_enqueue_style('vmv-theme', get_template_directory_uri() . '/assets/css/vmv-theme.css', 'style', time());
	wp_enqueue_style('Roboto-Slab', "https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap",);
}
add_action('wp_enqueue_scripts', 'enqueue_vmv_style');

// Изменяем настройки облака тегов
add_filter('widget_tag_cloud_args', 'edit_widget_tag_cloud_args');
function edit_widget_tag_cloud_args($args)
{
	$args['unit'] = 'px';
	$args['smallest'] = '14';
	$args['largest'] = '14';
	$args['number'] = '13';
	return $args;
}


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
