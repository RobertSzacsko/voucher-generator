<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form method="post" action="<?= admin_url( 'admin-post.php' ); ?>">
        <input type="hidden" name="action" value="vg_add_edit_forms" ?>
        <select>
            <?php $this->_the_shortcodes(); ?>
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
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint alias vitae temporibus fugiat, accusantium error atque molestias veniam, reprehenderit repudiandae iure nulla pariatur inventore assumenda. Alias illum exercitationem eos odit.
            </div>
        </div>
    </main>
</div>