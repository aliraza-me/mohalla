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
define('DB_NAME', 'mohalla');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         ')sFq-~K,Eh{L:u I2ZXoS: Z[TCglf?BzBD&0}Rq4Kn]R;:@3MGwB}[;q[JF4m~p');
define('SECURE_AUTH_KEY',  'm*>l,&masw~k1@:;==xz1c&@[1jD@iI)GC3G+$>#,xc91HOPc:Jtnn7U;(CjT86d');
define('LOGGED_IN_KEY',    '!ru,q{))vgeH!:$j}.$_@JU{Nz^HYrc4>vN:1R%el_L: ^]HzSDQ]YlYiMX+;q/G');
define('NONCE_KEY',        '8Bi1pdG9zlRH)tE2F[?zk^k+.j<n d4>N(R2G)VyCh:5y2+yKUY2oFkuk6yvQh&s');
define('AUTH_SALT',        'l_Oh3pKWu;CM=MPXU<wkx,DI.}cZ$g#YDwZ,E_}zpg!#f}Yq}F:Ezp.c5q8vG@zj');
define('SECURE_AUTH_SALT', 'Vv$T0i^QumAt#wfxos,bA)NkjjYnf^7@v$mb^.Rr!dop#{1ML*:.12?pF9uH_sPL');
define('LOGGED_IN_SALT',   'ehuR3e1b;7iI(qml=*A%oRt!@qR4!=(|0sGb-/|@LJj<MizyE[QsLry^M.U_G:E,');
define('NONCE_SALT',       ')N4s!y|_$K[Q83waS9Y?:e~w+2OK5XnW1m-_qIy^u[2oDM7[YeOGJpCSE;b|_[hX');

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
