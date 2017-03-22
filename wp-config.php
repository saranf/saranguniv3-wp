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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '1234');

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
define('AUTH_KEY',         'm1J-Gal:AOVn|gYj7W_!}eH ($amfx715`IG;58q&2n@g@2$ARBNyWUXx++P.lM3');
define('SECURE_AUTH_KEY',  'LvHQx 0S_Gu!:gU#Xp!R|@35}l?g9N-+)j6zIq0E+_?|Z3Oz[=)>R=->+|iO4+!!');
define('LOGGED_IN_KEY',    'MGqHGsR,/HBZOHx%5P]tGUM?(o?b9R?iyAB@Tl>L{Ln>*d=Wb;EFZT)@mWo|vfi<');
define('NONCE_KEY',        'aJ@ocG<Mb|n}-}+Yx$tS)e.5GQyW:|V()<|!Ae[{V=x{,>;4G{{%5*JW>0+oc#-D');
define('AUTH_SALT',        'j|@]Fslx%F3+&.7a$q(#uYQ/+a=e3ns|-$>s<W%8 -D]mdC(ouAi?kRG3hYw`{`}');
define('SECURE_AUTH_SALT', 'r1i0T<+3H[S&8+DW<t}B(?5|YcIXeNipYR@At<|Ca(#cM!bNnFcte`-bGn:Ah-*d');
define('LOGGED_IN_SALT',   'NHkrP.SwXeZm-6{P1qre9t)U7T9ACF3O=n+0S3B;_j]sOnr7,d(Sq,GW5R*48Z@r');
define('NONCE_SALT',       '0)n_&WwE4g}*u-hB7{>H$mJ&6p]}YE~H3N+$^`]^$ku@o0XP`AU/Hi2M{Bjp1[:9');

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

//define('RELOCATE',true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
