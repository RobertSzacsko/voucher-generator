<?php

/*
Plugin Name:  Voucher Generator
Plugin URI:   https://example.com/plugins/the-basics/
Description:  Simple plugin for generating vouchers for your purpose
Version:      1.0.0
Author:       Robert Szacsko
Author URI:   https://author.example.com/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  vg
Domain Path:  /languages/vg
*/

define('VG_PLUGIN_PATH', plugin_dir_path( __FILE__ ));
define('VG_SHORTCODE_POST_TYPE', 'vg_shortcode');

include_once VG_PLUGIN_PATH . 'class-vg.php';
include_once VG_PLUGIN_PATH . 'admin/class-vg-admin.php';

if (is_admin() === true) {
    $vg_admin_object = VG_Admin::get_instance();
} else {
    $vg_object = VG::get_instance();
}