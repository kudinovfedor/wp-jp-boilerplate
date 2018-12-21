<?php if (has_nav_menu('header_menu')) { ?>
    <!-- HEADER MENU -->
    <nav class="menu js-menu" itemscope itemtype="http://www.schema.org/SiteNavigationElement">
        <div class="container">
            <?php wp_nav_menu([
                'theme_location' => 'header_menu',
                'container' => false,
                'menu_class' => 'menu-list',
                'menu_id' => '',
                'link_before' => '<span itemprop="name">',
                'link_after' => '</span>',
                'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'fallback_cb' => false,
            ]); ?>
            <?php btn_close_menu('js-menu-close'); ?>
        </div>
    </nav>
    <!-- /END HEADER MENU -->
<?php } ?>
