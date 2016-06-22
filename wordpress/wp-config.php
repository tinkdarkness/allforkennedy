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
define('DB_NAME', 'allforkennedy');

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
define('AUTH_KEY',         'r 4KW$+73NnS,bN1QiF.u380ROqp:h9mfa~xb_v#YVWJuw)/n-!9opKq)<Os$g,A');
define('SECURE_AUTH_KEY',  'Q$CC_-r:$y.5e@@i<VecB(+u_uP809fh7JG7T/8MM9Ie>9kWWSwu`N5Q2mG%Emua');
define('LOGGED_IN_KEY',    '1,o201X?@0]BQDtK!!!2N=0-1~n47|R5B[+9):/rPrgUbq&T8feWyy4U7dVAQ(J=');
define('NONCE_KEY',        'z<A3Nk+.p2z`Rriokih)&2VshJwyX3n9)K[s467K)L_lFH4l@bU:m)nO}M]-*#G|');
define('AUTH_SALT',        'orw]>#O:eBvk/AA&{qBeNl=LjDD-:QP}<*oy!$l~CY+T9p&,MBZ%QvGDk*viJm@9');
define('SECURE_AUTH_SALT', 'v2e>00Y#_jmqYF|@ISU{uip5tUHJIU7;~1lw_Px.1{PF!JWb[pF6(]s/GfNw3L!I');
define('LOGGED_IN_SALT',   'Eij*iJdsq$@^+rKxzR5c5>ANbbZIc5.#YZ2x%>*r2{O,GAmd*i+-@=DgoS#;zC-d');
define('NONCE_SALT',       '6,UGa$uj<.w8rL2p^H[]/3%XT|K)x]:K]9sy!~Pf!(<BiRtksmy&J?ng@GYCPBE~');

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
