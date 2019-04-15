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

    <form id="modal-settings" method="post" action="get_modal_settings" class="modal-setings hide">
        <input id="field-id" type="hidden" name="field" value="" />
    </form>
</div>