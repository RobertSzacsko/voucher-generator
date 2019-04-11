<?php

if ($_SERVER['DESKTOP_SESSION'] === 'ubuntu' || strpos($_SERVER['SERVER_SOFTWARE'], 'Ubuntu') !== false) {
	require_once(ABSPATH . 'wp-config-linux.php');
} else {
	require_once(ABSPATH . 'wp-config-windows.php');
}