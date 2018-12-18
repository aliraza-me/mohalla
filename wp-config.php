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
define('DB_NAME', 'alirazam_mohallah');

/** MySQL database username */
define('DB_USER', 'alirazam_mohalla');

/** MySQL database password */
define('DB_PASSWORD', 'Pakistan@143');

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
define('AUTH_KEY',         'i@MeF@G/k/.y;:JzS-0l>E}zZUH|<vZnt`K#>W%X hJ3B>i]GX:eg?KoKkaeM7%A');
define('SECURE_AUTH_KEY',  'js:$!WdBSwhUo~dMAp7mr_NOPbzAo0Yo{.^ntJ<5ED2}$#FBQyp^_9hJtTBK`Hog');
define('LOGGED_IN_KEY',    'IL<Y3UUMbFKv?@*aCz$2x)}& KIkNrZe3zv]b7wd`0@T{MKESuTWs1WPssCFuE@%');
define('NONCE_KEY',        '*3AJZqOnbzioSKDs;rTEDmz;0vIP)RTM[0#`W|0/Mmk1gpd~`NEUa:.[y$6>5_rL');
define('AUTH_SALT',        'hC2IG>BlVaj~BFz L!YR)OW t Zq,Ps0r&U.w1LC&0-~B`u7&Z?ng|*3X;0YIkmP');
define('SECURE_AUTH_SALT', 'vJ:?)>3T?$o<yX6ZR*~6E6ene7a9A>2ASO7%pt@3k$E)>9 $e0[M7C-&U VHX@sP');
define('LOGGED_IN_SALT',   'f@FpE}%mSWJ[cU7wD.q;N{dIA%c_$K#E&;Y>CRF__8Fj$,OnBH_wflp/]IH7`*}n');
define('NONCE_SALT',       'm7v#sb?L!31mKYm6HSq|lfhfCUJ}mPJ@@=Bc !$]X[7f<0utbj_[>2so@]pI[rdf');

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
