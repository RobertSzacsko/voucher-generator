<?php

class VG_Admin
{
    private static $instance = null;

    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );
        add_action( 'admin_post_vg_add_edit_forms', array( $this, 'add_edit_action' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ) );
    }

    public static function get_instance()
    {
        if ( self::$instance === null ) {
            self::$instance = new VG_Admin();
        }
 
        return self::$instance;
    }

    public function enqueue_styles_scripts()
    {
        wp_enqueue_script( 'dragula-drag-drop', 'https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.js', array(), null, true);
        wp_register_style( 'vg-admin', '/wp-content/plugins/voucher-generator/admin/css/admin.css', false, '1.0.0' );
        wp_enqueue_style( 'vg-admin' );
        wp_register_script( 'vg-admin-js', '/wp-content/plugins/voucher-generator/admin/js/admin.js', 'jquery', '1.0.0', true);
        wp_enqueue_script( 'vg-admin-js' );
    }

    public function add_admin_pages()
    {
        add_menu_page( __( 'Add/Edit your Forms', 'vg' ), __( 'Voucher generator ', 'vg' ), 'manage_options', 'voucher-generator', array( $this, 'add_edit_vouchers_form' ), 'dashicons-welcome-write-blog', 71 );
    }

    public function add_edit_vouchers_form()
    {
        if ( ! current_user_can( 'manage_options' ) ) {
            die(__( 'You do not have permision to be here!', 'vg' ));
        }
        require_once VG_PLUGIN_PATH . '/admin/views/add-edit.php';
    }

    private function the_shortcodes()
    {
        echo $this->get_the_shortcodes();
    }

    private function get_the_shortcodes()
    {
        $shortcodes = $this->get_shortcodes();
        $html = '';

        foreach( $shortcodes as $shortcode )
        {
            $html .= '<option value="';
            $html .= $shortcode->ID . '">';
            $html .= $shortcode->post_title . '</option>';
        }

        return $html;
    }
    
    private function get_shortcodes()
    {
        return get_posts( array( 'numberposts' => -1, 'post_type' => VG_SHORTCODE_POST_TYPE ) );
    }
}