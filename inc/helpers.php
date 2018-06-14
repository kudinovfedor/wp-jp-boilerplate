<?php

if ( ! function_exists('wp-body')) {
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

if ( ! function_exists('theme_mod')) {
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

        if ( ! empty($theme_mod)) {
            echo $theme_mod;
        }
    }
}

if ( ! function_exists('e_get_option')) {
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

if ( ! function_exists('logo')) {
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

if ( ! function_exists('get_logo')) {
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

            $src  = JP_IMG . '/' . $file_name;
            $mime = mime_content_type($src_dir);

            if ('image/svg' !== $mime) {

                list($width, $height) = getimagesize($src);

                $logo_img = sprintf(
                    '<img class="logo-img" src="%s" width="%s" height="%s" alt="%s" itemprop="logo">',
                    esc_url($src),
                    esc_attr($width),
                    esc_attr($height),
                    get_bloginfo('name')
                );

            } else {

                $fill   = isset($attr['fill']) ? $attr['fill'] : '#000';
                $width  = isset($attr['width']) ? $attr['width'] : 100;
                $height = isset($attr['height']) ? $attr['height'] : 50;

                $logo_img = sprintf(
                    '<svg class="logo-img" width="%s" height="%s" fill="%s" aria-label="%s" itemprop="logo"><use xlink:href="#%s"></use></svg>',
                    esc_attr($width),
                    esc_attr($height),
                    esc_attr($fill),
                    get_bloginfo('name'),
                    esc_attr(basename($file_name, '.svg'))
                );

            }

            $html = sprintf(
                '<a class="logo-link" href="%s" itemprop="url">%s</a>',
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

if ( ! function_exists('get_hamburger')) {
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

if ( ! function_exists('hamburger')) {
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

if ( ! function_exists('btn_close_menu')) {
    function btn_close_menu($class = 'js-menu-close')
    {
        echo sprintf(
            '<button type="button" tabindex="0" class="menu-close %s" aria-label="%s"></button>',
            esc_attr($class),
            __('Close mobile menu.', 'joompress')
        );
    }
}

if ( ! function_exists('get_skip_to_content')) {
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

if ( ! function_exists('skip_to_content')) {
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

if ( ! function_exists('the_phone_number')) {
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

if ( ! function_exists('get_phone_number')) {
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

if ( ! function_exists('has_phones')) {
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

if ( ! function_exists('get_phones')) {
    /**
     * Return Phone Numbers in array
     *
     * @return array
     */
    function get_phones()
    {
        $_phones = [
            get_theme_mod('jp_phone_one'),
            get_theme_mod('jp_phone_two'),
            get_theme_mod('jp_phone_three'),
            get_theme_mod('jp_phone_four'),
            get_theme_mod('jp_phone_five'),
        ];

        $phones = array_filter($_phones, function ($value) {
            return ! empty($value);
        });

        return $phones;
    }
}

if ( ! function_exists('phones')) {
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

                $phone_icon = '<i class="fa fa-fw fa-phone" aria-hidden="true"></i>';

                $phone_number = sprintf(
                    '<a href="tel:%s" class="phone-number">%s %s</a>',
                    esc_attr(get_phone_number($phone)),
                    $phone_icon,
                    esc_html($phone)
                );

                $phone_item = sprintf('<li class="phone-item">%s</li>', $phone_number);

                $items .= $phone_item . PHP_EOL;

            }

            $phone_list = sprintf('<ul class="phone">%s</ul>', $items);

            echo $phone_list;
        }
    }
}

if ( ! function_exists('has_messengers')) {
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

if ( ! function_exists('get_messengers')) {
    /**
     * Return Messengers in array
     *
     * @return array
     */
    function get_messengers()
    {
        $_messengers = [
            'viber'    => [
                'tel'  => get_theme_mod('jp_messenger_viber'),
                'text' => 'Viber',
                'icon' => 'fa-viber',
            ],
            'whatsapp' => [
                'tel'  => get_theme_mod('jp_messenger_whatsapp'),
                'text' => 'WhatsApp',
                'icon' => 'fa-whatsapp',
            ],
            'telegram' => [
                'tel'  => get_theme_mod('jp_messenger_telegram'),
                'text' => 'Telegram',
                'icon' => 'fa-telegram',
            ],
        ];

        $messengers = array_filter($_messengers, function ($value) {
            return ! empty($value['tel']);
        });

        return $messengers;
    }
}

if ( ! function_exists('messenger')) {
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
                    '<i class="fa %s" aria-hidden="true" aria-label="%s"></i>',
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

if ( ! function_exists('has_social')) {
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

if ( ! function_exists('get_social')) {
    /**
     * Return Social Link in array
     *
     * @return array
     */
    function get_social()
    {
        $_socials = [
            'vk'            => [
                'url'  => get_theme_mod('jp_social_vk'),
                'text' => 'Vk',
                'icon' => 'fa-vk',
            ],
            'twitter'       => [
                'url'  => get_theme_mod('jp_social_twitter'),
                'text' => 'Twitter',
                'icon' => 'fa-twitter',
            ],
            'facebook'      => [
                'url'  => get_theme_mod('jp_social_facebook'),
                'text' => 'Facebook',
                'icon' => 'fa-facebook',
            ],
            'odnoklassniki' => [
                'url'  => get_theme_mod('jp_social_odnoklassniki'),
                'text' => 'Odnoklassniki',
                'icon' => 'fa-odnoklassniki',
            ],
            'linkedin'      => [
                'url'  => get_theme_mod('jp_social_linkedin'),
                'text' => 'Linkedin',
                'icon' => 'fa-linkedin',
            ],
            'instagram'     => [
                'url'  => get_theme_mod('jp_social_instagram'),
                'text' => 'Instagram',
                'icon' => 'fa-instagram',
            ],
            'google-plus'   => [
                'url'  => get_theme_mod('jp_social_google_plus'),
                'text' => 'Google Plus',
                'icon' => 'fa-google-plus',
            ],
            'youtube'       => [
                'url'  => get_theme_mod('jp_social_youtube'),
                'text' => 'YouTube',
                'icon' => 'fa-youtube-play',
            ],
            'pinterest'     => [
                'url'  => get_theme_mod('jp_social_pinterest'),
                'text' => 'Pinterest',
                'icon' => 'fa-pinterest',
            ],
            'tumblr'        => [
                'url'  => get_theme_mod('jp_social_tumblr'),
                'text' => 'Tumblr',
                'icon' => 'fa-tumblr',
            ],
            'flickr'        => [
                'url'  => get_theme_mod('jp_social_flickr'),
                'text' => 'Flickr',
                'icon' => 'fa-flickr',
            ],
            'reddit'        => [
                'url'  => get_theme_mod('jp_social_reddit'),
                'text' => 'Reddit',
                'icon' => 'fa-reddit',
            ],
            'rss'           => [
                'url'  => get_theme_mod('jp_social_rss'),
                'text' => 'RSS',
                'icon' => 'fa-rss',
            ],
        ];

        $socials = array_filter($_socials, function ($value) {
            return $value['url'] !== '#' && ! empty($value['url']) && filter_var($value['url'], FILTER_VALIDATE_URL);
        });

        return $socials;
    }
}

if ( ! function_exists('social')) {
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

                $social_icon = sprintf(
                    '<i class="fa %s" aria-hidden="true" aria-label="%s"></i>',
                    esc_attr($social['icon']),
                    esc_attr($social['text'])
                );

                $social_link = sprintf(
                    '<a class="social-link social-%s" href="%s" target="_blank" rel="nofollow noopener">%s</a>',
                    esc_attr($name),
                    esc_attr(esc_url($social['url'])),
                    $social_icon
                );

                $social_item = sprintf('<li class="social-item">%s</li>', $social_link);

                $items .= $social_item . PHP_EOL;
            }

            $social_list = sprintf('<ul class="social">%s</ul>', $items);

            echo $social_list;
        }
    }
}

if ( ! function_exists('scroll_top')) {
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

if ( ! function_exists('has_scroll_top')) {
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

if ( ! function_exists('get_scroll_top')) {
    /**
     * Return html markup for scroll top
     *
     * @return bool|string
     */
    function get_scroll_top()
    {
        if (has_scroll_top()) {

            $shape = '';

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

if ( ! function_exists('svg_sprite')) {
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

if ( ! function_exists('has_svg_sprite')) {
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

if ( ! function_exists('get_svg_sprite')) {
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

if ( ! function_exists('analytics_tracking_code')) {
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

if ( ! function_exists('get_analytics_tracking_code')) {
    /**
     * Return Analytics Tracking Code
     *
     * @param string $placed
     *
     * @return string
     */
    function get_analytics_tracking_code($placed = 'body')
    {
        $tracking_code           = array();
        $tracking_code['google'] = get_theme_mod('jp_analytics_google');
        $tracking_code['yandex'] = get_theme_mod('jp_analytics_yandex');
        $tracking_code['custom'] = get_theme_mod('jp_analytics_custom');

        $tracking_placed           = array();
        $tracking_placed['google'] = get_theme_mod('jp_analytics_google_placed', 'body');
        $tracking_placed['yandex'] = get_theme_mod('jp_analytics_yandex_placed', 'body');
        $tracking_placed['custom'] = get_theme_mod('jp_analytics_custom_placed', 'body');

        $output = '';

        foreach ($tracking_code as $key => $script) {
            if ( ! empty($tracking_placed[$key]) && ! empty($script)) {
                if ($tracking_placed[$key] === $placed) {
                    $output .= $script . PHP_EOL;
                }
            }
        };

        if ( ! empty($output)) {
            return sprintf('<script>%s</script>', $output);
            //return $output;
        }

        return '';

    }
}

if ( ! function_exists('copyright')) {
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

if ( ! function_exists('get_copyright')) {
    /**
     * Return copyright info
     *
     * @return string Copyright info
     */
    function get_copyright()
    {
        return sprintf(
            __('Copyright &copy; <span itemprop="copyrightYear">%d</span> %s. %s.', 'joompress'),
            date('Y'),
            get_bloginfo('name'),
            __('All rights reserved', 'joompress')
        );
    }
}

if ( ! function_exists('delete_post_link')) {
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
        if ( ! $post = get_post($id)) {
            return;
        }

        if ( ! $url = get_delete_post_link($post->ID)) {
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

if ( ! function_exists('dump')) {
    /**
     * Dumps information about a variable
     *
     * @param mixed $expression
     *
     * @return void
     */
    function dump($expression)
    {
        echo '<pre>';
        var_dump($expression);
        echo '</pre>';
    }
}

if ( ! function_exists('dd')) {
    /**
     * Dump and die
     *
     * @param mixed $expression
     *
     * @return void
     */
    function dd($expression)
    {
        dump($expression);
        die();
    }
}

if ( ! function_exists('get_google_map_options')) {
    /**
     * Get Google Map Options
     *
     * @return array
     */
    function get_google_map_options()
    {
        $map_options = array(
            // Project Setup
            'enable'                   => get_theme_mod('google_map_js_display', false),
            'api_key'                  => get_theme_mod('google_map_project_setup_api_key'),
            'version'                  => get_theme_mod('google_map_project_setup_version'),
            'language'                 => get_theme_mod('google_map_project_setup_language'),
            'region'                   => get_theme_mod('google_map_project_setup_region'),
            'callback'                 => get_theme_mod('google_map_project_setup_map_callback', 'initMap'),
            'selector'                 => get_theme_mod('google_map_project_setup_map_selector', 'google-map'),
            'width'                    => get_theme_mod('google_map_project_setup_width', 600),
            'height'                   => get_theme_mod('google_map_project_setup_height', 400),
            'latitude'                 => get_theme_mod('google_map_project_setup_latitude', 36.580247),
            'longitude'                => get_theme_mod('google_map_project_setup_longitude', -41.817628),
            'zoom'                     => get_theme_mod('google_map_project_setup_zoom_level', 3),

            // Controls
            'type_control'             => get_theme_mod('google_map_controls_map_type', 'horizontal_bar'),
            'zoom_control'             => get_theme_mod('google_map_controls_zoom', 1),
            'gesture_handling_control' => get_theme_mod('google_map_controls_gesture_handling', 'auto'),
            'full_screen_control'      => get_theme_mod('google_map_controls_full_screen', 0),
            'street_view_control'      => get_theme_mod('google_map_controls_street_view', 1),
            'scale_control'            => get_theme_mod('google_map_controls_scale', 1),
            'clickable_poi_control'    => get_theme_mod('google_map_controls_clickable_poi', 0),
            'draggable'                => get_theme_mod('google_map_controls_draggable', 1),
            'double_click_zoom'        => get_theme_mod('google_map_controls_double_click_to_zoom', 1),
            'scroll_wheel'             => get_theme_mod('google_map_controls_mouse_wheel_to_zoom', 1),

            // Positions
            'type_position'            => get_theme_mod('google_map_positions_map_type', 1),
            'zoom_position'            => get_theme_mod('google_map_positions_zoom', 9),
            'street_view_position'     => get_theme_mod('google_map_positions_street_view', 9),
            'full_screen_position'     => get_theme_mod('google_map_positions_full_screen', 3),

            // Themes
            'type_themes'              => get_theme_mod('google_map_themes_type', 'roadmap'),
            'styles_themes'            => get_theme_mod('google_map_themes_styles', 0),
        );

        return $map_options;
    }
}

if ( ! function_exists('get_google_map_languages')) {
    /**
     * Get Google Map Languages
     *
     * @return array
     */
    function get_google_map_languages()
    {
        $languages = array(
            'ar'    => 'Arabic',
            'be'    => 'Belarusian',
            'bg'    => 'Bulgarian',
            'bn'    => 'Bengali',
            'ca'    => 'Catalan',
            'cs'    => 'Czech',
            'da'    => 'Danish',
            'de'    => 'German',
            'el'    => 'Greek',
            'en'    => 'English',
            'en-Au' => 'English(Australian)',
            'en-GB' => 'English(Great Britain)',
            'es'    => 'Spanish',
            'eu'    => 'Basque',
            'fa'    => 'Farsi',
            'fi'    => 'Finnish',
            'fil'   => 'Filipino',
            'fr'    => 'French',
            'gl'    => 'Galician',
            'gu'    => 'Gujarati',
            'hi'    => 'Hindi',
            'hr'    => 'Croatian',
            'hu'    => 'Hungarian',
            'id'    => 'Indonesian',
            'it'    => 'Italian',
            'iw'    => 'Hebrew',
            'ja'    => 'Japanese',
            'kk'    => 'Kazakh',
            'kn'    => 'Kannada',
            'ko'    => 'Korean',
            'ky'    => 'Kyrgyz',
            'lt'    => 'Lithuanian',
            'lv'    => 'Latvian',
            'mk'    => 'Macedonian',
            'ml'    => 'Malayalam',
            'mr'    => 'Marathi',
            'my'    => 'Burmese',
            'nl'    => 'Dutch',
            'no'    => 'Norwegian',
            'pa'    => 'Punjabi',
            'pl'    => 'Polish',
            'pt'    => 'Portuguese',
            'pt-BR' => 'Portuguese(Brazil)',
            'pt-PT' => 'Portuguese(Portugal)',
            'ro'    => 'Romanian',
            'ru'    => 'Russian',
            'sk'    => 'Slovak',
            'sl'    => 'Slovenian',
            'sq'    => 'Albanian',
            'sr'    => 'Serbian',
            'sv'    => 'Swedish',
            'ta'    => 'Tamil',
            'te'    => 'Telugu',
            'th'    => 'Thai',
            'tl'    => 'Tagalog',
            'tr'    => 'Turkish',
            'uk'    => 'Ukrainian',
            'uz'    => 'Uzbek',
            'vi'    => 'Vietnamese',
            'zh-CN' => 'Chinese(Simlified)',
            'zh-TW' => 'Chinese(Traditional)',
        );

        return $languages;
    }
}

if ( ! function_exists('get_googleapis_src')) {
    /**
     * Get Google Map Api Src
     *
     * @return string
     */
    function get_googleapis_src()
    {
        $map = get_google_map_options();

        $query_data = array(
            'v'        => $map['version'],
            'language' => $map['language'],
            'region'   => $map['region'],
            'key'      => $map['api_key'],
            'callback' => $map['callback'],
        );

        $query_data = array_filter($query_data, function ($value, $key) {
            return ! empty($value);
        }, ARRAY_FILTER_USE_BOTH);

        $query = http_build_query($query_data);

        $src = sprintf('https://maps.googleapis.com/maps/api/js?%s', $query);

        return $src;
    }
}

if ( ! function_exists('google_map_html')) {
    /**
     * Display Google Map HTML Markup
     *
     * @return void
     */
    function google_map_html()
    {
        $map = get_google_map_options();

        if ($map['enable']) {

            $markup = sprintf(
                '<div id="%s" style="width: %spx; height: %spx;"></div>',
                $map['selector'], $map['width'], $map['height']
            );

            if (is_customize_preview()) {
                $markup = sprintf('<div class="jp-google-map">%s</div>', $markup);
            }

            echo $markup;
        }
    }
}

if ( ! function_exists('isOptionEnabled')) {
    /**
     * Is Option Enabled
     *
     * @param $option
     *
     * @return void
     */
    function isOptionEnabled($option)
    {
        echo $option ? 'true' : 'false';
    }
}

if ( ! function_exists('get_recaptcha_languages')) {
    /**
     * Get reCAPTCHA Languages
     *
     * @return array
     */
    function get_recaptcha_languages()
    {
        $languages = array(
            'ar'     => 'Arabic',
            'af'     => 'Afrikaans',
            'am'     => 'Amharic',
            'hy'     => 'Armenian',
            'az'     => 'Azerbaijani',
            'eu'     => 'Basque',
            'bn'     => 'Bengali',
            'bg'     => 'Bulgarian',
            'ca'     => 'Catalan',
            'zh-HK'  => 'Chinese (Hong Kong)',
            'zh-CN'  => 'Chinese (Simplified)',
            'zh-TW'  => 'Chinese (Traditional)',
            'hr'     => 'Croatian',
            'cs'     => 'Czech',
            'da'     => 'Danish',
            'nl'     => 'Dutch',
            'en-GB'  => 'English (UK)',
            'en'     => 'English (US)',
            'et'     => 'Estonian',
            'fil'    => 'Filipino',
            'fi'     => 'Finnish',
            'fr'     => 'French',
            'fr-CA'  => 'French (Canadian)',
            'gl'     => 'Galician',
            'ka'     => 'Georgian',
            'de'     => 'German',
            'de-AT'  => 'German (Austria)',
            'de-CH'  => 'German (Switzerland)',
            'el'     => 'Greek',
            'gu'     => 'Gujarati',
            'iw'     => 'Hebrew',
            'hi'     => 'Hindi',
            'hu'     => 'Hungarain',
            'is'     => 'Icelandic',
            'id'     => 'Indonesian',
            'it'     => 'Italian',
            'ja'     => 'Japanese',
            'kn'     => 'Kannada',
            'ko'     => 'Korean',
            'lo'     => 'Laothian',
            'lv'     => 'Latvian',
            'lt'     => 'Lithuanian',
            'ms'     => 'Malay',
            'ml'     => 'Malayalam',
            'mr'     => 'Marathi',
            'mn'     => 'Mongolian',
            'no'     => 'Norwegian',
            'fa'     => 'Persian',
            'pl'     => 'Polish',
            'pt'     => 'Portuguese',
            'pt-BR'  => 'Portuguese (Brazil)',
            'pt-PT'  => 'Portuguese (Portugal)',
            'ro'     => 'Romanian',
            'ru'     => 'Russian',
            'sr'     => 'Serbian',
            'si'     => 'Sinhalese',
            'sk'     => 'Slovak',
            'sl'     => 'Slovenian',
            'es'     => 'Spanish',
            'es-419' => 'Spanish (Latin America)',
            'sw'     => 'Swahili',
            'sv'     => 'Swedish',
            'ta'     => 'Tamil',
            'te'     => 'Telugu',
            'th'     => 'Thai',
            'tr'     => 'Turkish',
            'uk'     => 'Ukrainian',
            'ur'     => 'Urdu',
            'vi'     => 'Vietnamese',
            'zu'     => 'Zulu',
        );

        return $languages;
    }
}

if ( ! function_exists('get_recaptcha_src')) {
    /**
     * Get Google Map Api Src
     *
     * @return string
     */
    function get_recaptcha_src()
    {
        $query_data = array(
            'onload' => '',
            'render' => '',
            'hl'     => get_theme_mod('jp_recaptcha_language'),
        );

        $query_data = array_filter($query_data, function ($value, $key) {
            return ! empty($value);
        }, ARRAY_FILTER_USE_BOTH);

        $query = http_build_query($query_data);

        $url = 'https://www.google.com/recaptcha/api.js';

        if(empty($query)) {
            return $url;
        }

        $src = sprintf($url . '?%s', $query);

        return $src;
    }
}

if ( ! function_exists('get_recaptcha_tag_attributes')) {
    /**
     * g-recaptcha tag attributes and grecaptcha.render parameters
     *
     * @return array
     */
    function get_recaptcha_tag_attributes()
    {
        $attr = array(
            'site-key'            => get_theme_mod('jp_recaptcha_site_key'),
            'secret-key'          => get_theme_mod('jp_recaptcha_secret_key'),
            'login-form'          => get_theme_mod('jp_recaptcha_login_form'),
            'registration-form'   => get_theme_mod('jp_recaptcha_registration_form'),
            'reset-password-form' => get_theme_mod('jp_recaptcha_reset_password_form'),
            'comments-form'       => get_theme_mod('jp_recaptcha_comments_form'),
            'theme'               => get_theme_mod('jp_recaptcha_theme'),
            'size'                => get_theme_mod('jp_recaptcha_size'),
            'language'            => get_theme_mod('jp_recaptcha_language'),
            'tabindex'            => get_theme_mod('jp_recaptcha_tabindex'),
            'callback'            => get_theme_mod('jp_recaptcha_callback'),
            'expired-callback'    => get_theme_mod('jp_recaptcha_expired_callback'),
            'error-callback'      => get_theme_mod('jp_recaptcha_error_callback'),
        );

        return $attr;
    }
}

if ( ! function_exists('jp_get_ip')) {
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
            if ( ! empty($_SERVER[$ip_field])) {
                return $_SERVER[$ip_field];
            }
        }

        return null;
    }
}
