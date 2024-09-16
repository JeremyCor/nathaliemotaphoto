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
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',          'myH/2NPC3;{Xl:frLF35>qm_mi{7~LX_>yp6/F~wvQC#cc>#,cV$(4Q.=[WZ*smB' );
define( 'SECURE_AUTH_KEY',   'r411-0Vb.39Y#E78#c+bJCJ}k_tK|l!#jv:LDtzAy_b=):lq[G~*):hJl(-c/#7b' );
define( 'LOGGED_IN_KEY',     'X>d{bi=l~_+ B{pew<TH<uocNP8PG3dN!g@4|E>{WP2l!|sLW`VIQqeEX}9xab(b' );
define( 'NONCE_KEY',         '^,1jb*ABLER<aoof}%]}|J.ESared^B;ueA?Y*852JITs1!Hh?Rj%%an]+:t%akT' );
define( 'AUTH_SALT',         'Y?.1Jw[`!%8c>l!E$.)cD48rJRCe<p!Q1aS2MKP04!^&da%;j#cP4V21/wVx<WBT' );
define( 'SECURE_AUTH_SALT',  're!v_ry;GPP5<UF{gUp39#%m&^b0KJ4$P)9VUq$(;9Fu+~u4Dx6SItw&<j[e1tij' );
define( 'LOGGED_IN_SALT',    '=ro5;)^r$w3?@03DkQq5}rjeJLD>%h<G.]yA^Z@+!XU5299-:`-sOlU#Mu$q/GaO' );
define( 'NONCE_SALT',        'ub4@*C*:yI7py|zeZ!q./|v=>C97q~0>2!6T(~@;$1.A/lpFkCiUvDQs tpB^GWi' );
define( 'WP_CACHE_KEY_SALT', '6MhYR^h0W2wr-|MQF+@wzp5X;YkL/!akv@Q#[FT|:K(QNFrC,1PUle[^q9F}FAsN' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


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
	define('WP_DEBUG_LOG', false);
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
