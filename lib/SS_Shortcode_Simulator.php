<?php

namespace SectionSlider;

/**
 * Fetches required data for the plugin from the content
 * and uses dummy shortcode to remove actual shortcode
 * from the content.
 *
 * @package  section-slider
 * @subpackage lib
 * @author KreeLabs <hello@kreelabs.com, @kreelabs>
 * @version 0.0.0
 */
class SS_Shortcode_Simulator
{
    /** @var integer Total number of sections */
    protected $_num_pages = 0;

    /** @var array Section data */
    protected $_section_data = [];

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
        //initialize
        add_action( 'plugins_loaded', [ $this, 'init' ] );

        add_filter( 'the_content', [ $this, 'extract_sections' ] );
    }

    /**
     * Initialize shortcodes.
     *
     * @since  0.0.0
     * @access public
     *
     * @see  add_shortcode()
     *
     * @return void
     */
    public function init()
    {
        add_shortcode( 'section', [ $this, 'ss_section_shortcode' ] );
    }

    /**
     * Shortcode to define a section within a post.
     *
     * @access public
     * @since  0.0.0
     *
     * @param  array $attr Shortcode attributes
     * @param  string $contents Actual content
     *
     * @return string
     */
    public function ss_section_shortcode( $attr, $contents )
    {
        /*
            We are just returning content here.
            This is a simple trick to remove shortcode
            from actual content as required values are
            already fetched.
        */
        return $contents;
    }

    /**
     * Uses regular expression to separate different sections.
     *
     * @access public
     * @since  0.0.0
     *
     * @param  string $content Page content
     *
     * @return string
     */
    public function extract_sections( $content )
    {
        //add title and content as first slide
        $title = trim( preg_replace( '/[^A-Za-z0-9\s\.?!-]/', '', get_the_title() ) );

        $this->_section_data[] = [
            'page' => ++ $this->_num_pages,
            'title' => $title,
            'slug' => $this->_num_pages . '-' . ss_sanitize_slug( $title ),
            'content' => ss_strip_shortcode( 'section', $content ),
        ];

        //extract other contents
        $pattern = '\\['                // Opening bracket
                   . '(\\[?)'           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
                   . "(section)"        // 2: Shortcode name
                   . '(?![\\w-])'       // Not followed by word character or hyphen
                   . '('                // 3: Unroll the loop: Inside the opening shortcode tag
                   . '[^\\]\\/]*'       // Not a closing bracket or forward slash
                   . '(?:'
                   . '\\/(?!\\])'       // A forward slash not followed by a closing bracket
                   . '[^\\]\\/]*'       // Not a closing bracket or forward slash
                   . ')*?'
                   . ')'
                   . '(?:'
                   . '(\\/)'            // 4: Self closing tag ...
                   . '\\]'              // ... and closing bracket
                   . '|'
                   . '\\]'              // Closing bracket
                   . '(?:'
                   . '('                // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
                   . '[^\\[]*+'         // Not an opening bracket
                   . '(?:'
                   . '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
                   . '[^\\[]*+'         // Not an opening bracket
                   . ')*+'
                   . ')'
                   . '\\[\\/\\2\\]'     // Closing shortcode tag
                   . ')?'
                   . ')'
                   . '(\\]?)';          // 6: Optional second closing bracket for escaping shortcodes: [[tag]]

        if ( preg_match_all( '/' . $pattern . '/s', $content, $matches ) &&
             array_key_exists( 2, $matches ) && in_array( 'section', $matches[2] )
        ) {
            foreach ( $matches[2] as $key => $match ) {
                if ( $match == 'section' ) {
                    ++ $this->_num_pages;

                    $title = trim( preg_replace( '/[^A-Za-z0-9\s\.?!-]/', '',
                        str_replace( 'title=', '', $matches[3][ $key ] ) ) );

                    $title = ss_get_card_title( [
                        'title' => $title,
                        'page' => $this->_num_pages,
                    ] );

                    $this->_section_data[] = [
                        'page' => $this->_num_pages,
                        'title' => $title,
                        'slug' => $this->_num_pages . '-' . ss_sanitize_slug( $title ),
                        'content' => $matches[0][ $key ],
                    ];
                }
            }
        }

        //return actual content
        return $content;
    }

    /**
     * Return num pages and section data.
     *
     * @access public
     * @since  0.0.0
     *
     * @return array
     */
    public function get_required_plugin_data()
    {
        return [
            'total' => $this->_num_pages,
            'cards' => $this->_section_data,
        ];
    }
}

/** Initialize */
global $shortcode_simulator;
$shortcode_simulator = new SS_Shortcode_Simulator();
