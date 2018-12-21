<?php if (has_nav_menu('footer_menu')) { ?>
    <!-- FOOTER MENU -->
    <?php wp_nav_menu([
        'theme_location' => 'footer_menu',
        'container' => false,
        'menu_class' => 'menu-list',
        'menu_id' => '',
        'link_before' => '<span itemprop="name">',
        'link_after' => '</span>',
        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'fallback_cb' => false,
    ]); ?>
    <!-- /END FOOTER MENU -->
<?php } ?>
