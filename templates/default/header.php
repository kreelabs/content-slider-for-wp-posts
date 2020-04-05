<!DOCTYPE html>
<html>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">

    <title><?php wp_title( '|', true, 'right' ); ?></title>

    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" title="<?= ss_translate('Go to homepage') ?>">

    <?php wp_head() ?>
</head>

<body class="ss-single-format ss-body">

<div class="ss-background-image"></div>
<div class="ss-nav">
    <div class="ss-site-url">
        <a href="<?= site_url() ?>"><?= get_bloginfo() ?></a>
    </div>
</div>
