<?php 

/**
 * SF option and settings
 */
function wporg_settings_init() {
    // Register a new setting for "wporg" page.
    register_setting( 'sf_options', 'sf_mail_address' );
    register_setting( 'sf_options', 'sf_mail_body' );
    register_setting( 'sf_options', 'sf_mail_success_msg' );
 
    // Register a new section in the "options" page.
    add_settings_section(
        'sf_section_one',
        __( 'Form Settings', SF_TEXT_DOMAIN ), 'sf_section_one_callback',
        'sf_options'
    );
 
    // Register a new field in the "sf_section_one" section, inside the "options" page.
    add_settings_field(
        'sf_mail_to_field',
        __( 'Recipient Email Address', SF_TEXT_DOMAIN ),
        'sf_mail_to_field_cb',
        'sf_options',
        'sf_section_one'
    );
 
    // Register a new field in the "sf_section_one" section, inside the "options" page.
    add_settings_field(
        'sf_mail_body_field',
        __( 'Message Pattern (mail-body) <small>You can use the following field keys to generate them dynamically. <br> %firstName%<br>%lastName%<br>%email%<br>%subject%<br>%message%</small>', SF_TEXT_DOMAIN ),
        'sf_mail_body_field_cb',
        'sf_options',
        'sf_section_one'
    );
 
    // Register a new field in the "sf_section_one" section, inside the "options" page.
    add_settings_field(
        'sf_mail_success_msg_field',
        __( 'Success Message', SF_TEXT_DOMAIN ),
        'sf_mail_success_msg_field_cb',
        'sf_options',
        'sf_section_one'
    );
}
 
/**
 * Register our wporg_settings_init to the admin_init action hook.
 */
add_action( 'admin_init', 'wporg_settings_init' );
 
/**
 * Developers section callback function.
 *
 * @param array $args  The settings array, defining title, id, callback.
 */
function sf_section_one_callback( $args ) {
}
 
/**
 * Mail To field callbakc function.
 *
 * @param array $args
 */
function sf_mail_to_field_cb( $args ) {
    // Get the value of the setting we've registered with register_setting()
    $sf_mail_address = get_option( 'sf_mail_address' );
    ?>
    <input type="text" name="sf_mail_address" value="<?php echo $sf_mail_address; ?>">
    <?php
}
 
/**
 * Mail message pattern field callbakc function.
 *
 * @param array $args
 */
function sf_mail_body_field_cb( $args ) {
    // Get the value of the setting we've registered with register_setting()
    $sf_mail_body = get_option( 'sf_mail_body' );
    ?>
    <textarea name="sf_mail_body" cols="30" rows="8"><?php echo $sf_mail_body; ?></textarea>
    <?php
}
 
/**
 * Mail success message callbakc function.
 *
 * @param array $args
 */
function sf_mail_success_msg_field_cb( $args ) {
    // Get the value of the setting we've registered with register_setting()
    $sf_mail_success_msg = get_option( 'sf_mail_success_msg' );
    ?>
    <input type="text" name="sf_mail_success_msg" value="<?php echo $sf_mail_success_msg; ?>">
    <?php
}
 
/**
 * Add the top level menu page.
 */
function sf_options_page() {
    add_submenu_page( 'sf-general', __('Options', SF_TEXT_DOMAIN), __('Options', SF_TEXT_DOMAIN), 'manage_options', 'sf-options', 'sf_options_page_html' );
}

/**
 * Register our sf_options_page to the admin_menu action hook.
 */
add_action( 'admin_menu', 'sf_options_page' );
 
 
/**
 * Top level menu callback function
 */
function sf_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
 
    // check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'sf_options_messages', 'sf_options_message', __( 'Settings Saved', SF_TEXT_DOMAIN ), 'updated' );
    }
 
    // show error/update messages
    settings_errors( 'sf_options_messages' );
    ?>

    <div class="wrap sf_backend_fields">
        <h1><?php _e('Form Options', SF_TEXT_DOMAIN ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "sf_options"
            settings_fields( 'sf_options' );

            // (sections are registered for "sf_options", each field is registered to a specific section)
            do_settings_sections( 'sf_options' );

            // output save settings button
            submit_button( __('Save Settings', SF_TEXT_DOMAIN) );
            ?>
        </form>
    </div>
    <?php
}