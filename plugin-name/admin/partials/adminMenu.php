<?php
if (!current_user_can( 'manage_options' )) {
    return;
}
?>
<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    ddd
    <form action="options.php" method="post">
        <?php
        // output security fields for the registered setting "wporg_options"
        settings_fields( 'setting-group' );
        // output setting sections and their fields
        // (sections are registered for "wporg", each field is registered to a specific section)
        do_settings_sections( 'setting-group' );
        // output save settings button
        submit_button( __( 'Save Settings', 'textdomain' ) );
        ?>
    </form>
</div>