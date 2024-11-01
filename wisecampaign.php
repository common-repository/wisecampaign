<?php
/*
 * Plugin Name:       wiseCampaign
 * Plugin URI:        https://wisemattic.com/wisecampaign
 * Description:       A WordPress plugin for creating website top banners with customizable options.
 * Version:           1.1.1
 * Requires at least: 5.4
 * Requires PHP:      7.4
 * Author:            Wisemattic
 * Author URI:        https://wisemattic.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wisecampaign
 * Domain Path:       /languages
 */

// Prevent direct access to the script
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Autoload required classes using Composer
require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

// Import classes from the WISECAMPAIGN namespace
use WISECAMPAIGN\Classes\Banner;
use WISECAMPAIGN\Classes\Menu;
use WISECAMPAIGN\Classes\Register;

/**
 * Main class for the WiseCampaign plugin
 */
class Wisecampaign
{
    // Singleton instance
    private static $instance;

    // Plugin directory path and URL
    private static $plugin_dir_path;
    private static $plugin_dir_url;

    /**
     * Get the singleton instance of the Wisecampaign class
     *
     * @return Wisecampaign
     */
    public static function get_instance()
    {
        // Check if instance already exists
        if (!isset(self::$instance)) {
            self::$instance = new self();
            self::$instance->init();

        }
        return self::$instance;
    }

    /**
     * Initialize the plugin
     */
    private function init()
    {
        $this->include_require_files();
        $this->register_classes();
        $this->register_hooks();
        $this->appsero_init_tracker_wisecampaign();
    }

    public function appsero_init_tracker_wisecampaign() {

        $client = new Appsero\Client( '78f49ac6-4577-4712-b9b4-2dc7a67a07f2', 'wiseCampaign', __FILE__ );

        // Active insights
        $client->insights()->init();

    }

    /**
     * Include required files and set directory paths
     */
    private function include_require_files()
    {
        // Set the plugin directory path and URL
        self::$plugin_dir_path = plugin_dir_path(__FILE__);
        self::$plugin_dir_url = plugin_dir_url(__FILE__);

        // Define constants for easy access throughout the plugin
        define('WISECAMPAIGN_DIR_PATH', self::$plugin_dir_path);
        define('WISECAMPAIGN_DIR_URL', self::$plugin_dir_url);
    }

    /**
     * Register necessary classes for the plugin
     */
    private function register_classes()
    {
        Menu::getInstance(); // Initialize the Menu class
        Register::getInstance(); // Initialize the Register class
        Banner::getInstance(); // Initialize the Banner class
    }

    /**
     * Register hooks for plugin activation and other actions
     */
    private function register_hooks()
    {
        // Register activation hook to create the banner table
        register_activation_hook(__FILE__, [$this, 'wise_campaign_create_banner_table']);
    }

    /**
     * Create the banner table in the database on plugin activation
     */
    public function wise_campaign_create_banner_table()
    {
        // Call the create_banner_table method from the Banner class
        Banner::getInstance()->create_banner_table();
    }
}

// Initialize the plugin by creating an instance of the Wisecampaign class
Wisecampaign::get_instance();
