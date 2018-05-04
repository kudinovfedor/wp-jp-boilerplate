<?php

if (!function_exists('jp_rss_turbo')) {
    function jp_rss_turbo()
    {
        add_feed('rss-turbo', 'jp_rss_turbo_func');
    }

    add_action('init', 'jp_rss_turbo');
}

if (!function_exists('jp_rss_turbo_func')) {
    function jp_rss_turbo_func()
    {
        load_template('feed-rss2-turbo.php');
    }
}
