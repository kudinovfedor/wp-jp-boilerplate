<?php

if (!function_exists('wp-body')) {
    /**
     * Fire the wp_body action.
     */
    function wp_body()
    {
        /**
         * Prints scripts or data in the body tag on the front end.
         */
        do_action('wp_body');
    }
}

if (!function_exists('theme_mod')) {
    /**
     * Display theme modification value for the current theme.
     *
     * @param string $name Theme modification name.
     * @param bool|string $default
     *
     * @return void
     */
    function theme_mod($name, $default = false)
    {
        $theme_mod = get_theme_mod($name, $default);

        if (!empty($theme_mod)) {
            echo $theme_mod;
        }
    }
}

if (!function_exists('e_get_option')) {
    /**
     * Displays an option value based on an option name
     *
     * @see get_option()
     *
     * @param string $option Name of option to retrieve. Expected to not be SQL-escaped.
     * @param mixed $default Optional. Default value to return if the option does not exist.
     *
     * @return void
     */
    function e_get_option($option, $default = false)
    {
        echo get_option($option, $default);
    }
}

if (!function_exists('logo')) {
    /**
     * Displays a logo, linked to home.
     *
     * @param string $file_name
     *
     * @param array $attr
     *
     * @return void
     * @see get_logo()
     *
     */
    function logo($file_name = 'logo.png', $attr = array())
    {
        echo get_logo($file_name, $attr);
    }
}

if (!function_exists('get_logo_url')) {
    /**
     * Returns a logo url
     *
     * @return string
     */
    function get_logo_url()
    {
        $custom_logo_id = get_theme_mod('custom_logo');
        $custom_logo_url = $custom_logo_id ? wp_get_attachment_image_url($custom_logo_id, 'full') : '';
        $logo_url = $custom_logo_url ?: get_template_directory_uri() . '/assets/img/logo.png';

        return $logo_url;
    }
}

if (!function_exists('get_logo')) {
    /**
     * Returns a logo, linked to home.
     *
     * @param string $file_name
     *
     * @param array $attr
     *
     * @return string Logo markup.
     */
    function get_logo($file_name = 'logo.png', $attr = array())
    {
        $src_dir = get_template_directory() . '/assets/img/' . $file_name;

        $html = '';

        if (file_exists($src_dir)) {

            $src = JP_IMG . '/' . $file_name;
            $mime = mime_content_type($src_dir);

            if ('image/svg' !== $mime) {

                list($width, $height) = getimagesize($src);

                $logo_img = sprintf(
                    '<img class="logo-img" src="%s" width="%s" height="%s" alt="%s">',
                    esc_url($src),
                    esc_attr($width),
                    esc_attr($height),
                    get_bloginfo('name')
                );

            } else {

                $fill = $attr['fill'] ?: '#000';
                $width = $attr['width'] ?: 100;
                $height = $attr['height'] ?: 50;

                $logo_img = sprintf(
                    '<svg class="logo-img" width="%s" height="%s" fill="%s" aria-label="%s"><use xlink:href="#%s"></use></svg>',
                    esc_attr($width),
                    esc_attr($height),
                    esc_attr($fill),
                    get_bloginfo('name'),
                    esc_attr(basename($file_name, '.svg'))
                );

            }

            $html = sprintf(
                '<a class="logo-link" href="%s">%s</a>',
                esc_url(home_url('/')),
                $logo_img
            );

        } else {
            trigger_error(
                sprintf('A file name %s is not found in %s/', $file_name, JP_IMG),
                E_USER_WARNING
            );
        }

        return $html;
    }
}

if (!function_exists('get_hamburger')) {
    /**
     * Return Hamburger HTML Markup
     *
     * @param string $class
     *
     * @return string
     */
    function get_hamburger($class = 'js-hamburger')
    {
        $hamburger_box = '<span class="hamburger-box"><span class="hamburger-inner"></span></span>';

        $hamburger_markup = sprintf(
            '<button class="hamburger %s" type="button" tabindex="0" aria-label="%s">%s</button>',
            esc_attr($class),
            __('Trigger mobile menu.', 'joompress'),
            $hamburger_box
        );

        return $hamburger_markup;
    }
}

