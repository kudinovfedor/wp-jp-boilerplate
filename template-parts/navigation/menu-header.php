<?php

if (has_nav_menu('header_menu')) { ?>
    <nav class="navigation" itemscope itemtype="http://www.schema.org/SiteNavigationElement">
        <div class="container">
            <?php wp_nav_menu(array(
                'theme_location' => 'header_menu',
                'container'      => false,
                'menu_class'     => 'menu',
                'menu_id'        => '',
                'link_before'    => '<span itemprop="name">',
                'link_after'     => '</span>',
                'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            )); ?>
        </div>
    </nav>
<?php } ?>
