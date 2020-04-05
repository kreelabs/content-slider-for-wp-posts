<?php

namespace SectionSlider;

use RuntimeException;

/**
 * Main plugin class.
 *
 * @package  section-slider
 * @subpackage lib
 * @author KreeLabs <hello@kreelabs.com, @kreelabs>
 * @version 0.0.0
 */
class Section_Slider
{
    /** Post format to override */
    const POST_FORMAT = 'aside';

    /** Current version of the plugin */
    const VERSION = '0.0.0';

    /** @var string Plugin text domain */
    const TEXT_DOMAIN = 'section-slider';

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
        //load plugin textdomain
        add_action( 'plugins_loaded', [ $this, 'load_plugin_textdomain' ] );

        //rename post format to 'Deck'
        add_filter( 'esc_html', [ $this, 'rename_post_formats' ] );
        add_action( 'admin_head', [ $this, 'live_rename_formats' ] );

        //use custom template for deck post format
        add_action( 'template_redirect', [ $this, 'load_deck_template' ] );

        //enqueue required scripts
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_global_scripts' ] );

        //add post format support
        add_action( 'init', [ $this, 'enable_post_format' ] );
    }

    /**
     * Add required styles and scripts
     *
     * @since 0.0.0
     * @access public
     *
     * @see  wp_enque_style()
     * @see  wp_enqueue_script()
     *
     * @return void
     */
    public function enqueue_global_scripts()
    {
        if ( self::POST_FORMAT === get_post_format( get_the_ID() ) && is_single() ) {
            //add template specific scripts
            do_action( 'ss_hook_template_scripts' );
        }
    }

    /**
     * Enable post format.
     *
     * @since  0.0.0
     * @access public
     *
     * @see    add_theme_support()
     *
     * @return void
     */
    public function enable_post_format()
    {
        add_theme_support( 'post-formats', [ self::POST_FORMAT ] );
    }

    /**
     * Rename post formats.
     *
     * @access public
     * @since  0.0.0
     * @filter esc_html
     *
     * @param  string $format Post format
     *
     * @return string
     */
    public function rename_post_formats( $format )
    {
        if ( strtolower( $format ) === self::POST_FORMAT ) {
            return ss_translate( 'Deck' );
        }

        return $format;
    }

    /**
     * Rename post format in edit.php using script.
     *
     * @access public
     * @since  0.0.0
     * @action admin_head
     *
     * @return void
     */
    public function live_rename_formats()
    {
        global $current_screen;

        if ( $current_screen->id === 'edit-post' ) {
            ?>
            <script type="text/javascript">
                jQuery('document').ready(function () {
                    jQuery("span.post-state-format").each(function () {
                        if (jQuery(this).text().toLowerCase() == <?= self::POST_FORMAT ?>) {
                            jQuery(this).text( <?= ss_translate( 'Deck' ) ?> );
                        }
                    });
                });
            </script>
            <?php
        }
    }

    /**
     * Template redirect for deck post format.
     *
     * @access public
     * @since  0.0.0
     *
     * @see   is_single()
     * @uses  get_post_format to get post format
     * @uses  get_the_ID() to get post id
     *
     * @return void
     */
    public function load_deck_template()
    {
        if ( is_single() && self::POST_FORMAT === get_post_format( get_the_ID() ) ) {
            global $shortcode_simulator;

            $current_post_id = get_the_ID();
            $current_post    = get_post( $current_post_id );

            $shortcode_simulator->extract_sections( $current_post->post_content );

            $section_data  = $shortcode_simulator->get_required_plugin_data();
            $template_path = apply_filters( 'ss_filter_template_path', SS_PLUGIN_DIR . 'templates/default/' );

            if ( ! file_exists( $template_path . 'layout.php' ) ) {
                throw new RuntimeException( "Section slider template doesn't exist" );
            }

            include $template_path . 'layout.php';

            exit;
        }
    }

    /**
     * Load the plugin's textdomain hooked to 'plugins_loaded'.
     *
     * @since 0.0.0
     * @access public
     *
     * @see    load_plugin_textdomain()
     * @see    plugin_basename()
     * @action plugins_loaded
     *
     * @return    void
     */
    public function load_plugin_textdomain()
    {
        load_plugin_textdomain(
                self::TEXT_DOMAIN,
                false,
                dirname( plugin_basename( __FILE__ ) ) . '/languages/'
        );
    }

}
