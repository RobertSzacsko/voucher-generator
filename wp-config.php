<?php


if ($_SERVER['DESKTOP_SESSION'] === 'ubuntu' || strpos($_SERVER['SERVER_SOFTWARE'], 'Ubuntu') !== false) {
	require_once(ABSPATH . 'wp-config-linux.php');
} else {
	require_once(ABSPATH . 'wp-config-windows.php');
}

if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
	$_SERVER['HTTPS']='on';//
	$_SERVER['SERVER_PORT'] = 443;
}

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
