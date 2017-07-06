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
define('AUTH_KEY',         '7:3Q%Jfp0UFYyN*MFKS+!qi`s^o xTPbC_TVU}rHJC,mDiy(r#E5qL^D5/:(AkLW');
define('SECURE_AUTH_KEY',  'Rba%5!9Ex/D`hAI[W+()(QPG =Nb:B2088O113c##FuWR~bY&#N~|khp8Ax@b)d7');
define('LOGGED_IN_KEY',    '{pR&EiiXf<?/B%%%cx%_wVfirQk.$bY9}Iu|GHG`RM:uQq/`xhWreL?8~UBi$<(q');
define('NONCE_KEY',        '0gd{yPO0H0%c+@[VOBm$v)ZG2tbI231t#v!y;(g8,O8C,:rb+di8MOFcnf[vMxS+');
define('AUTH_SALT',        'sJI;PuddRt{`nr`J#+fL`fq)S:tuP?0Ydbbz_i}2/p00hXCbuB`[s}`Hkbmhg!lG');
define('SECURE_AUTH_SALT', 'XXCSHeQ+D^Xxv]; zeTnmFg7.PxB76EBwYR.*.1#}$.y17`?DEq$H5(IGa5#W|(w');
define('LOGGED_IN_SALT',   '_1&D)$~s1F^b}B<U/7@Q8J8iNZ)?wmFC}=Qp33lip?#3]7xL-*3#tWcbB!46LW#5');
define('NONCE_SALT',       '`? P-s+8NwEj)1D{;&>Gm/T_r/U-Z`W6w9SQG,ZFtIs>sRy!MOspV9<lX2]VAX!P');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp2_';

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
