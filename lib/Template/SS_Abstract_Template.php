<?php

namespace SectionSlider\Template;

/**
 * Abstract template.
 *
 * @package  section-slider
 * @subpackage lib/Template
 * @author KreeLabs <hello@kreelabs.com, @kreelabs>
 * @version 0.0.0
 */
abstract class SS_Abstract_Template implements SS_Template_Interface
{
    /** @const Template name */
    const TEMPLATE_NAME = 'default';

    /** @var string Template path */
    protected $template_path;

    /** @var string CSS path */
    protected $styles_path;

    /** @var string JS path */
    protected $scripts_path;

    /**
     * Constructor.
     *
     * @see  add_action()
     * @since  0.0.0
     *
     * @see  add_action()
     */
    public function __construct()
    {
        $this->template_path = SS_PLUGIN_URL . '/templates/';
        $this->styles_path   = $this->template_path . static::TEMPLATE_NAME . '/css/';
        $this->scripts_path  = $this->template_path . static::TEMPLATE_NAME . '/js/';

        //add template resources
        add_action( 'ss_hook_template_scripts', [ $this, 'ss_add_template_resources' ] );
    }
}