if (!function_exists('hamburger')) {
    /**
     * Display Hamburger HTML Markup
     *
     * @see get_hamburger()
     *
     * @param string $class
     *
     * @return void
     */
    function hamburger($class = 'js-hamburger')
    {
        echo get_hamburger($class);
    }
}

if (!function_exists('btn_close_menu')) {
    function btn_close_menu($class = 'js-menu-close')
    {
        echo sprintf(
            '<button type="button" tabindex="0" class="menu-close %s" aria-label="%s"></button>',
            esc_attr($class),
            __('Close mobile menu.', 'joompress')
        );
    }
}

if (!function_exists('get_skip_to_content')) {
    /**
     * Return Skip To Content HTML Markup
     *
     * @param string $id
     *
     * @return string
     */
    function get_skip_to_content($id = 'content')
    {
        return sprintf(
            '<a class="skip-link screen-reader-text" href="#%s" tabindex="0">%s</a>',
            esc_attr($id),
            __('Skip to content', 'joompress')
        );
    }
}

if (!function_exists('skip_to_content')) {
    /**
     * Display Skip To Content HTML Markup
     *
     * @see get_skip_to_content()
     *
     * @param string $id
     *
     * @return void
     */
    function skip_to_content($id = 'content')
    {
        echo get_skip_to_content($id);
    }
}

if (!function_exists('the_phone_number')) {
    /**
     * Display phone number for html markup <a href="tel:phone_number"></a>
     *
     * @param $phone_number
     *
     * @see get_phone_number()
     * @return void
     */
    function the_phone_number($phone_number)
    {
        echo get_phone_number($phone_number);
    }
}

if (!function_exists('get_phone_number')) {
    /**
     * Clear phone number for tag <a href="tel:phone_number"></a>
     *
     * @param string $phone_number
     *
     * @return string
     */
    function get_phone_number($phone_number)
    {
        return str_replace(array('-', '(', ')', ' '), '', $phone_number);
    }
}

if (!function_exists('has_phones')) {
    /**
     * Determines whether the site has a phone numbers.
     *
     * @see get_phones()
     *
     * @return bool
     */
    function has_phones()
    {
        return (bool)get_phones();
    }
}

if (!function_exists('get_phones')) {
    /**
     * Return Phone Numbers in array
     *
     * @return array
     */
    function get_phones()
    {
        $_phones = array(
            get_theme_mod('jp_phone_one'),
            get_theme_mod('jp_phone_two'),
            get_theme_mod('jp_phone_three'),
            get_theme_mod('jp_phone_four'),
            get_theme_mod('jp_phone_five'),
        );

        $phones = array_filter($_phones, function ($value) {
            return !empty($value);
        });

        return $phones;
    }
}

if (!function_exists('phones')) {
    /**
     * Display Phone Numbers
     *
     * @see has_phones()
     * @see get_phones()
     *
     * @return void
     */
    function phones()
    {
        if (has_phones()) {

            $items = '';

            foreach (get_phones() as $phone) {

                $icon = '<i class="fas fa-phone fa-fw" aria-hidden="true"></i>';

                $number = sprintf(
                    '<a href="tel:%s" class="phone-number">%s %s</a>',
                    esc_attr(get_phone_number($phone)),
                    $icon,
                    esc_html($phone)
                );

                $item = sprintf('<li class="phone-item">%s</li>', $number);

                $items .= $item . PHP_EOL;

            }

            $list = sprintf('<ul class="phone">%s</ul>', $items);

            echo $list;
        }
    }
}

if (!function_exists('has_messengers')) {
    /**
     * Determines whether the site has a messenger.
     *
     * @see get_messengers()
     * @return bool
     */
    function has_messengers()
    {
        return (bool)get_messengers();
    }
}

