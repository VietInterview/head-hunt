<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'vietinterview_hunt');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'L)#.Nb7XE!&#i}tmglV.t,FK!Y0l|Eo5?`z%UOoWinvI{zy?46,-5PSflb3r8a<2');
define('SECURE_AUTH_KEY',  '*4z>eY/3<2JEkA6+<yuLzVzt1~M@K*?x}!&AR1+^?U0K{7H?kLMZj9kWvJW$[&@.');
define('LOGGED_IN_KEY',    '$0&P-f{:!PY(=1(4(JAgvf3i53_3$zsMDr6Ry6<,$TcP?duyvV<}LZ=|JuSrS:MH');
define('NONCE_KEY',        ')J!O|xE2.:)+1Mkz8;>AL?YJ1~Ou`:Q;,Gl*7fOx4tOqhaQX?V!#sgiDn.Kh~NtG');
define('AUTH_SALT',        'N*DTC2SOh{mrf#Y_o9Lm1#s5*1;8iDSg?]doeCLQ8]wMGTU9:K2@T02TiM/3k)BE');
define('SECURE_AUTH_SALT', '`n6T&1E*o1V0{H Qjc- A/yNLcJ{R7/v~rX(7n( +obhP?}]-_qd-#|o*22J^}+A');
define('LOGGED_IN_SALT',   ' RCR6u0gZA}4tny_+j5b-k/tJZDRr[4q%;&}~:Oj8Mt808d6r(O:j+})sTbN(K4-');
define('NONCE_SALT',       '{A>BlUBm%r{X}{[s6odk`Li?pcpFCx9dD3i./3NAcNSMYmtx2@1PId9ztizW,@V6');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
