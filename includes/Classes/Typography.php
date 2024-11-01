<?php

namespace WISECAMPAIGN\Classes;

class Typography {

    private $wp_customize;
    private $section;

    public function __construct($wp_customize, $section, $default_size, $default_family) {
        $this->wp_customize = $wp_customize;
        $this->section = $section;
        $this->font_family_setting($default_family);
        $this->font_size_setting($default_size);
        $this->font_style_setting();
        $this->font_style_setting();
    }

    private function font_size_setting($size) {
        $this->wp_customize->add_setting($this->section.'_fontsize', array(
            'default' => $size,
            'transport' => 'refresh'
            // 'sanitize_callback' => function ($value) {
            //     return is_array($value) ? array_map('sanitize_text_field', $value) : '';
            // }
        ));

        $this->wp_customize->add_control($this->section.'_fontsize_control', array(
            'type' => 'range',
            'label' => 'Font Size',
            'section' => $this->section.'_section',
            'settings' => $this->section.'_fontsize',
            'input_attrs' => array(
                'min'   => 0,
                'max'   => 100,
                'step'  => 1, // Optional: define the step size
            ),
        ));

        $this->wp_customize->add_control($this->section.'_fontsize_box_control', array(
            'type' => 'number',
            'section' => $this->section.'_section',
            'settings' => $this->section.'_fontsize',
        ));
    }

    private function font_family_setting($family) {
        $this->wp_customize->add_setting($this->section.'_fontfamily', array(
            'default' => $family,
            'transport' => 'refresh'
            // 'sanitize_callback' => function ($value) {
            //     return is_array($value) ? array_map('sanitize_text_field', $value) : '';
            // }
        ));

        $this->wp_customize->add_control($this->section.'_fontfamily_control', array(
            'type' => 'select',
            'label' => 'Select Font',
            'section' => $this->section.'_section',
            'settings' => $this->section.'_fontfamily',
            'choices' => array(
                'Rubik Scribble' => __('Rubik Scribble', 'wisecampaign'),
                'Times New Roman' => __('Times New Roman', 'wisecampaign'),
                'Arial' => __('Arial', 'wisecampaign'),
                'Kreon' => __('Kreon', 'wisecampaign'),
                'Inter' => __('Inter', 'wisecampaign')
            )
        ));
    }

    private function font_weight_setting() {
        $this->wp_customize->add_setting($this->section.'_fontwight', array(
            'default' => 300,
            'transport' => 'refresh'
            // 'sanitize_callback' => function ($value) {
            //     return is_array($value) ? array_map('sanitize_text_field', $value) : '';
            // }
        ));

        $this->wp_customize->add_control($this->section.'_fontweight_control', array(
            'type' => 'select',
            'label' => 'Select Font Weight',
            'section' => $this->section.'_section',
            'settings' => $this->section.'_fontwight',
            'choices' => array(
                100 => __('100 (Thin)', 'wisecampaign'),
                200 => __('200 (Extra Thin)', 'wisecampaign'),
                300 => __('300 (Light)', 'wisecampaign'),
                400 => __('400 (Normal)', 'wisecampaign'),
                500 => __('500 (Medium)', 'wisecampaign'),
                600 => __('600 (Semi Bold)', 'wisecampaign'),
                700 => __('700 (Bold)', 'wisecampaign'),
                800 => __('800 (Extra Bold)', 'wisecampaign'),
                900 => __('900 (Black)', 'wisecampaign'),
            )
        ));
    }


    private function font_style_setting() {
        $this->wp_customize->add_setting($this->section.'_fontstyle', array(
            'default' => 'normal',
            'transport' => 'refresh'
            // 'sanitize_callback' => function ($value) {
            //     return is_array($value) ? array_map('sanitize_text_field', $value) : '';
            // }
        ));

        $this->wp_customize->add_control($this->section.'_fontstyle_control', array(
            'type' => 'select',
            'label' => 'Select Font Weight',
            'section' => $this->section.'_section',
            'settings' => $this->section.'_fontstyle',
            'choices' => array(
                'normal' => __('Normal', 'wisecampaign'),
                'italic' => __('Italic', 'wisecampaign'),
                'oblique' => __('Oblique', 'wisecampaign'),
            )
        ));
    }
}