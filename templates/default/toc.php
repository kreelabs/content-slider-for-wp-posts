<div class="ss-toc">
    <div class="ss-deck-info">
        <h3 class="ss-deck-title"><?php echo strtoupper( $current_post->post_title ) ?></h3>
        <div class="ss-post-meta">
            <?= ss_translate( 'POSTED BY' ) ?>&nbsp;
            <a href="<?= get_author_posts_url( $current_post->post_author ) ?>" class="ss-author">
                <?= strtoupper( get_the_author_meta( 'display_name', $current_post->post_author ) ) ?></a>
            <br/>
            <?= date( 'M j,&\nb\sp; Y,&\nb\sp; H:i A', strtotime( $current_post->post_date ) ) ?>

            <span class="ss-entry-categories ss-swipe-categories">
                <?= ss_get_categories_link() ?>
            </span>
        </div>
    </div>
    <div class="ss-deck-toc">
        <p class="ss-scroller ss-scroller-up" onclick="SECTION_SLIDER.scroll('prev')"></p>
        <ol>
            <?php foreach ( $section_data['cards'] as $card ): ?>
                <li data-id="<?php echo $card['slug'] ?>">
                    <a href="javascript:void(0)" class='ss-deck-toc-nav'>
                        <?= ss_get_card_title( $card ) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ol>
        <p class="ss-scroller ss-scroller-down" onclick="SECTION_SLIDER.scroll('next')"></p>
    </div>
</div>
