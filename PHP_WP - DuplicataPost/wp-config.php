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
define( 'DB_NAME', 'wp' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'rJ$74ShC*,MoI>fW(GV|k!b29,~0mk?_$wR}m!p7v87e|Vw!2?Er,g&E]B1R4i8}' );
define( 'SECURE_AUTH_KEY',  '?KVQw7wV~5ueYghECMN?^gan]qOrN;Js[>tm^SKawZ!au{/|unc 9}B_fF7@*lH=' );
define( 'LOGGED_IN_KEY',    'T@/DfB [-0=2);Z],PcqNUC+iQif!Eyy[++v>O|mnCT&HgDF$H:c|LU6eXWJx{*5' );
define( 'NONCE_KEY',        'h0lr`KM$,.|UX:JKLk^X+3|(I~|ijgloKT9B*Au3-dG9#mn}tv||]?6M[K,2||+0' );
define( 'AUTH_SALT',        '72-AOFSru~*$$QlHN0/O5;ea-PI $>r`uJCr+Q/Vf[F& J1;!U+ZN1bLHc2$yjmt' );
define( 'SECURE_AUTH_SALT', 'm.`T~$:Hi[pxI0tZYF_BujTx+X:Y~*NS/u!Tpi?wmX+7;^QSxe[_Q?5TV7e M iu' );
define( 'LOGGED_IN_SALT',   ')x^IaJ:JK[o[g}NHR<r.oYCawlCIc@[LU%C8bDz nly`/e4 Dk!4gHDB!ZESBQ@K' );
define( 'NONCE_SALT',       'N/XqRxhB6if?.S?@YC-`aoIr2rzK#rVJjiP&?fIcLfY%kuo^O4.}^LpJ&vJ# gCW' );

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
