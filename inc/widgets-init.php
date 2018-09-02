<?php

/**
 * Widgets Init
 */
function jp_widgets_init()
{
    register_sidebar([
        'name' => __('Sidebar Left', 'joompress'),
        'id' => "sidebar-left",
        'description' => __('Sidebar Left', 'joompress'),
        'before_widget' => '<section id="%1$s" class="sidebar-item widget %2$s">',
        'after_widget' => "</section>\n",
        'before_title' => '<h4 class="widget-title" itemprop="name">',
        'after_title' => "</h4>\n",
    ]);

    register_sidebar([
        'name' => __('Sidebar Right', 'joompress'),
        'id' => "sidebar-right",
        'description' => __('Sidebar Right', 'joompress'),
        'before_widget' => '<section id="%1$s" class="sidebar-item widget %2$s">',
        'after_widget' => "</section>\n",
        'before_title' => '<h4 class="widget-title" itemprop="name">',
        'after_title' => "</h4>\n",
    ]);
}

add_action('widgets_init', 'jp_widgets_init');
