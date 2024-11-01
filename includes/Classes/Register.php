<?php

namespace WISECAMPAIGN\Classes;

use WISECAMPAIGN\Traits\SingletonTrait;


class Register
{
    use SingletonTrait;

    public function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'wisecampaign_pages_enqueue_scripts']);
        if (get_option('wisecampaign_plugin_enabled') == '1') {
            add_action('wp_enqueue_scripts', [$this, 'wisecampaign_enqueue_scripts']);
            add_action('wp_enqueue_scripts', [$this, 'wisecampaign_plugin_enqueue_styles']);

        }
    }

    function wisecampaign_pages_enqueue_scripts($hook)
    {
        echo '<script> document.documentElement.style.setProperty("--wpadminbar-top", "0"); </script>';


        wp_enqueue_style('wise_campaign_pro-style', WISECAMPAIGN_DIR_URL.'admin/build/index.css');
        wp_enqueue_script('wise_campaign_pro-script', WISECAMPAIGN_DIR_URL.'admin/build/index.js', array('wp-element'),
            '1.0.0', true);


        // Localize the script with data
        wp_localize_script('wise_campaign_pro-script', 'wiseCampaignPageData', array(
                'wiseCampaignUrl' => WISECAMPAIGN_DIR_URL
            ));

    }

    function wisecampaign_enqueue_scripts()
    {

        wp_enqueue_script('wisecampaign-script', WISECAMPAIGN_DIR_URL.'admin/build/index.js', array('wp-element'),
            '1.0.0', true);
        wp_enqueue_style('wise_campaign_pro-style', WISECAMPAIGN_DIR_URL.'admin/build/index.css');

        $activeBannerData = Banner::getInstance()->get_banner_data();
        foreach ($activeBannerData->data as $data) {
            if ($data['is_active']) {
                wp_localize_script('wisecampaign-script', 'wiseCampaignCustomize', $data);
            }
        }

    }

    // Define a function to enqueue styles
    function wisecampaign_plugin_enqueue_styles()
    {
        // Enqueue the stylesheet
        wp_enqueue_style('wisecampaign-style');
        wp_enqueue_style('google-fonts',
            'https://fonts.googleapis.com/css2?family=Inter&family=Kreon:wght@700&Rubik+Scribble&display=swap', array(),
            null);
    }

}