if (!function_exists('get_messengers')) {
    /**
     * Return Messengers in array
     *
     * @return array
     */
    function get_messengers()
    {
        $_messengers = array(
            'skype' => array(
                'tel' => get_theme_mod('jp_messenger_skype'),
                'text' => 'Skype',
                'icon' => 'fab fa-skype',
            ),
            'viber' => array(
                'tel' => get_theme_mod('jp_messenger_viber'),
                'text' => 'Viber',
                'icon' => 'fab fa-viber',
            ),
            'whatsapp' => array(
                'tel' => get_theme_mod('jp_messenger_whatsapp'),
                'text' => 'WhatsApp',
                'icon' => 'fab fa-whatsapp',
            ),
            'telegram' => array(
                'tel' => get_theme_mod('jp_messenger_telegram'),
                'text' => 'Telegram',
                'icon' => 'fab fa-telegram-plane',
            ),
        );

        $messengers = array_filter($_messengers, function ($value) {
            return !empty($value['tel']);
        });

        return $messengers;
    }
}

if (!function_exists('messenger')) {
    /**
     * Display Messengers
     *
     * @see has_messengers()
     * @see get_messengers()
     *
     * @return void
     */
    function messengers()
    {
        if (has_messengers()) {

            $items = '';

            foreach (get_messengers() as $name => $messenger) {

                $icon = sprintf(
                    '<i class="%s" aria-hidden="true" aria-label="%s"></i>',
                    esc_attr($messenger['icon']),
                    esc_attr($messenger['text'])
                );

                $link = sprintf(
                    '<a class="messenger-link messenger-%s" href="tel:%s" target="_blank" rel="nofollow noopener">%s</a>',
                    esc_attr($name),
                    esc_attr(get_phone_number($messenger['tel'])),
                    $icon
                );

                $item = sprintf('<li class="messenger-item">%s</li>', $link);

                $items .= $item . PHP_EOL;
            }

            $list = sprintf('<ul class="messenger">%s</ul>', $items);

            echo $list;

        }
    }
}

if (!function_exists('has_social')) {
    /**
     * Determines whether the site has a social links.
     *
     * @see get_social()
     * @return bool
     */
    function has_social()
    {
        return (bool)get_social();
    }
}

if (!function_exists('get_social')) {
    /**
     * Return Social Link in array
     *
     * @return array
     */
    function get_social()
    {
        $_socials = array(
            'vk' => array(
                'url' => get_theme_mod('jp_social_vk'),
                'text' => 'Vk',
                'icon' => 'fab fa-vk',
            ),
            'twitter' => array(
                'url' => get_theme_mod('jp_social_twitter'),
                'text' => 'Twitter',
                'icon' => 'fab fa-twitter',
            ),
            'facebook' => array(
                'url' => get_theme_mod('jp_social_facebook'),
                'text' => 'Facebook',
                'icon' => 'fab fa-facebook-f',
            ),
            'odnoklassniki' => array(
                'url' => get_theme_mod('jp_social_odnoklassniki'),
                'text' => 'Odnoklassniki',
                'icon' => 'fab fa-odnoklassniki',
            ),
            'linkedin' => array(
                'url' => get_theme_mod('jp_social_linkedin'),
                'text' => 'Linkedin',
                'icon' => 'fab fa-linkedin-in',
            ),
            'instagram' => array(
                'url' => get_theme_mod('jp_social_instagram'),
                'text' => 'Instagram',
                'icon' => 'fab fa-instagram',
            ),
            'google-plus' => array(
                'url' => get_theme_mod('jp_social_google_plus'),
                'text' => 'Google Plus',
                'icon' => 'fab fa-google-plus-g',
            ),
            'youtube' => array(
                'url' => get_theme_mod('jp_social_youtube'),
                'text' => 'YouTube',
                'icon' => 'fab fa-youtube',
            ),
            'pinterest' => array(
                'url' => get_theme_mod('jp_social_pinterest'),
                'text' => 'Pinterest',
                'icon' => 'fab fa-pinterest-p',
            ),
            'tumblr' => array(
                'url' => get_theme_mod('jp_social_tumblr'),
                'text' => 'Tumblr',
                'icon' => 'fab fa-tumblr',
            ),
            'flickr' => array(
                'url' => get_theme_mod('jp_social_flickr'),
                'text' => 'Flickr',
                'icon' => 'fab fa-flickr',
            ),
            'reddit' => array(
                'url' => get_theme_mod('jp_social_reddit'),
                'text' => 'Reddit',
                'icon' => 'fab fa-reddit-alien',
            ),
            'rss' => array(
                'url' => get_theme_mod('jp_social_rss'),
                'text' => 'RSS',
                'icon' => 'fas fa-rss',
            ),
        );

        $socials = array_filter($_socials, function ($value) {
            return $value['url'] !== '#' && !empty($value['url']) && filter_var($value['url'], FILTER_VALIDATE_URL);
        });

        return $socials;
    }
}

