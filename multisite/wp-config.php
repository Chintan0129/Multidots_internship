<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'training_chintans' );

/** Database username */
define( 'DB_USER', 'training_chintans' );

/** Database password */
define( 'DB_PASSWORD', 'ctR0P7ySGdaYkrl1' );

/** Database hostname */
define( 'DB_HOST', '172.104.166.158' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          '^Tjli>hKE3CENI0O?b7i T0B rEwr|fwxRHm~:;:d&TmxaBle0P#bY2HY#(`REVV' );
define( 'SECURE_AUTH_KEY',   'G`eJWU)Al-[MvShz/4gj+N5?:u9Z*0`?TQPFq+J[BMg30o`%Q>2PK(|mr1//juoT' );
define( 'LOGGED_IN_KEY',     '[*!h>qp8(ydUp6vF%_>UlLuO+|PYYj>(8AR2S/z JWGhV]AKU9Cnq{W@,xx6O%;3' );
define( 'NONCE_KEY',         '9x(Y2`s#qH(`Gu@hEh7&1iIIU6{3:* K^RvKQ)*BndHa05eA>|<@kl21bG^BW8V,' );
define( 'AUTH_SALT',         'D{$-/as!ul$g8FfQ^i{[l80N-IIp#,}y1UGpMsX4VS9x+RuJF}_1OBXW)|_hN?lI' );
define( 'SECURE_AUTH_SALT',  '>GhGNJ9j5zL piU7zBuB&#o1K>?[* ]KjNL&gQW#3uaq95jnO@*0D&4iRraXjo@#' );
define( 'LOGGED_IN_SALT',    '[6AXlCG%>C`vzg;]IIqQ>cPl*V[OaBIZ@N-$`a?W% 0[fXnJeOr7CY1t8o>g:.]*' );
define( 'NONCE_SALT',        ')Lg*F~1taLbZAfem@2F[I U-|+b20!l@se@`da1 v>P59yVgnO!ml.5E&A< Wg$p' );
define( 'WP_CACHE_KEY_SALT', '2${+*w/~6fWB$51T&,78G*U eK2W1P5*rTac~V=Vj[k;Gbvmn?H,ad-@KwU%b.,Q' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'multisite_';


/* Add any custom values between this line and the "stop editing" line. */



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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}
define('WP_ALLOW_MULTISITE',true);
define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', false );
define( 'DOMAIN_CURRENT_SITE', 'training-chintans.md-staging.com' );
define( 'PATH_CURRENT_SITE', '/multisite/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );
define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
