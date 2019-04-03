<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form method="post" action="<?= admin_url( 'admin-post.php' ); ?>">
        <input type="hidden" name="action" value="vg_add_edit_forms" ?>
        <select>
            <?php $this->the_shortcodes(); ?>
        </select>
    </form>

    <main id="main">
        <div class="container">
            <div class="col col-sm-12 col-md-4">
                <div class="select-options-container">
                    <div class="select-options">
                        <div class="option-container">
                            <div class="input-text">Input text</div>
                        </div>
                        <div class="option-container">
                            <div class="input-email">Input email</div>
                        </div>
                        <div class="option-container">
                            <div class="input-date">Input date</div>
                        </div>
                        <div class="option-container">
                            <div class="input-number">Input number</div>
                        </div>
                        <div class="option-container">
                            <div class="input-checkbox">Input checkbox</div>
                        </div>
                        <div class="option-container">
                            <div class="input-radio">Input radio</div>
                        </div>
                        <div class="option-container">
                            <div class="textarea">Textarea</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-sm-12 col-md-8">
                <div class="target-container">
                    <div class="target">
                        <form class="form-class" action="">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>