if (!function_exists('social')) {
    /**
     * Display Social Networks
     *
     * @see has_social()
     * @see get_social()
     *
     * @return void
     */
    function social()
    {
        if (has_social()) {

            $items = '';

            foreach (get_social() as $name => $social) {

                $icon = sprintf(
                    '<i class="%s" aria-hidden="true" aria-label="%s"></i>',
                    esc_attr($social['icon']),
                    esc_attr($social['text'])
                );

                $link = sprintf(
                    '<a class="social-link social-%s" href="%s" target="_blank" rel="nofollow noopener">%s</a>',
                    esc_attr($name),
                    esc_attr(esc_url($social['url'])),
                    $icon
                );

                $item = sprintf('<li class="social-item">%s</li>', $link);

                $items .= $item . PHP_EOL;
            }

            $list = sprintf('<ul class="social">%s</ul>', $items);

            echo $list;
        }
    }
}

if (!function_exists('scroll_top')) {
    /**
     * Display scroll top
     *
     * @see get_scroll_top()
     * @return void
     */
    function scroll_top()
    {
        echo get_scroll_top();
    }
}

if (!function_exists('has_scroll_top')) {
    /**
     * Determines whether the site has a enable scroll top.
     *
     * @return string
     */
    function has_scroll_top()
    {
        return (bool)get_theme_mod('jp_scroll_top_enable');
    }
}

if (!function_exists('get_scroll_top')) {
    /**
     * Return html markup for scroll top
     *
     * @return bool|string
     */
    function get_scroll_top()
    {
        if (has_scroll_top()) {

            switch (get_theme_mod('jp_scroll_top_shape')) {
                case 'circle':
                    $shape = 'is-circle';
                    break;
                case 'rounded':
                    $shape = 'is-rounded';
                    break;
                default:
                    $shape = '';
                    break;
            }

            $position = get_theme_mod('jp_scroll_top_position', 'right');

            $output = sprintf(
                '<a href="#top" class="scroll-top js-scroll-top %s %s" role="button"><span class="screen-reader-text">%s</span><i class="scroll-top--arrow"></i></a>',
                $shape,
                $position === 'right' ? 'is-right' : 'is-left',
                __('Scroll to top', 'joompress')
            );

            return $output;
        }

        return false;
    }
}

if (!function_exists('svg_sprite')) {
    /**
     * Display svg sprite markup
     *
     * @see get_svg_sprite()
     * @return void
     */
    function svg_sprite()
    {
        echo get_svg_sprite();
    }
}

if (!function_exists('has_svg_sprite')) {
    /**
     * Determines file exist and file size > 0.
     *
     * @param string $file SVG Sprite file
     *
     * @return bool
     */
    function has_svg_spite($file)
    {
        return file_exists($file) && filesize($file);
    }
}

if (!function_exists('get_svg_sprite')) {
    /**
     * Return svg sprite markup
     *
     * @return string
     */
    function get_svg_sprite()
    {
        $svg_file = get_template_directory() . '/assets/img/svg-sprite.svg';

        ob_start();

        if (has_svg_spite($svg_file)) {
            load_template($svg_file);
        }

        return ob_get_clean();
    }
}

