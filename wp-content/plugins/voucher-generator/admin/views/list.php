<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <a href="<?= VG_URL_ADD; ?>" class="page-title-action"><?php _e( 'Add New', 'vg'); ?></a>

    <div class="vg-list-search-statuses-container">
        <div class="vg-list-statuses-container vg-left">
            <?php
            if ( ( $count = count( $statuses ) ) > 0 ) { $last_key = array_keys( $statuses )[$count - 1]; }

            foreach ( $statuses as $status_name => $status ) {
                $class_curent_form_status = ( $current_forms_status === $status_name) ? 'vg-current-forms-status' : '' ;
                printf( '<a class="%s" href="%s&forms_status=%s">%s</a>', $class_curent_form_status , VG_URL_LIST, $status_name, sprintf( translate_nooped_plural( $status['html'], $status['count'] ), $status['count'] ) );
                if ( $status_name !== $last_key ) {
                    echo " | ";
                }
            } ?>
        </div>
        <div class="vg-list-search vg-right vg-placeholder-container">
            <input id="vg-js-search" class="vg-placeholder-input" type="text" name="vg-list-search-input" />
            <span class="vg-list-search-placeholder vg-placeholder-span"><?php _e( 'Search', 'vg' ); ?></span>
        </div>
        <div class="vg-clear-float"></div>
    </div>
    
    <main id="main">
        <div class="vg-container">
            <div class="vg-col vg-col-sm-12 vg-col-md-12">
                <div class="vg-table">
                    <div class="vg-container">
                        <div class="vg-col vg-col-sm-12 vg-col-md-12">
                            <div class="vg-header">
                                <div class="vg-container">
                                    <div class="vg-col-sm-8 vg-col-md-8">
                                        <div class="vg-container-title">
                                            <span class="vg-title"><?php _e( 'Title', 'vg' ); ?></span>
                                        </div>
                                    </div>
                                    <div class="vg-col-sm-4 vg-col-md-4">
                                        <div class="vg-container-date">
                                            <span class="vg-date"><?php _e( 'Date', 'vg' ); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="vg-body">
                                <?php if ( empty( $forms ) ): ?>
                                    <div class="vg-container">
                                        <div class="vg-col vg-col-sm-12 vg-col-md-12">
                                            <div class="vg-list-no-forms-container">
                                                <span class="vg-no-forms"><?= __( 'No forms found!', 'vg' ); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <?php foreach($forms as $key => $form): ?>
                                        <div class="vg-container vg-visibility<?php if ( $key >= $forms_per_page ) { echo ' vg-default-hide'; } ?>">
                                            <div class="vg-col vg-col-sm-8 vg-col-md-8">
                                                <div class="vg-container-title">
                                                    <span class="vg-title"><?php echo $form->post_title; ?></span>
                                                </div>
                                                <div class="vg-container-actions">
                                                    <?php if ( ! isset( $_GET['forms_status'] ) || $_GET['forms_status'] !== 'trash' ) : ?>
                                                        <a href="<?php printf( '%s&form_id=%d', VG_URL_EDIT, $form->ID ); ?>" class="vg-action vg-action-edit"><?php _ex( 'Edit', 'list form actions', 'vg' ); ?></a>
                                                         |
                                                        <form action="<?= admin_url( 'admin-post.php' ); ?>" method="post">
                                                            <input type="hidden" name="action" value="vg_trash_form" />
                                                            <input type="hidden" name="form_id" value="<?= $form->ID; ?>" />
                                                            <input type='submit' class="vg-action vg-action-trash" value="<?php _ex( 'Trash', 'list form actions', 'vg' ); ?>">
                                                        </form>
                                                    <?php else: ?>
                                                        <form action="<?= admin_url( 'admin-post.php' ); ?>" method="post">
                                                            <input type="hidden" name="action" value="vg_restore_form" />
                                                            <input type="hidden" name="form_id" value="<?= $form->ID; ?>" />
                                                            <input type='submit' class="vg-action vg-action-restore" value="<?php _ex( 'Restore', 'list form actions', 'vg' ); ?>">
                                                        </form>
                                                         |
                                                        <form action="<?= admin_url( 'admin-post.php' ); ?>" method="post">
                                                            <input type="hidden" name="action" value="vg_delete_form" />
                                                            <input type="hidden" name="form_id" value="<?= $form->ID; ?>" />
                                                            <input type='submit' class="vg-action vg-action-delete" value="<?php _ex( 'Delete permanently', 'list form actions', 'vg' ); ?>">
                                                        </form>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="vg-col vg-col-sm-4 vg-col-md-4">
                                                <div class="vg-list-date-container">
                                                    <span class="vg-date"><?php echo date_i18n( sprintf( '%s', get_option( 'date_format' ) ), strtotime( $form->post_date ) ); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <div class="vg-footer">
                                <div class="vg-container">
                                    <div class="vg-col-sm-8 vg-col-md-8">
                                        <div class="vg-container-title">
                                            <span class="vg-title"><?php _e( 'Title', 'vg' ); ?></span>
                                        </div>
                                    </div>
                                    <div class="vg-col-sm-4 vg-col-md-4">
                                        <div class="vg-container-date">
                                            <span class="vg-date"><?php _e( 'Date', 'vg' ); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="vg-container">
            <div class="vg-col vg-col-sm-12 vg-col-md-12">
                <div class="vg-list-load-more-forms-container vg-hide">
                    <input type="button" class="button vg-right vg-list-load-more-forms" value="<?= __( 'Load more Forms', 'vg' ); ?>" />
                    <div class="vg-clear"></div>
                </div>
            </div>
        </div>  
    </main>
</div>