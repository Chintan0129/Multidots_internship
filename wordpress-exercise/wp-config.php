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
define( 'AUTH_KEY',          ' D_%A<PSL@! Dpj4S~8_4gAdM+g^!b,1[u{.|;SKF@BZg29,3GB{ttdD60qU^<.{' );
define( 'SECURE_AUTH_KEY',   'Rle!9tE]Sxuz,+W``kw1hgNI$V&t~8,Aj:)ulu6^!_wleSgNIn$B5M]o?[C [ZGr' );
define( 'LOGGED_IN_KEY',     '[3`biXT{2 >dS4_i!>S#YNl}1)pNnpUBuSQ2vn|VnbxP/8<WNOrfwm^Jy,?zQ:E6' );
define( 'NONCE_KEY',         'GH$ K$O|qfkZ_4tXfWFj$ih4nQG0KgM&!jO 9yVo`un9U5zM*aFU{ok$H+y*JGqc' );
define( 'AUTH_SALT',         ' WQcKsBUU*Z,g4dljSv.RUhF)y|Q@I,<R&L8)SLgt&84GeQol|GeqV?G)ljnx-zc' );
define( 'SECURE_AUTH_SALT',  '64[+X:XvQ$NI=Vnd7|K31`BE6y^o0W K]3#FoDeOi|J7W19M%FFu-dbRGaE`}w o' );
define( 'LOGGED_IN_SALT',    'QC{RJ]gh]AVM9Z1Fs-X@d3888gMZ8V&/]ujT[HS7aL{OchzG,c1<@4z~E3(3f%vx' );
define( 'NONCE_SALT',        '7u^TT+Ar=c^qgSm&+c+]unp!BB!z7XCoHKJtkV5&idUP1M,p.&t?wthaMd<^>{;`' );
define( 'WP_CACHE_KEY_SALT', 'OI{$EuOwzYPD:[k}AB3ARdj6*Y|!4gh3@qETK+n5R{195]hkE/nvI&i)om5_#Qar' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'portfolio_';


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

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
