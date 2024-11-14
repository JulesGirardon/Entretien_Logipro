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
define( 'DB_NAME', 'ttbjulesg' );

/** Database username */
define( 'DB_USER', 'ttbjulesg' );

/** Database password */
define( 'DB_PASSWORD', 'txzgTJhifUa483D' );

/** Database hostname */
define( 'DB_HOST', 'techtest-db' );

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
define( 'AUTH_KEY',         '(]|^&^rzs_u!_uDDKLz~9&vyd N]sb auQ7A&q?9g> IF`aHUv2Az<mN%:[*WFBi' );
define( 'SECURE_AUTH_KEY',  'Kac]`I-`bl!zqHwa*f.d55WpobP@vD!OLEchRn0#oImvcUj/|{|LAV8jQsciD&.O' );
define( 'LOGGED_IN_KEY',    'H/Bgc4$l2)z06YTN9|ydvO4uq->wGG`OJkmw2h(v(.RD8p73HzpcFuz9>.9xGAl]' );
define( 'NONCE_KEY',        '4.c<|BRm8dZXYfSfopw*WZ#*$UX9C]TV?t|RBiX;~?*IKPQn0st40/y0$|eTDd(4' );
define( 'AUTH_SALT',        'Z^:HyV_>@?<fa?-Ub$ci[?zE,uLSq%iLcny&4JAjWH@L_i.>NK[@~N<{I={S@|zK' );
define( 'SECURE_AUTH_SALT', ',y5~:+ad^|*^C%r`>+^aC.@e[E^ok@]eUZuFPBZH<UnUia;vwl/1lSmIZpZQ:0Jf' );
define( 'LOGGED_IN_SALT',   'UI|C) Cd CF^nK=HY@=/3J9_-Fb/~ 45Qg@SiaF)AyT0xJJ6hwV$FVJ7Oq!TGZiM' );
define( 'NONCE_SALT',       'tn%fZ[r)4_8#t7-#r3i+7h*abiy|DM+KtXcixC1hshD`Mx[R wMy%7j-%>>bjzu4' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
