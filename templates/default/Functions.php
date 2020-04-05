<?php

namespace SectionSlider\TemplateFiles;

use SectionSlider\Section_Slider;
use SectionSlider\Template\SS_Abstract_Template;

/**
 * Default template functions.
 *
 * @package  section-slider
 * @subpackage templates
 * @author KreeLabs <hello@kreelabs.com, @kreelabs>
 * @version 0.0.0
 */
class Functions extends SS_Abstract_Template
{
    const TEMPLATE_NAME = 'default';

    /**
     * {@inheritdoc}
     */
    public function ss_add_template_resources()
    {
        //enqueue styles
        wp_enqueue_style(
            'ss-styles',
            $this->styles_path . 'ss-default-styles.css',
            [],
            Section_Slider::VERSION
        );

        wp_enqueue_style(
            'font-awesome',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css',
            [],
            Section_Slider::VERSION
        );

        //enqueue scripts
        wp_enqueue_script(
            'section-slider-lib',
            $this->scripts_path . 'ss-slider.lib.js',
            [ 'jquery' ],
            Section_Slider::VERSION,
            true
        );

        wp_enqueue_script(
            'ss-scripts',
            $this->scripts_path . 'ss-scripts.js',
            [ 'jquery', 'section-slider-lib' ],
            Section_Slider::VERSION,
            true
        );

        wp_enqueue_script(
            'smooth-scroll',
            $this->scripts_path . 'jquery.smooth-scroll.min.js',
            [ 'jquery' ],
            Section_Slider::VERSION,
            true
        );
    }
}

/** Initialize template functions */
$ss_template_functions = new Functions();
