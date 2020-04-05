<?php include SS_TEMPLATE_DIR . 'default/header.php' ?>

<?php if ( ! empty( $section_data['cards'] ) ): ?>
    <div class="ss-content-sidebar-wrap">
        <?php
        include SS_TEMPLATE_DIR . 'default/toc.php';
        include SS_TEMPLATE_DIR . 'default/deck.php';
        ?>
    </div>
<?php endif ?>

<script>
    /* <![CDATA[ */
    var DECK = <?php echo json_encode( $section_data ) ?>;
    /* ]]> */
</script>

<?php include SS_TEMPLATE_DIR . 'default/footer.php' ?>