if (!function_exists('analytics_tracking_code')) {
    /**
     * Display Analytics Tracking Code
     *
     * @param string $placed
     *
     * @see get_analytics_tracking_code()
     * @return void
     */
    function analytics_tracking_code($placed = 'body')
    {
        echo get_analytics_tracking_code($placed);
    }
}

if (!function_exists('get_analytics_tracking_code')) {
    /**
     * Return Analytics Tracking Code
     *
     * @param string $placed
     *
     * @return string
     */
    function get_analytics_tracking_code($placed = 'body')
    {
        $tracking_code = array();
        $tracking_code['google'] = get_theme_mod('jp_analytics_google');
        $tracking_code['yandex'] = get_theme_mod('jp_analytics_yandex');
        $tracking_code['custom'] = get_theme_mod('jp_analytics_custom');

        $tracking_placed = array();
        $tracking_placed['google'] = get_theme_mod('jp_analytics_google_placed', 'body');
        $tracking_placed['yandex'] = get_theme_mod('jp_analytics_yandex_placed', 'body');
        $tracking_placed['custom'] = get_theme_mod('jp_analytics_custom_placed', 'body');

        $output = '';

        foreach ($tracking_code as $key => $script) {
            if (!empty($tracking_placed[$key]) && !empty($script)) {
                if ($tracking_placed[$key] === $placed) {
                    $output .= $script . PHP_EOL;
                }
            }
        };

        if (!empty($output)) {
            return sprintf('<script>%s</script>', $output);
            //return $output;
        }

        return '';

    }
}

if (!function_exists('copyright')) {
    /**
     * Display copyright info
     *
     * @see get_copyright()
     * @return void
     */
    function copyright()
    {
        echo get_copyright();
    }
}

if (!function_exists('get_copyright')) {
    /**
     * Return copyright info
     *
     * @return string Copyright info
     */
    function get_copyright()
    {
        return sprintf(
            __('Copyright &copy; %d %s. %s.', 'joompress'),
            date('Y'),
            get_bloginfo('name'),
            __('All rights reserved', 'joompress')
        );
    }
}

if (!function_exists('delete_post_link')) {
    /**
     * Displays the delete post link for post.
     *
     * @since 1.0.0
     * @since 4.4.0 The `$class` argument was added.
     *
     * @param string $text Optional. Anchor text. If null, default is 'Delete This'. Default null.
     * @param string $before Optional. Display before edit link. Default empty.
     * @param string $after Optional. Display after edit link. Default empty.
     * @param int $id Optional. Post ID. Default is the ID of the global `$post`.
     * @param string $class Optional. Add custom class to link. Default 'post-delete-link'.
     */
    function delete_post_link($text = null, $before = '', $after = '', $id = 0, $class = 'post-delete-link')
    {
        if (!$post = get_post($id)) {
            return;
        }

        if (!$url = get_delete_post_link($post->ID)) {
            return;
        }

        if (null === $text) {
            $text = __('Delete This', 'joompress');
        }

        $link = '<a class="' . esc_attr($class) . '" href="' . esc_url($url) . '">' . $text . '</a>';

        /**
         * Filters the post delete link anchor tag.
         *
         * @since 2.3.0
         *
         * @param string $link Anchor tag for the edit link.
         * @param int $post_id Post ID.
         * @param string $text Anchor text.
         */
        echo $before . apply_filters('delete_post_link', $link, $post->ID, $text) . $after;
    }
}

if (!function_exists('dump')) {
    /**
     * Dumps information about a variable
     *
     * @param mixed ...$expression
     *
     * @return void
     */
    function dump(...$expression)
    {
        echo '<pre>';
        var_dump($expression);
        echo '</pre>';
    }
}

if (!function_exists('dd')) {
    /**
     * Dump and die
     *
     * @param mixed ...$expression
     *
     * @return void
     */
    function dd(...$expression)
    {
        dump($expression);
        die();
    }
}

if (!function_exists('jp_get_ip')) {
    /**
     * Get client IP.
     *
     * @return string|null
     */
    function jp_get_ip()
    {
        $fields = array(
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR',
        );

        foreach ($fields as $ip_field) {
            if (!empty($_SERVER[$ip_field])) {
                return $_SERVER[$ip_field];
            }
        }

        return null;
    }
}


