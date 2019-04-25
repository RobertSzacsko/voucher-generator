<?php

class VG_Admin
{
    private static $instance = null;

    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );
        add_action( 'admin_post_vg_add_edit_forms', array( $this, 'add_edit_vouchers_form' ) );
        add_action( 'admin_post_vg_save_form', array( $this, 'action_save_form' ) );
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
        // dragula
        wp_enqueue_script( 'dragula-drag-drop', 'https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.js', array(), null, true );
        wp_register_style( 'dragula', '/wp-content/plugins/voucher-generator/admin/css/dragula.css', false, '1.0.0' );
        wp_enqueue_style( 'dragula' );

        wp_register_style( 'vg-admin', '/wp-content/plugins/voucher-generator/admin/css/admin.css', false, '1.0.0' );
        wp_enqueue_style( 'vg-admin' );
        wp_register_style( 'vg-admin-radio-switch', '/wp-content/plugins/voucher-generator/admin/css/radio-switch.css', false, '1.0.0' );
        wp_enqueue_style( 'vg-admin-radio-switch' );
        wp_register_script( 'vg-admin-js', '/wp-content/plugins/voucher-generator/admin/js/admin.js', 'jquery', '1.0.0', true );
        wp_enqueue_script( 'vg-admin-js' );

        // bootstrap
        wp_register_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', false, '4.0.0' );
        wp_enqueue_style( 'bootstrap' );
        wp_register_script( 'bootstrap-popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', 'jquery', '1.12.9', true );
        wp_enqueue_script( 'bootstrap-popper' );
        wp_register_script( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', 'jquery', '4.0.0', true );
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
            die( __( 'You do not have permision to be here!', 'vg' ));
        }
        require_once VG_PLUGIN_PATH . '/admin/views/add-edit.php';
    }

    public function action_save_form()
    {
        echo "<pre>";
        print_r($_REQUEST); die;
        
        $form_id = $this->save_form($_REQUEST);
    }

    public function get_modal_settings()
    {
        $response = array();
        switch ( $_REQUEST['field'] ) {
            case 'radio' :
            case 'checkbox' :
                $response['textarea'] = array(
                    'text' => __( 'Enter options ( value:label )', 'vg' ),
                );

                $response['required'] = array(
                    'radio_switch' => __( 'This field is required?', 'vg' ),
                );
                break ;
            default :
                $response['label'] = array(
                    'radio_switch' => __( 'Do you want to use a label?', 'vg' ),
                    'text' => __( 'Enter the text', 'vg' ),
                );

                $response['placeholder'] = array(
                    'radio_switch' => __( 'Do you want to use a placeholder?', 'vg' ),
                    'text' => __( 'Enter the text', 'vg' ),
                );
                
                $response['required'] = array(
                    'radio_switch' => __( 'This field is required?', 'vg' ),
                );
                break ;
        }
        wp_send_json( $response, 200 );
    }

    public function save_form($data)
    {
        $form = $meta = array();
        if (isset($data['form_id']) && !empty($data['form_id'])) {
            $form['ID'] = $data['form_id'];
        }

        if (isset($data['form-title']) && !empty($data['form-title'])) {
            $form['post_title'] = $data['form-title'];
        }
        
        $form['post_status'] = 'publish';
        $form['post_type'] = VG_SHORTCODE_POST_TYPE;

        foreach($data as $key => $sub_data) {
            if (is_array($sub_data)) {
                $meta[$key] = $sub_data;
            }
        }

        $form['meta_input'] = array(
            'vg_meta_fields' => $meta
        );

        $form_id_or_error = wp_insert_post($form);

        if ($form_id_or_error instanceof WP_Error) {
            // something goes wrong
        }

        // all good
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