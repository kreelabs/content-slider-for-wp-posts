<?php

/**
 * @file freemius-loader.php
 *
 * Loads Freemius.
 */

function ss_fs()
{
    global $ss_fs;

    if ( ! isset( $ss_fs ) ) {
        // Include Freemius SDK.
        require_once SS_PLUGIN_DIR . 'freemius/start.php';

        $ss_fs = fs_dynamic_init( [
            'id' => '1023',
            'slug' => 'section-slider',
            'type' => 'plugin',
            'public_key' => 'pk_3820334e1aa91f61fc2b5e0438a83',
            'is_premium' => false,
            'has_addons' => false,
            'has_paid_plans' => false,
            'menu' => [
                'first-path' => 'plugins.php',
                'account' => false,
                'support' => false,
            ],
        ] );
    }

    return $ss_fs;
}


// init Freemius.
ss_fs();

// signal that SDK was initiated.
do_action( 'ss_fs_loaded' );
