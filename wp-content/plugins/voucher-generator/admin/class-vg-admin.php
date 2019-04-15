<?php

class VG_Admin
{
    private static $instance = null;

    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );
        add_action( 'admin_post_vg_add_edit_forms', array( $this, 'add_edit_action' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ) );

        add_action( 'wp_ajax_get_modal_settings', array( $this, 'get_modal_settings' ) );
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
        wp_register_style( 'dragula', '/wp-content/plugins/voucher-generator/admin/css/dragula.css', false, '1.0.0' );
        wp_enqueue_style( 'dragula' );
        wp_register_script( 'vg-admin-js', '/wp-content/plugins/voucher-generator/admin/js/admin.js', 'jquery', '1.0.0', true);
        wp_enqueue_script( 'vg-admin-js' );

        // bootstrap
        wp_register_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', false, '4.0.0' );
        wp_enqueue_style( 'bootstrap' );
        wp_register_script( 'bootstrap-jquery', 'https://code.jquery.com/jquery-3.2.1.slim.min.js', '', '3.2.1', true);
        wp_enqueue_script( 'bootstrap-jquery' );
        wp_register_script( 'bootstrap-popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', 'bootstrap-jquery', '1.12.9', true);
        wp_enqueue_script( 'bootstrap-popper' );
        wp_register_script( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', 'bootstrap-jquery', '4.0.0', true);
        wp_enqueue_script( 'bootstrap' );

        // include vgJSON object to be used in vg-admin-js script
        wp_localize_script( 'vg-admin-js', 'vgJSON', array( 'ajaxUrl' => admin_url( 'admin-ajax.php' ) ) );
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

    public function get_modal_settings()
    {
        // TODO aici ai ramas (merge cererea de ajax)   
        error_log(print_r($_REQUEST, 1));


        wp_die();
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