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
        'before_widget' => '<div id="%1$s" class="sidebar-item widget %2$s">',
        'after_widget' => "</div>\n",
        'before_title' => '<div class="widget-title">',
        'after_title' => "</div>\n",
    ]);

    register_sidebar([
        'name' => __('Sidebar Right', 'joompress'),
        'id' => "sidebar-right",
        'description' => __('Sidebar Right', 'joompress'),
        'before_widget' => '<div id="%1$s" class="sidebar-item widget %2$s">',
        'after_widget' => "</div>\n",
        'before_title' => '<div class="widget-title">',
        'after_title' => "</div>\n",
    ]);
}

add_action('widgets_init', 'jp_widgets_init');
