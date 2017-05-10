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
define('DB_NAME', 'jurnalistclub');

/** MySQL database username */
define('DB_USER', 'jurnalistclub');

/** MySQL database password */
define('DB_PASSWORD', 'jurnalistclub');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         's[=^_e/CG*g$!fAeM9w[dWXRQ6x@_oH%rK>`U~R|JADsosrawvVk{xgP(/}PaDfp');
define('SECURE_AUTH_KEY',  'vfOJ2H8FUUk-?5)~LW{ZPClkIbeKO>7Z|*i_DC&J{<nov>p?RvX=T)C14;/e+3v&');
define('LOGGED_IN_KEY',    'bmr6:,dGhyupJB@ 66s@;~ht!Vu_X@ggoa&:i!=Amw*2<Nb8Ll2?pl=iYpxBH7p9');
define('NONCE_KEY',        'UrF^DBf-aUl%F6x+<VJB)7$ZduB?ScCR|V//]30&:av6|n#n),A~/r.8NCL{LMy(');
define('AUTH_SALT',        'Jx.(!Yq.l[me=j#Xe,k55Ieamb^XYUKrPZ!;>~j1u85+ULc`G(ZDm%s~;g9zVowh');
define('SECURE_AUTH_SALT', 'zxL;X{MIjds)ufhVG*P,TDu;V0,IA6Rv-?msgmpKrBi)p*P<[3eYSAZtbDJ?=^4e');
define('LOGGED_IN_SALT',   'S,EF604,ubeM59=LQ4I,0j#D>Z*2_)}{y6Fjvd#v!1?=sDyWvAhJud8$r}Wg.l]?');
define('NONCE_SALT',       '}j1(t>5pq$jz1+]CfKH3=mAYPn3+ZjQBBZDhytC:a}v/(YjUlp ,VlU>[M:~v9Wn');

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
