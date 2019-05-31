<?php

class VG_Admin
{
    private static $instance = null;

    public $status_message;

    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ) );
        add_action( 'admin_notices', array( $this, 'maybe_display_notice' ) );

        // actions
        add_action( 'admin_post_vg_save_form', array( $this, 'save_form' ) );
        add_action( 'admin_post_vg_trash_form', array( $this, 'trash_form' ) );
        add_action( 'admin_post_vg_restore_form', array( $this, 'restore_form' ) );
        add_action( 'admin_post_vg_delete_form', array( $this, 'delete_form' ) );

        // AJAX actions
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
        wp_register_script( 'vg-admin-js', '/wp-content/plugins/voucher-generator/admin/js/admin.js', 'jquery', '1.0.0', true );
        wp_enqueue_script( 'vg-admin-js' );

        wp_register_style( 'vg-admin-radio-switch', '/wp-content/plugins/voucher-generator/admin/css/radio-switch.css', false, '1.0.0' );
        wp_enqueue_style( 'vg-admin-radio-switch' );

        wp_register_style( 'vg-admin-placeholder', '/wp-content/plugins/voucher-generator/admin/css/placeholder-input.css', array( 'vg-admin' ), '1.0.0' );
        wp_enqueue_style( 'vg-admin-placeholder' );
        wp_register_script( 'vg-admin-placeholder-js', '/wp-content/plugins/voucher-generator/admin/js/placeholder-input.js', 'jquery', '1.0.0', true );
        wp_enqueue_script( 'vg-admin-placeholder-js' );

        wp_register_script( 'vg-admin-search-js', '/wp-content/plugins/voucher-generator/admin/js/search.js', 'jquery', '1.0.0', true );
        wp_enqueue_script( 'vg-admin-search-js' );

        // bootstrap
        wp_register_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', false, '4.0.0' );
        wp_enqueue_style( 'bootstrap' );
        wp_register_script( 'bootstrap-popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', 'jquery', '1.12.9', true );
        wp_enqueue_script( 'bootstrap-popper' );
        wp_register_script( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', 'jquery', '4.0.0', true );
        wp_enqueue_script( 'bootstrap' );

        // include vgJSON object to be used in vg-admin-js script
        wp_localize_script( 'vg-admin-js', 'vgJSON', array( 'ajaxUrl' => admin_url( 'admin-ajax.php' ), 'formsPerPage' => get_option( 'vg_settings_forms_per_page', false ) ) );
    }

    public function add_admin_pages()
    {
        add_menu_page( __( 'Forms', 'vg' ), __( 'Voucher generator ', 'vg' ), 'manage_options', 'vg-list', array( $this, 'list_forms' ), 'dashicons-welcome-write-blog', 71 );
        add_submenu_page( 'vg-list', __( 'New form', 'vg' ), __( 'Add new Form ', 'vg' ), 'manage_options', 'vg-add-new', array( $this, 'add_form' ) );
        add_submenu_page( '', __( 'Edit form', 'vg' ), __( 'Edit Form ', 'vg' ), 'manage_options', 'vg-edit', array( $this, 'edit_form' ) );
    }

    public function list_forms()
    {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( __( 'You do not have permision to be here!', 'vg' ) );
        }

        $forms = $this->get_forms( array( 'post_status' => array( 'trash', 'any' ) ) );
        $statuses = array(
            'publish' => array(
                'html'  => _nx_noop( 'Published <span class="count">(%s)</span>', 'Published <span class="count">(%s)</span>', 'list-status', 'vg' ),
            ),
            'draft'     => array(
                'html'  => _nx_noop( 'Draft <span class="count">(%s)</span>', 'Draft <span class="count">(%s)</span>', 'list-status', 'vg' ),
            ),
            'trash'     => array(
                'html'  => _nx_noop( 'Trash <span class="count">(%s)</span>', 'Trash <span class="count">(%s)</span>', 'list-status', 'vg' ),
            )
        );

        while ( $status = current( $statuses ) ) {
            $curent_key = key( $statuses );

            if ( ( $count = count( $this->filter_forms_by_property( $forms, 'post_status', $curent_key ) ) ) === 0 ) {
                unset( $statuses[$curent_key] );
            } else {
                $statuses[$curent_key]['count'] = $count;
                next( $statuses );
            }
        }

        if ( ! isset( $_GET['forms_status'] ) || empty( $_GET['forms_status'] ) || ! in_array( $_GET['forms_status'], array_keys( $statuses ) ) ) {
            $forms = array_values( $this->filter_forms_by_property( $forms, 'post_status', 'publish' ) );
            $current_forms_status = 'publish';
        } else {
            $forms = array_values( $this->filter_forms_by_property( $forms, 'post_status', $_GET['forms_status'] ) );
            $current_forms_status = $_GET['forms_status'];
        }

        $forms_per_page = get_option( 'vg_settings_forms_per_page', false );

        require_once VG_PLUGIN_PATH . '/admin/views/list.php';
    }

    public function add_form()
    {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( __( 'You do not have permision to be here!', 'vg' ) ) ;
        }

        require_once VG_PLUGIN_PATH . '/admin/views/add-edit.php';
    }

    public function edit_form()
    {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( __( 'You do not have permision to be here!', 'vg' ) ) ;
        }
        if ( ! isset( $_GET['form_id'] ) || empty( $_GET['form_id'] ) ) {
            wp_die( __( "This page doesn't exists!", 'vg' ) ) ;
        }

        require_once VG_PLUGIN_PATH . '/admin/views/add-edit.php';
    }

    public function maybe_display_notice()
    {
        $notice = get_option( 'vg_admin_notice', false );
        if( $notice ) {
            delete_option( 'vg_admin_notice' );
            printf( '<div class="notice notice-%s is-dismissible"><p>%s</p></div>', $notice['type'], $notice['message'] );
        }
    }

    /* BEGIN ACTIONS */
    public function trash_form()
    {
        $form_id = $_POST['form_id'];
        if ( in_array( wp_trash_post( $form_id ), array( false, null ) ) ) {
            update_option( 'vg_admin_notice', array( 'type' => 'error', 'message' => __( 'Something goes wrong! Please try again.', 'vg' ) ) );
        }

        update_option( 'vg_admin_notice', array( 'type' => 'success', 'message' => sprintf( __( 'Form %s was successfully moved to trash!', 'vg' ), $form_id ) ) );

        wp_redirect( VG_URL_LIST, 302 );
        exit;
    }

    public function delete_form()
    {
        $form_id = $_POST['form_id'];
        if ( in_array( wp_delete_post( $form_id ), array( false, null ) ) ) {
            update_option( 'vg_admin_notice', array( 'type' => 'error', 'message' => __( 'Something goes wrong! Please try again.', 'vg' ) ) );
        }

        update_option( 'vg_admin_notice', array( 'type' => 'success', 'message' => sprintf( __( 'Form %s was successfully deleted!', 'vg' ), $form_id ) ) );

        wp_redirect( VG_URL_LIST, 302 );
        exit;
    }

    public function restore_form()
    {
        $form_id = $_POST['form_id'];

        wp_publish_post( $form_id );

        update_option( 'vg_admin_notice', array( 'type' => 'success', 'message' => sprintf( __( 'Form %s was successfully published!', 'vg' ), $form_id ) ) );

        wp_redirect( VG_URL_LIST, 302 );
        exit;
    }

    public function save_form()
    {
        $form = $this->vg_save_form($_REQUEST);

        $url = admin_url( 'admin.php?page=vg-list&status=' );
        if ($form instanceof WP_Error) {
            $this->status_message = __( 'Something goes wrong! Please try again.', 'vg' );
            wp_redirect($url . 'error', 302);
            exit;
        }

        $this->status_message = __( 'Form was successfully added!', 'vg' );
        wp_redirect($url . 'succes', 302);
        exit;
    }

    public function vg_save_form($data)
    {
        $form = $meta = array();
        if ( isset( $data['form_id'] ) && ! empty( $data['form_id'] ) ) {
            $form['ID'] = $data['form_id'];
        }

        if ( isset( $data['form-title'] ) && ! empty( $data['form-title'] ) ) {
            $form['post_title'] = $data['form-title'];
        }
        
        $form['post_status'] = 'publish';
        $form['post_type'] = VG_SHORTCODE_POST_TYPE;

        foreach( $data as $key => $sub_data ) {
            if ( is_array( $sub_data ) ) {
                $meta[$key] = $sub_data;
            }
        }

        $form['meta_input'] = array(
            '_vg_meta_fields' => $meta
        );

        return wp_insert_post( $form );
    }
    /* END ACTIONS */

    public function get_modal_settings()
    {
        $response = array();
        switch ( $_REQUEST['field'] ) {
            case 'radio' :
            case 'checkbox' :
                $response['textarea'] = array(
                    'text'          => __( 'Enter options ( value:label )', 'vg' ),
                );

                $response['required'] = array(
                    'radio_switch'  => __( 'This field is required?', 'vg' ),
                );
                break ;
            default :
                $response['label'] = array(
                    'radio_switch'  => __( 'Do you want to use a label?', 'vg' ),
                    'text'          => __( 'Enter the text', 'vg' ),
                );

                $response['placeholder'] = array(
                    'radio_switch'  => __( 'Do you want to use a placeholder?', 'vg' ),
                    'text'          => __( 'Enter the text', 'vg' ),
                );
                
                $response['required'] = array(
                    'radio_switch'  => __( 'This field is required?', 'vg' ),
                );
                break ;
        }
        wp_send_json( $response, 200 );
    }

    private function filter_forms_by_property( $array, $key, $filter_value )
    {
        return array_filter( $array, function( $item ) use ( $key, $filter_value ) {
            return $item->$key === $filter_value;
        } );
    }
    
    private function get_forms( $args = array() )
    {
        $default_args = array(
            'posts_per_page'    => -1,
            'post_type'         => VG_SHORTCODE_POST_TYPE
        );

        return get_posts( wp_parse_args( $args, $default_args ) );
    }
}