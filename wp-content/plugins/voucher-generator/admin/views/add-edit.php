<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form method="post" action="<?= admin_url( 'admin-post.php' ); ?>">
        <input type="hidden" name="action" value="vg_add_edit_forms" />
        <select>
            <?php $this->the_shortcodes(); ?>
        </select>
    </form>

    <main id="main">
        <div class="vg-container">
            <div class="vg-col vg-col-sm-12 vg-col-md-4">
                <div class="select-options-container">
                    <div class="select-options">
                        <div class="option-container grab">
                            <div class="text">Input text</div>
                        </div>
                        <div class="option-container grab">
                            <div class="email">Input email</div>
                        </div>
                        <div class="option-container grab">
                            <div class="date">Input date</div>
                        </div>
                        <div class="option-container grab">
                            <div class="number">Input number</div>
                        </div>
                        <div class="option-container grab">
                            <div class="checkbox">Input checkbox</div>
                        </div>
                        <div class="option-container grab">
                            <div class="radio">Input radio</div>
                        </div>
                        <div class="option-container grab">
                            <div class="textarea">Textarea</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="vg-col vg-col-sm-12 vg-col-md-8">
                <div class="target-container">
                    <form class="form-class" action="">
                    </form>
                </div>
            </div>
        </div>
    </main>

    <div id="general-modal" class="modal fade hide" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php _e( 'Settings', 'vg' ); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div id="label-col">
                        <div class="row">
                            <div class="col-sm-9 col-md-9">
                                <span id="label-radio_switch-span" class="align-vertical"></span>
                            </div>
                            <div class="col-sm-3 col-md-3">
                                <label class="switch">
                                    <input type="checkbox" name="label[radio_switch]">
                                    <span class="slider round"></span>
                                </label>
                                <div class="clear-float"></div>
                            </div>
                        </div>
                        <div class="hide row second-row">
                            <div class="col-sm-12 col-md-6">
                                <span id="label-text-span" class="align-vertical"></span>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <input type="text" name="label[text]">
                                <div class="clear-float"></div>
                            </div>
                        </div>
                    </div>

                    <div id="placeholder-col">
                        <div class="row">
                            <div class="col-sm-9 col-md-9">
                                <span id="placeholder-radio_switch-span" class="align-vertical"></span>
                            </div>
                            <div class="col-sm-3 col-md-3">
                                <label class="switch">
                                    <input type="checkbox" name="placeholder[radio_switch]">
                                    <span class="slider round"></span>
                                </label>
                                <div class="clear-float"></div>
                            </div>
                        </div>
                        <div class="hide row second-row">
                            <div class="col-sm-12 col-md-6">
                                <span id="placeholder-text-span" class="align-vertical"></span>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <input type="text" name="placeholder[text]">
                                <div class="clear-float"></div>
                            </div>
                        </div>
                    </div>

                    <div id="required-col">
                        <div class="row">
                            <div class="col-sm-9 col-md-9">
                                <span id="required-radio_switch-span" class="align-vertical"></span>
                            </div>
                            <div class="col-sm-3 col-md-3">
                                <label class="switch">
                                    <input type="checkbox" name="required[radio_switch]">
                                    <span class="slider round"></span>
                                </label>
                                <div class="clear-float"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary vg-save-btn"><?php _e( 'Save', 'vg' ); ?></button>
            </div>
            </div>
        </div>
    </div>

    <div id="special-modal" class="modal fade hide" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php _e( 'Settings', 'vg' ); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div id="textarea-col">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <span id="textarea-text-span" class="align-vertical"></span>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <textarea name="textarea[text]"></textarea>
                                <div class="clear-float"></div>
                            </div>
                        </div>
                    </div>

                    <div id="required-col">
                        <div class="row">
                            <div class="col-sm-9 col-md-9">
                                <span id="required-radio_switch-span" class="align-vertical"></span>
                            </div>
                            <div class="col-sm-3 col-md-3">
                                <label class="switch">
                                    <input type="checkbox" name="required[radio_switch]">
                                    <span class="slider round"></span>
                                </label>
                                <div class="clear-float"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary vg-save-btn"><?php _e( 'Save', 'vg' ); ?></button>
            </div>
            </div>
        </div>
    </div>

    <form id="modal-settings" method="post" action="get_modal_settings" class="modal-setings hide">
        <input id="field-id" type="hidden" name="field" value="" />
    </form>
</div>