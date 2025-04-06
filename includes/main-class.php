<?php

// Block direct access to file
defined( 'ABSPATH' ) or die( 'Not Authorized!' );

class Simple_Form {

    public function __construct() {

        // Plugin uninstall hook
        register_uninstall_hook( SF_FILE, array('Simple_Form', 'plugin_uninstall') );

        // Plugin activation/deactivation hooks
        register_activation_hook( SF_FILE, array($this, 'plugin_activate') );
        register_deactivation_hook( SF_FILE, array($this, 'plugin_deactivate') );

        // Plugin Actions
        add_action( 'plugins_loaded', array($this, 'plugin_init') );
        add_action( 'wp_enqueue_scripts', array($this, 'plugin_enqueue_scripts') );
        add_action( 'admin_enqueue_scripts', array($this, 'plugin_enqueue_admin_scripts') );
        add_action( 'admin_menu', array($this, 'plugin_admin_menu_function') );

        // AJAX init
        add_action('wp_head', array($this, 'sf_wp_ajax_init') );

        // Form Shortcode
        include(SF_DIRECTORY.'/includes/form-shortcode.php');

        // Form ajax submission
        include(SF_DIRECTORY.'/includes/form_submission_ajax.php');

        // Form entry display
        include(SF_DIRECTORY.'/includes/form-entry-display.php');

        // Admin functions
        include(SF_DIRECTORY.'/includes/admin/admin-functions.php');

    }

    public static function plugin_uninstall() { }

    /**
     * Plugin activation function
     * called when the plugin is activated
     * @method plugin_activate
     */
    public function plugin_activate() { 
        sf_entry_table_create();   
    }

    /**
     * Plugin deactivate function
     * is called during plugin deactivation
     * @method plugin_deactivate
     */
    public function plugin_deactivate() { }

    /**
     * Plugin init function
     * init the plugin textDomain
     * @method plugin_init
     */
    function plugin_init() {
        // before all load plugin text domain
        load_theme_textdomain( SF_TEXT_DOMAIN, SF_DIRECTORY . '/languages/' );
        load_plugin_textDomain( SF_TEXT_DOMAIN, false, SF_DIRECTORY . '/languages/' );
    }

    function plugin_admin_menu_function() {

        //create main top-level menu with empty content
        add_menu_page( __('Simple Form Settings', SF_TEXT_DOMAIN), __('SF Settings', SF_TEXT_DOMAIN), 'administrator', 'sf-general', null, 'dashicons-admin-generic', 100 );

        // create top level submenu page which point to main menu page
        add_submenu_page( 'sf-general', __('General', SF_TEXT_DOMAIN), __('General', SF_TEXT_DOMAIN), 'manage_options', 'sf-general', array($this, 'plugin_settings_page') );

    }

    /**
     * Enqueue the main Plugin admin scripts and styles
     * @method plugin_enqueue_admin_scripts
     */
    function plugin_enqueue_admin_scripts() {
        wp_register_style( 'sf-admin-style', SF_DIRECTORY_URL . '/assets/admin/css/admin-style.css', array(), null );
        wp_register_script( 'sf-admin-script', SF_DIRECTORY_URL . '/assets/admin/js/admin-script.js', array(), null, true );
        wp_enqueue_script('jquery');
        wp_enqueue_style('sf-admin-style');
        wp_enqueue_script('sf-admin-script');
    }

    /**
     * Enqueue the main Plugin user scripts and styles
     * @method plugin_enqueue_scripts
     */
    function plugin_enqueue_scripts() {
        wp_register_style( 'sf-frontend-style', SF_DIRECTORY_URL . '/assets/front-end/css/frontend-style.css', array(), null );
        wp_register_script( 'sf-frontend-script', SF_DIRECTORY_URL . '/assets/front-end/js/frontend-script.js', array(), null, true );
        wp_enqueue_script('jquery');
        wp_enqueue_style('sf-frontend-style');
        wp_enqueue_script('sf-frontend-script');
    }

    /**
     * Plugin main settings page
     * @method plugin_settings_page
     */
    function plugin_settings_page() { ?>

        <div class="wrap card sf-settings">

            <h1><?php _e( 'Documentation', SF_TEXT_DOMAIN ); ?></h1>

            <p><?php _e( 'This plugin has 2 shortcodes that you can use to display the form and form entries on the front-end.', SF_TEXT_DOMAIN ); ?></p>

            <h2><?php _e('Form Shortcode', SF_TEXT_DOMAIN ); ?></h2>
            <code>[form_shortcode form_title="Form Title Here"]</code>

            <h2><?php _e('Form Entry Shortcode', SF_TEXT_DOMAIN ); ?></h2>
            <code>[form_entry_display block_title="Entry Table Title"]</code>

        </div>

    <?php }


    // AJAX initialization
    function sf_wp_ajax_init() {
        $url = parse_url(home_url());
        if ($url['scheme'] == 'https') {
            $protocol = 'https';
        } else {
            $protocol = 'http';
        }
        $emptyFieldMsg = __('This field cannot be blank', SF_TEXT_DOMAIN);
        $invalidEmailMsg = __('Invalid Email', SF_TEXT_DOMAIN);
        ?>
        <?php global $wp_query; ?>
        <script type="text/javascript">
            var ajaxurl = '<?php echo admin_url('admin-ajax.php', $protocol); ?>';
            var emptyFieldMsg = '<?php echo $emptyFieldMsg; ?>';
            var invalidEmailMsg = '<?php echo $invalidEmailMsg; ?>';
        </script>
        <?php
    }

}

new Simple_Form;
