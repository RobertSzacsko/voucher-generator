<?php

class VG_Admin
{
    private static $instance = null;

    private function __construct()
    {
        add_menu_page( __( 'Voucher generator', 'vg' ), __( 'Voucher generator', 'vg' ), 'manage_options', 'voucher-generator', array($this, 'add_edit_vouchers_form'), 'dashicons-welcome-write-blog', 81);
    }

    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new VG_Admin();
        }
 
        return self::$instance;
    }

    public function add_edit_vouchers_form()
    {
        
    }
}