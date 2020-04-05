<?php

/**
 * Localize text strings
 *
 * @param $string
 *
 * @since  0.0.0
 * @see  __()
 *
 * @return string
 */
function ss_translate( $string )
{
    return __( $string, \SectionSlider\Section_Slider::TEXT_DOMAIN );
}

/**
 * Remove special characters from slug
 *
 * @param  string $title Text te sanitized
 *
 * @since  0.0.0
 *
 * @return string
 */
function ss_sanitize_slug( $title )
{
    $slug = trim( preg_replace( '/[^A-Za-z0-9\s]/', '', $title ) );

    return str_replace( ' ', '-', strtolower( $slug ) );
}

/**
 * Strip single shortcode from a given content.
 *
 * @param string $code Name of the shortcode
 * @param string $content
 *
 * @since  0.0.0
 * @uses  strip_shortcodes() to strip all shortcodes from a content.
 *
 * @return string Content with shortcode striped
 */
function ss_strip_shortcode( $code, $content )
{
    global $shortcode_tags;

    $stack = $shortcode_tags;

    $shortcode_tags = [ $code => 1 ];
    $content        = strip_shortcodes( $content );

    $shortcode_tags = $stack;

    return $content;
}

/**
 * Strip all shortcodes except one from a given content.
 *
 * @param string $code Name of the shortcode
 * @param string $content
 *
 * @since  0.0.0
 * @uses  strip_shortcodes() to strip all shortcodes from a content.
 *
 * @return string Content with shortcode striped
 */
function ss_strip_shortcodes_except( $code, $content )
{
    global $shortcode_tags;

    $stack = $shortcode_tags;

    unset( $shortcode_tags[ $code ] );

    $content = strip_shortcodes( $content );

    $shortcode_tags = $stack;

    return $content;
}

/**
 * Get card title.
 *
 * @param array $card
 *
 * @since  0.0.0
 *
 * @return null|string
 */
function ss_get_card_title( $card )
{
    $title = $card['title'];

    if ( empty( $title ) ) {
        $prefix = apply_filters( 'ss_section_prefix', ss_translate( 'Section' ) );
        $title  = $prefix . ' ' . ss_translate( $card['page'] );
    }

    return $title;
}

/**
 * Get section heading template.
 *
 * @param int $current_page
 * @param int $total
 *
 * @since  0.0.0
 *
 * @return string
 */
function ss_get_section_heading_template( $current_page, $total )
{
    $template = sprintf(
        '%s <strong id="ss-page-number">{{current_page}}</strong> %s <strong>{{total_page}}</strong>',
        ss_translate( 'Section' ), ss_translate( 'of' )
    );

    $template = apply_filters( 'ss_section_heading_template', $template );

    $template = str_replace( '{{current_page}}', ss_translate( $current_page ), $template );
    $template = str_replace( '{{total_page}}', ss_translate( $total ), $template );

    return $template;
}

/**
 * Get category links of current post.
 *
 * @since  0.0.0
 *
 * @return string
 */
function ss_get_categories_link()
{
    $terms = get_the_category( get_the_ID() );
    if ( empty( $terms ) ) {
        return '';
    }

    $categories = [];
    foreach ( $terms as $category ) {
        $categories[] = "<a href='" . get_term_link( $category ) . "' class='ss-categories-link'>" . $category->name . "</a>";
    }

    return implode( ', ', $categories );
}
