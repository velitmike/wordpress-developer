<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'wordpress_developer' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'wordrpess_admin' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', 'riOxSgT4CKANWgjn' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'uGykhp!2!3RlBq2:(b63gsUf/rbU4B>[ERtr:&>EKLvsU^3E(qwxX1Xx-t/lL[D8' );
define( 'SECURE_AUTH_KEY',  'k0HAp?0 p_hx;~(BFbnQ9UARF^T/k 9aIBE,X:)5_vud:O)Pc64|>(;HQ0{BDc6!' );
define( 'LOGGED_IN_KEY',    '}5)F^4~07#)b,L9BU$>(k:5^MZwtN,QLp1,G=eY(m_XcBz Gyltxqd%;u>n}.4E@' );
define( 'NONCE_KEY',        'nmZp2DT<?b>q~(@w/#v|uk<U=TwA^/DbiB>%~n ?kd).:j5woh{+>YY=)TRa=vqK' );
define( 'AUTH_SALT',        'A7Zw@94BS:FoD.w$gzxQ.Ij.g.WXy9PcE>~_^I UyrZ`[|V/&]Vx:CZE,<VB`YI ' );
define( 'SECURE_AUTH_SALT', 'qeFVJ/eFNptC]/]vS)Z8EbMmS4b/e{I2H(`#RXaGaCfFJeC0xy?aHr`ol-|^Ykw2' );
define( 'LOGGED_IN_SALT',   't&*,1UM]RKxh}PE_Srr81swTqiPT8S^FNe}B#bn-kyrcFYsfg 5&@%F;p H_vYgz' );
define( 'NONCE_SALT',       '|i4QoE|0nHaFK[g.A/IYB1cOfpoKLX7A$J/#98KMIZSQ;GOi>-z#lCnAKZQAC_h(' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', true );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once( ABSPATH . 'wp-settings.php' );