if (!function_exists('jp_pagination')) {
    /**
     * @param array $args
     * @return array
     */
    function jp_pagination($args = array())
    {
        global $wp_query, $wp_rewrite;

        // Setting up default values based on the current URL.
        $pagenum_link = html_entity_decode(get_pagenum_link());
        $url_parts = explode('?', $pagenum_link);

        // Get max pages and current page out of the current query, if available.
        $total = isset($wp_query->max_num_pages) ? $wp_query->max_num_pages : 1;
        $current = get_query_var('paged') ? intval(get_query_var('paged')) : 1;

        // Append the format placeholder to the base URL.
        $pagenum_link = trailingslashit($url_parts[0]) . '%_%';

        // URL base depends on permalink settings.
        $format = $wp_rewrite->using_index_permalinks() && !strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
        $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit($wp_rewrite->pagination_base . '/%#%',
            'paged') : '?paged=%#%';

        $defaults = array(
            'base' => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
            'format' => $format, // ?page=%#% : %#% is replaced by the page number
            'total' => $total,
            'current' => $current,
            'aria_current' => 'page',
            'show_all' => false,
            'prev_next' => true,
            'prev_text' => '&laquo;',
            'next_text' => '&raquo;',
            'end_size' => 1,
            'mid_size' => 1,
            'type' => 'list',
            'add_args' => array(), // array of query args to add
            'add_fragment' => '',
            'before_page_number' => '',
            'after_page_number' => '',
        );

        $args = wp_parse_args($args, $defaults);

        if (!is_array($args['add_args'])) {
            $args['add_args'] = array();
        }

        // Merge additional query vars found in the original URL into 'add_args' array.
        if (isset($url_parts[1])) {
            // Find the format argument.
            $format = explode('?', str_replace('%_%', $args['format'], $args['base']));
            $format_query = isset($format[1]) ? $format[1] : '';
            wp_parse_str($format_query, $format_args);

            // Find the query args of the requested URL.
            wp_parse_str($url_parts[1], $url_query_args);

            // Remove the format argument from the array of query arguments, to avoid overwriting custom format.
            foreach ($format_args as $format_arg => $format_arg_value) {
                unset($url_query_args[$format_arg]);
            }

            $args['add_args'] = array_merge($args['add_args'], urlencode_deep($url_query_args));
        }

        // Who knows what else people pass in $args
        $total = (int)$args['total'];
        if ($total < 2) {
            return;
        }
        $current = (int)$args['current'];
        $end_size = (int)$args['end_size']; // Out of bounds?  Make it the default.
        if ($end_size < 1) {
            $end_size = 1;
        }
        $mid_size = (int)$args['mid_size'];
        if ($mid_size < 0) {
            $mid_size = 2;
        }
        $add_args = $args['add_args'];
        $r = '';
        $page_links = array();
        $dots = false;

        if ($args['prev_next'] && $current && 1 < $current) :
            $link = str_replace('%_%', 2 == $current ? '' : $args['format'], $args['base']);
            $link = str_replace('%#%', $current - 1, $link);
            if ($add_args) {
                $link = add_query_arg($add_args, $link);
            }
            $link .= $args['add_fragment'];

            /**
             * Filters the paginated links for the given archive pages.
             *
             * @since 3.0.0
             *
             * @param string $link The paginated link URL.
             */
            $page_links[] = '<a class="pagination-link pagination-prev" href="' . esc_url(apply_filters('paginate_links',
                    $link)) . '">' . $args['prev_text'] . '</a>';
        endif;
        for ($n = 1; $n <= $total; $n++) :
            if ($n == $current) :
                $page_links[] = "<span aria-current='" . esc_attr($args['aria_current']) . "' class='pagination-link is-current'>" . $args['before_page_number'] . number_format_i18n($n) . $args['after_page_number'] . "</span>";
                $dots = true;
            else :
                if ($args['show_all'] || ($n <= $end_size || ($current && $n >= $current - $mid_size && $n <= $current + $mid_size) || $n > $total - $end_size)) :
                    $link = str_replace('%_%', 1 == $n ? '' : $args['format'], $args['base']);
                    $link = str_replace('%#%', $n, $link);
                    if ($add_args) {
                        $link = add_query_arg($add_args, $link);
                    }
                    $link .= $args['add_fragment'];

                    /** This filter is documented in wp-includes/general-template.php */
                    $page_links[] = "<a class='pagination-link' href='" . esc_url(apply_filters('paginate_links',
                            $link)) . "'>" . $args['before_page_number'] . number_format_i18n($n) . $args['after_page_number'] . "</a>";
                    $dots = true;
                elseif ($dots && !$args['show_all']) :
                    $page_links[] = '<span class="pagination-link pagination-dots">' . __('&hellip;', 'joompress') . '</span>';
                    $dots = false;
                endif;
            endif;
        endfor;
        if ($args['prev_next'] && $current && $current < $total) :
            $link = str_replace('%_%', $args['format'], $args['base']);
            $link = str_replace('%#%', $current + 1, $link);
            if ($add_args) {
                $link = add_query_arg($add_args, $link);
            }
            $link .= $args['add_fragment'];

            /** This filter is documented in wp-includes/general-template.php */
            $page_links[] = '<a class="pagination-link pagination-next" href="' . esc_url(apply_filters('paginate_links',
                    $link)) . '">' . $args['next_text'] . '</a>';
        endif;
        switch ($args['type']) {
            case 'array' :
                return $page_links;

            case 'list' :
                $r .= "<ul class='pagination-list'>\n\t<li class='pagination-item'>";
                $r .= join("</li>\n\t<li class='pagination-item'>", $page_links);
                $r .= "</li>\n</ul>\n";
                break;

            default :
                $r = join("\n", $page_links);
                break;
        }

        echo $r;
    }
}

