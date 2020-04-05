<div class="ss-deck">
    <?php foreach ( $section_data['cards'] as $card ): ?>
        <main class="ss-card ss-content ss-swipe-main" id="<?php echo $card['slug'] ?>" tabindex="-1"
              itemtype="http://schema.org/Blog" style="display:none;" itemscope="itemscope"
              itemprop="mainContentOfPage" role="main">
            <div class="ss-card-header" style="margin: 0;">
                <div class="ss-pagination-previous ss-pagination ss-left">
                    <a class="ss-prev fa fa-angle-left" href="javascript:void(0)"
                       title="<?= ss_translate('Go to previous page') ?>"
                       onclick='SECTION_SLIDER.changeState("prev");'></a>
                </div>
                <div class="ss-align-left ss-section-count ss-left">
                    <?= ss_get_section_heading_template( $card['page'], $section_data['total'] ) ?>
                </div>
                <div class="ss-pagination-next ss-pagination ss-left">
                    <a class="ss-next fa fa-angle-right" href="javascript:void(0)"
                       title="<?= ss_translate('Go to next page') ?>"
                       onclick='SECTION_SLIDER.changeState("next");'></a>
                </div>
                <div class="ss-clear"></div>
            </div>
            <article itemprop="blogPost" itemtype="http://schema.org/BlogPosting" itemscope="itemscope"
                     class='ss-swipe-article'>
                <div class="ss-entry-title ss-swipe-title">
                    <?= ss_get_card_title( $card ) ?>
                </div>
                <div itemprop="text" class="ss-entry-content">
                    <?php
                    $content = ss_strip_shortcodes_except(
                            'section',
                            $card['content']
                    );

                    $content = preg_replace( '[^(<br( \/)?>)*|(<br( \/)?>)*$]', '', $content );
                    echo do_shortcode( apply_filters( 'the_content', $content ) );
                    ?>
                </div>
            </article>
            <div class="ss-archive-pagination" style="margin: 0;">
                <div class="ss-pagination-previous ss-pagination ss-align-left">
                    <a class="ss-prev" href="javascript:void(0)"
                       onclick='SECTION_SLIDER.changeState("prev");'></a>
                </div>

                <?php include SS_TEMPLATE_DIR . 'default/social.php' ?>

                <div class="ss-pagination-next ss-pagination ss-align-right">
                    <a class="ss-next" href="javascript:void(0)"
                       onclick='SECTION_SLIDER.changeState("next");'></a>
                </div>
            </div>
        </main>
        <div class="ss-clear"></div>

    <?php endforeach; ?>
</div>
