<div class="ss-social">
    <a class="fa fa-facebook" href="javascript:void(0)" title="<?= ss_translate('Share on facebook') ?>"
       data-title='<?= ss_translate('Facebook') ?>'
       data-href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink( $current_post_id ) . '#' . $card['slug'] ?>"></a>
    <a class="fa fa-twitter" href="javascript:void(0)" title="<?= ss_translate('Share on twitter') ?>"
       data-title='<?= ss_translate('Twitter') ?>'
       data-href="https://twitter.com/intent/tweet?url=<?php echo get_permalink( $current_post_id ) . '#' . $card['slug'] ?>"></a>
    <a class="fa fa-google-plus" href="javascript:void(0)" title="<?= ss_translate('Share on google+') ?>"
       data-title='<?= ss_translate('Google+') ?>'
       data-href="https://plus.google.com/share?url=<?php echo get_permalink( $current_post_id ) . '#' . $card['slug'] ?>"></a>
</div>
