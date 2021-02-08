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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'narrative' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define('ENVIRONMENT', 'dev');

/* Multisite */
// define('WP_ALLOW_MULTISITE', true);
// define('MULTISITE', true);
// define('SUBDOMAIN_INSTALL', true);
// define('DOMAIN_CURRENT_SITE', 'spaceulation2.local');
// define('PATH_CURRENT_SITE', '/');
// define('SITE_ID_CURRENT_SITE', 1);
// define('BLOG_ID_CURRENT_SITE', 1);

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '{wmntI3k2;$iF%7Nv&D2|s7-=LU9$S:MZ(0 nO^0See8%usJRu31mU}}zM8^%fvz' );
define( 'SECURE_AUTH_KEY',  '$H$7@.d9n~34C=bK8}sdG.jFy!tFtg653gxvYIi}eP;NIa[($0RV9EAq?4V1rcP5' );
define( 'LOGGED_IN_KEY',    'OE{5J[[ h(3h`qp#2b$F-FU7Q+y5H|$pe&Yc22*6Xjfvir1C&*HH+9,Fv/Gh~tV9' );
define( 'NONCE_KEY',        'S3UsdB/.kE+}-dwL9yY0$@vxi(uPTPv,>]aR,O[$?]V-Yj7!VEe-y[e.V1L(I>Nb' );
define( 'AUTH_SALT',        'HQtpnd~qt3T]+7CzfcAbGUsS]%3DV:$qD? 0#4>6Sv3)m|OFiUt%$l,TwEX~IwyP' );
define( 'SECURE_AUTH_SALT', 'KNEVhTg_z`QXb$}2)@z*yEyWWl>RY-VldZ{Y(TBn}0Rqw3gx$wB3H)?^gZL5aM]E' );
define( 'LOGGED_IN_SALT',   'B2-I%k|)w}2?O=Nz(EQW2^_bC7r:>5R!$NQVhtU_BJI+m38`M~Y wh3{.s#^xNct' );
define( 'NONCE_SALT',       '7GVuq@_hV eQxY{F/UvZd@CcCA%Jl[-Q_T$IeDZpzHk$z},/2I<uQx,Pz5uw-u,>' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'sp_';

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


// define( 'WP_DEBUG', true );
// define('WP_DEBUG_DISPLAY', true);


define('SAVEQUERIES', true);
/* Multisite */
define( 'WP_ALLOW_MULTISITE', true );

define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', true);
define('DOMAIN_CURRENT_SITE', 'narrative.local');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

// define('ADMIN_COOKIE_PATH', '/');
// define('COOKIE_DOMAIN', '');
// define('COOKIEPATH', '');
// define('SITECOOKIEPATH', ''); 

define('COOKIE_DOMAIN', '.narrative.local'); // your main domain
define('COOKIEPATH', '/');
define('COOKIEHASH', md5('narrative.local')); // notice absence of a '.' in front

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
