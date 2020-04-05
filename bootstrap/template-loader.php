<?php

/**
 * @file template-loader.php
 *
 * Loads template based on settings and filters.
 */

$template_path = SS_PLUGIN_DIR . "templates/default/";

add_filter( 'ss_filter_template_path', function () use ( $template_path ) {
    return $template_path;
} );

// Bootstrap section slider
add_action( 'init', function () {
    $template_path  = apply_filters( 'ss_filter_template_path', SS_PLUGIN_DIR . 'templates/default/' );
    $functions_file = $template_path . 'Functions.php';

    if ( file_exists( $functions_file ) ) {
        include $functions_file;
    }
} );
