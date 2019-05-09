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
define('DB_NAME', 'voucher-generator');

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
define('AUTH_KEY',         'ym<+H4M6`]Cm6W#Y}d>R__6DHNu1?i7e>$vnn&,a_.ZBd?CS1i2eoKD@q@[Z?CLB');
define('SECURE_AUTH_KEY',  'R_G$IAFo$FvJN87>c?4`o rHf6[!${N6?aC8Yc *d-{[7dqMNJcmrR*k[}<cHQIV');
define('LOGGED_IN_KEY',    'wd3vDLq}I]V*Xz,B>$b}y&J{g#yxzq%W(L%Dueek_4gJ)_JqN5hN15Yw`CMRrhxD');
define('NONCE_KEY',        '*`Ks(w,n#Apt*FW6i*|B^,XButBWgLA@0aEZ+Bq@JI9Mqjs#nAC^mS9+,]t1NzW]');
define('AUTH_SALT',        '?%}/ o3CfZP:Vj}]::Ql4o-.F3REHil[$lT[@O)ymphVe,_c`N!Y<V=CAjZ?ZBQo');
define('SECURE_AUTH_SALT', '1>4($>(yv6!33KY+s%`Y~1!BI#]hC#JRMjdt5(}zr|ykfuOIaR!cP{FrfVU@CmEU');
define('LOGGED_IN_SALT',   '*9f8*$tAjq*:9T6[9.ETlQhNgZq[.5;aupuh_n~VEe:KB2COw9fQT+qhp1hx>WM0');
define('NONCE_SALT',       '&MA*s~K!=)[xlfhy&kC xoSt-rrqlB&dW&,QQwX13T~n,}a,H6L#3`98G6=$EXjE');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'vg_';

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
define('WP_DEBUG', true);