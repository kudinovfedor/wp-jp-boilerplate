<?php

/**
 * Constants
 */
if (!defined('JP_TEMPLATE')) {
    define('JP_TEMPLATE', get_template_directory_uri());
}

if (!defined('JP_LANGUAGES')) {
    define('JP_LANGUAGES', JP_TEMPLATE . '/languages');
}

if (!defined('JP_ASSETS')) {
    define('JP_ASSETS', JP_TEMPLATE . '/assets');
}

if (!defined('JP_JS')) {
    define('JP_JS', JP_ASSETS . '/js');
}

if (!defined('JP_CSS')) {
    define('JP_CSS', JP_ASSETS . '/css');
}

if (!defined('JP_IMG')) {
    define('JP_IMG', JP_ASSETS . '/img');
}

if (!defined('JP_FAVICON')) {
    define('JP_FAVICON', JP_IMG . '/favicon');
}
