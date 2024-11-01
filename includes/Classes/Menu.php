<?php

namespace WISECAMPAIGN\Classes;

use WISECAMPAIGN\Traits\SingletonTrait;
use WP_REST_Request;

class Menu
{
    use SingletonTrait;
    private $option_name = 'wisecampaign_plugin_enabled';

    public function __construct()
    {
        add_action('admin_menu', [$this, 'wisecampaign_admin_menu']);
        add_action('rest_api_init', [$this, 'register_settings']);
        add_shortcode('wise_banner', [$this, 'wise_banner_shortcode']);
        add_action('wp_head', [$this, 'wise_campaign_pro_banner_show']);
    }

    public function register_settings()
    {
        register_rest_route('wise-campaign-plugin/v1', '/setting', [
            'methods' => 'GET',
            'callback' => function () {
                return ['enabled' => get_option('wisecampaign_plugin_enabled') == '1'];
            },
        ]);
    
        register_rest_route('wise-campaign-plugin/v1', '/setting', [
            'methods' => 'POST',
            'callback' => function (WP_REST_Request $request) {
                $enabled = $request->get_json_params()['enabled'];
                update_option('wisecampaign_plugin_enabled', $enabled ? '1' : '0');
                return ['enabled' => $enabled];
            },
        ]);

        // registe selected theme
        register_rest_route('wisecampaign-plugin-theme/v1', '/setting', [
            'methods' => 'GET',
            'callback' => function () {
                return ['selected_banner' => get_option('wisecampaign_selected_banner') ];
            },
        ]);
    
        register_rest_route('wisecampaign-plugin-theme/v1', '/setting', [
            'methods' => 'POST',
            'callback' => function (WP_REST_Request $request) {
                $selected_banner = $request->get_json_params()['selected_banner'];
                update_option('wisecampaign_selected_banner', $selected_banner ? $selected_banner : 'default');
                return ['selected_banner' => $selected_banner];
            },
        ]);
    }

    // Add WiseCampaign Menu to Admin Dashboard
    function wisecampaign_admin_menu()
    {
        add_menu_page(
            'WiseCampaign',           // Page title
            'WiseCampaign',           // Menu title
            'manage_options',         // Capability required
            'wisecampaign_menu',      // Menu slug
            [$this, 'wisecampaign_getting_started_page'], // Callback function to display the WiseCampaign menu page
            'dashicons-megaphone',  // Icon URL or name
            30                        // Position in the menu
        );

        add_submenu_page(
            'wisecampaign_menu',     // Parent menu slug
            'Getting Started',        // Page title
            'Getting Started',        // Menu title
            'manage_options',         // Capability required
            'wisecampaign_menu', // Menu slug
            [$this, 'wisecampaign_getting_started_page'] // Callback function to display the Getting Started page
        );

        add_submenu_page(
            'wisecampaign_menu',     // Parent menu slug
            'Settings',               // Page title
            'Settings',               // Menu title
            'manage_options',         // Capability required
            'wisecampaign_settings',  // Menu slug
            [$this, 'wisecampaign_settings_page'] // Callback function to display the Settings page
        );
    }



    // Callback function to display the WiseCampaign menu page
    function wisecampaign_menu_page()
    {
        // Add your code to display the WiseCampaign menu page content
        echo '<h1>WiseCampaign Menu Page</h1>';
    }



    function wise_banner_shortcode() {
        return '<div id="wise-campaign-banner-show"></div>';
    }

    function wise_campaign_pro_banner_show() {
        echo '<div id="wise-campaign-banner-show"></div>';
    }


    // Callback functions to display sub-menu pages
    function wisecampaign_getting_started_page()
    {
        // Add your code to display the Getting Started page content
        echo "<div id='wisecampaign-getting-started-page-app'></div>";
    }

    function wisecampaign_settings_page()
    {
        if (!defined('WISECAMPAIGN_PRO_VERSION_ACTIVE') || !WISECAMPAIGN_PRO_VERSION_ACTIVE) {
            echo "<div id='wisecampaign-setting-page-admin-app'>Free</div>";
        } else {
            echo "<div id='wisecampaign-page-app'>Pro</div>";
        }

    }
}
