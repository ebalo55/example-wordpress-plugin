<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */
class Plugin_Name_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Plugin_Name_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Plugin_Name_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/plugin-name-admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Plugin_Name_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Plugin_Name_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/plugin-name-admin.js', array('jquery'), $this->version, false);

    }

    public function setupAdminMenu()
    {
        /**
         * Add top level menu
         */
        /*$hook = add_menu_page("page_title", "menu_title", "manage_options",
            "menu-slug", function () {
                require_once(plugin_dir_path(dirname(__FILE__)) . "admin/partials/adminMenu.php");
            }, "icon-url", 20);*/
        $hook = add_management_page("page-title", "menu-title",
            "manage_options", "menu-slug", function () {
                require_once(plugin_dir_path(dirname(__FILE__)) . "admin/partials/adminMenu.php");
            });
        //add_action("load-{$hook}", function() { $this->setPluginOptions(); });
    }
    public function setupSettings() {
        register_setting("setting-group", "option-name");
        add_settings_section("setting-section-id", "setting-section-title", function() {
            $this->settingSectionCallback();
        }, "setting-group");

        add_settings_field("setting-field-id", "setting-field-title", function() {
            $this->settingFieldCallback();
        }, "setting-group", "setting-section-id");
    }

    private function settingSectionCallback() {
        echo "<p>Setting section introduction</p>";
    }

    private function settingFieldCallback() {
        $setting = get_option("option-name");
        ?>
            <input type="text" name="option-name" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
        <?php
    }

    public function wporg_add_custom_box() {
        $screens = [ 'post', 'wporg_cpt' ];
        foreach ( $screens as $screen ) {
            add_meta_box(
                'wporg_box_id',                 // Unique ID
                'Custom Meta Box Title',      // Box title
                function($post) { $this->wporg_custom_box_html($post); },// 'wporg_custom_box_html',  // Content callback, must be of type callable
                $screen                            // Post type
            );
        }
    }
    private function wporg_custom_box_html( $post ) {
        $value = get_post_meta($post->ID, '_wporg_meta_key', true );
        ?>
        <label for="wporg_field">Description for this field</label>
        <select name="wporg_field" id="wporg_field" class="postbox">
            <option value="">Select something...</option>
            <option value="something" <?php selected( $value, 'something' ); ?>>Something</option>
            <option value="else" <?php selected( $value, 'else' ); ?>>Else</option>
        </select>
        <?php
    }
    public function wporg_save_postdata( $post_id ) {
        if ( array_key_exists( 'wporg_field', $_POST ) ) {
            update_post_meta(
                $post_id,
                '_wporg_meta_key',
                $_POST['wporg_field']
            );
        }
    }
}
