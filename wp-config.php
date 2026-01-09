<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'nextmoves_blog' );

/** Database username */
define( 'DB_USER', 'nextmoves_blog' );

/** Database password */
define( 'DB_PASSWORD', 'HqRQZ3!rd;j7^0D8' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'W- ##,>?/VVR6r61_N/30u5t+Pv->~]RHgukt/Es{U,(I;QFd+g~-rN$b4WxJ`Vu');
define('SECURE_AUTH_KEY',  'Kv; TalRZW30+4&slwfc>~N|e9)y4]VcG!Xqt(@$)lf<{.|Z5N+D5~dQ(K]c n0p');
define('LOGGED_IN_KEY',    '+1E[KfxeWZl[WtmQt?aCK<0KjFq-q~|l+hD7_2H$V%gs;t k|grp@QK5M=GT`MiO');
define('NONCE_KEY',        'qwKQE+Z~d+/2zrbyC>[F/{Cib=W|DE#>^G1P?U|E;+%X),WTP)F1pjEwYW,|hV&4');
define('AUTH_SALT',        'M:WxR{9aaeN@.g-7jMgF.QgT5_$`;ky[Tp>UUK%Ed{5rT>0EJ]xI;h4tDq[kbC{5');
define('SECURE_AUTH_SALT', 'WN.$% m,Jx+bI0vXm+6!urOi2<+!oGEAA+FN6W=$kl;=x*3BX+<-c|$D6n(ig(,^');
define('LOGGED_IN_SALT',   'Igtcv1BLo&/?/k0F(YHn@Gl*|}{Xy33KS#BH[0-`TN-BQV)U3&C~N>ZeS*}i@=8I');
define('NONCE_SALT',       '5zY<,1D)}S@FvI5Uf`+4#^U8h=Ae@e=|U%q-atFo]VROI]Uj]5AZ+I|sJ|NI+VmW');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