if (!function_exists('jp_comments_pagination')) {
    /**
     * @param array $args
     *
     * @return void
     */
    function jp_comments_pagination($args = array())
    {

        if (isset($args['type']) && 'array' == $args['type']) {
            $args['type'] = 'plain';
        }

        global $wp_rewrite;

        if (!is_singular()) {
            return;
        }

        $page = get_query_var('cpage');
        if (!$page) {
            $page = 1;
        }
        $max_page = get_comment_pages_count();
        $defaults = array(
            'base' => add_query_arg('cpage', '%#%'),
            'format' => '',
            'total' => $max_page,
            'current' => $page,
            'echo' => true,
            'add_fragment' => '#comments',
            'prev_text' => __('&laquo; Previous', 'joompress'),
            'next_text' => __('Next &raquo;', 'joompress'),
        );
        if ($wp_rewrite->using_permalinks()) {
            $defaults['base'] = user_trailingslashit(trailingslashit(get_permalink()) . $wp_rewrite->comments_pagination_base . '-%#%',
                'commentpaged');
        }

        $args = wp_parse_args($args, $defaults);

        jp_pagination($args);
    }
}

if (!function_exists('sanitize_checkbox')) {
    /**
     * @param $input
     * @return bool
     */
    function sanitize_checkbox($input)
    {
        return (isset($input) ? true : false);
    }
}

if (!function_exists('sanitize_select')) {
    /**
     * @param $input
     * @param WP_Customize_Setting $setting
     * @return string
     */
    function sanitize_select($input, $setting)
    {
        $input = sanitize_key($input);

        $choices = $setting->manager->get_control($setting->id)->choices;

        return (array_key_exists($input, $choices) ? $input : $setting->default);
    }
}

if (!function_exists('sanitize_radio')) {
    /**
     * @param $input
     * @param WP_Customize_Setting $setting
     * @return string
     */
    function sanitize_radio($input, $setting)
    {
        $input = sanitize_key($input);

        $choices = $setting->manager->get_control($setting->id)->choices;

        return (array_key_exists($input, $choices) ? $input : $setting->default);
    }
}
