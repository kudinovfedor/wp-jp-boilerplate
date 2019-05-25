<?php

if (!class_exists('Social')) {
    /**
     * Class Social
     *
     * @author Kudinov Fedor <admin@joompress.biz>
     */
    class Social
    {
        /**
         * Social constructor.
         */
        public function __construct()
        {
            add_action('customize_register', [$this, 'customizeRegister']);
            add_shortcode('jp_social', [$this, 'addShortcode']);
        }

        /**
         * Return Social Link in array
         *
         * @param array $options
         *
         * @return array
         */
        public function getSocial($options = [])
        {
            $defaults = [
                'share' => false,
                'only' => [],
                'exclude' => [],
            ];

            $args = wp_parse_args($options, $defaults);

            /** @var WP_Post $post */
            global $post;

            $url = get_the_permalink();
            $title = get_the_title();
            $desc = has_excerpt() ? get_the_excerpt() : wp_trim_words($post->post_content, 55);
            $thumbnail = has_post_thumbnail() ? esc_url(get_the_post_thumbnail_url()) : '';

            $_socials = [
                'vk' => [
                    'url' => get_theme_mod('jp_social_vk'),
                    // https://vk.com/dev/widget_share
                    'share' => sprintf('https://vk.com/share.php?url=%s&title=%s', $url, $title),
                    'text' => 'Vk',
                    'icon' => 'fab fa-vk',
                ],
                'twitter' => [
                    'url' => get_theme_mod('jp_social_twitter'),
                    // https://developer.twitter.com/en/docs/twitter-for-websites/tweet-button/guides/web-intent
                    'share' => sprintf('https://twitter.com/intent/tweet?url=%s&text=%s', $url, $desc),
                    'text' => 'Twitter',
                    'icon' => 'fab fa-twitter',
                ],
                'facebook' => [
                    'url' => get_theme_mod('jp_social_facebook'),
                    // https://developers.facebook.com/docs/plugins/share-button
                    'share' => sprintf('https://www.facebook.com/sharer/sharer.php?u=%s', $url),
                    'text' => 'Facebook',
                    'icon' => 'fab fa-facebook-f',
                ],
                'odnoklassniki' => [
                    'url' => get_theme_mod('jp_social_odnoklassniki'),
                    // https://apiok.ru/ext/like
                    'share' => sprintf('https://connect.ok.ru/offer?url=%s&title=%s', $url, $title),
                    'text' => 'Odnoklassniki',
                    'icon' => 'fab fa-odnoklassniki',
                ],
                'linkedin' => [
                    'url' => get_theme_mod('jp_social_linkedin'),
                    // https://developer.linkedin.com/docs/share-on-linkedin
                    'share' => sprintf(
                        'https://www.linkedin.com/shareArticle?mini=true&url=%s&title=%s&summary=%s',
                        $url, $title, $desc
                    ),
                    'text' => 'Linkedin',
                    'icon' => 'fab fa-linkedin-in',
                ],
                'instagram' => [
                    'url' => get_theme_mod('jp_social_instagram'),
                    'text' => 'Instagram',
                    'icon' => 'fab fa-instagram',
                ],
                'google-plus' => [
                    'url' => get_theme_mod('jp_social_google_plus'),
                    // https://developers.google.com/+/web/share/
                    'share' => sprintf('https://plus.google.com/share?url=%s', $url),
                    'text' => 'Google Plus',
                    'icon' => 'fab fa-google-plus-g',
                ],
                'youtube' => [
                    'url' => get_theme_mod('jp_social_youtube'),
                    'text' => 'YouTube',
                    'icon' => 'fab fa-youtube',
                ],
                'pinterest' => [
                    'url' => get_theme_mod('jp_social_pinterest'),
                    // https://developers.pinterest.com/tools/widget-builder
                    'share' => sprintf(
                        'https://www.pinterest.com/pin/create/button/?url=%s&description=%s&media=%s',
                        $url, $desc, $thumbnail
                    ),
                    'text' => 'Pinterest',
                    'icon' => 'fab fa-pinterest-p',
                ],
                'tumblr' => [
                    'url' => get_theme_mod('jp_social_tumblr'),
                    // https://www.tumblr.com/docs/ru/share_button
                    'share' => sprintf(
                        'https://www.tumblr.com/widgets/share/tool?canonicalUrl=%s&title=%s',
                        $url, $title
                    ),
                    'text' => 'Tumblr',
                    'icon' => 'fab fa-tumblr',
                ],
                'flickr' => [
                    'url' => get_theme_mod('jp_social_flickr'),
                    'text' => 'Flickr',
                    'icon' => 'fab fa-flickr',
                ],
                'reddit' => [
                    'url' => get_theme_mod('jp_social_reddit'),
                    // https://www.reddit.com/wiki/submitting
                    'share' => sprintf('https://www.reddit.com/submit?url=%s&title=%s', $url, $title),
                    'text' => 'Reddit',
                    'icon' => 'fab fa-reddit-alien',
                ],
                'rss' => [
                    'url' => get_theme_mod('jp_social_rss'),
                    'text' => 'RSS',
                    'icon' => 'fas fa-rss',
                ],
                'foursquare' => [
                    'url' => get_theme_mod('jp_social_foursquare'),
                    'text' => 'Foursquare',
                    'icon' => 'fab fa-foursquare',
                ],
            ];

            $notShare = ['instagram', 'youtube', 'flickr', 'rss', 'foursquare'];

            if (count($args['only']) || count($args['exclude'])) {
                $args['only'] = array_map('strtolower', $args['only']);
                $args['exclude'] = array_map('strtolower', $args['exclude']);
            }

            if (count($args['only'])) {

                $only = $args['share'] ? array_diff($args['only'], $notShare) : $args['only'];

                $_socials = array_filter($_socials, function ($key) use ($only) {
                    return in_array($key, $only);
                }, ARRAY_FILTER_USE_KEY);

            } elseif ($args['share'] || count($args['exclude'])) {

                $exclude = $args['share'] ? array_merge($args['exclude'], $notShare) : $args['exclude'];

                $_socials = array_filter($_socials, function ($key) use ($exclude) {
                    return !in_array($key, $exclude);
                }, ARRAY_FILTER_USE_KEY);

            }

            if ($args['share']) {

                $socials = $_socials;

            } else {

                $socials = array_filter($_socials, function ($value) use ($args) {
                    $url = $value['url'];

                    return !empty($url) && filter_var($url, FILTER_VALIDATE_URL);
                });

            }

            return $socials;
        }

        /**
         * HTML Markup (Social Networks)
         *
         * @see getSocial()
         *
         * @param array $options
         *
         * @return string
         */
        public function getMarkup($options = [])
        {
            $items = '';

            foreach ($this->getSocial($options) as $name => $social) {

	            $icon = sprintf('<i class="%s" aria-hidden="true"></i>', esc_attr( $social['icon']));

	            $readerText = sprintf('<span class="screen-reader-text">%s</span>', esc_html($social['text']));

                $url = (isset($options['share']) && $options['share']) ? $social['share'] : $social['url'];

                $link = sprintf(
                    '<a class="social-link social-%s" href="%s" target="_blank" rel="nofollow noopener" aria-label="%s">%s %s</a>',
                    esc_attr($name),
                    esc_attr(esc_url($url)),
	                esc_attr($social['text']),
                    $icon,
	                $readerText
                );

                $item = sprintf('<li class="social-item">%s</li>', $link);

                $items .= $item . PHP_EOL;
            }

            $html = empty($items) ? $items : sprintf('<ul class="social">%s</ul>', $items);

            return $html;
        }

        /**
         * Add Shortcode Social Networks
         *
         * @param array $atts
         *
         * @return string
         */
        public function addShortcode($atts)
        {
            $atts = (array)$atts;

            $atts['only'] = !empty($atts['only']) ? explode(',', $atts['only']) : [];
            $atts['exclude'] = !empty($atts['exclude']) ? explode(',', $atts['exclude']) : [];

            // Attributes
            $atts = shortcode_atts(
                [
                    'share' => false,
                    'only' => [],
                    'exclude' => [],
                ],
                $atts
            );

            return $this->getMarkup($atts);
        }

        /**
         * Customize
         *
         * @param $customize WP_Customize_Manager
         *
         * @return void
         */
        public function customizeRegister($customize)
        {
            // Section Social
            $customize->add_section('jp_social', [
                'title' => 'Social',
                'description' => 'Customizer Custom Social links',
                'panel' => 'jp_theme_options',
            ]);

            $customize->add_setting('jp_social_vk', ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);
            $customize->add_setting('jp_social_twitter', ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);
            $customize->add_setting('jp_social_facebook', ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);
            $customize->add_setting('jp_social_linkedin', ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);
            $customize->add_setting('jp_social_instagram', ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);
            $customize->add_setting('jp_social_odnoklassniki',
                ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);
            $customize->add_setting('jp_social_google_plus',
                ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);
            $customize->add_setting('jp_social_youtube', ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);
            $customize->add_setting('jp_social_pinterest', ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);
            $customize->add_setting('jp_social_tumblr', ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);
            $customize->add_setting('jp_social_flickr', ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);
            $customize->add_setting('jp_social_reddit', ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);
            $customize->add_setting('jp_social_rss', ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);
            $customize->add_setting('jp_social_foursquare',
                ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);

            $customize->selective_refresh->add_partial('jp_social_vk', [
                'selector' => '.social',
            ]);

            $customize->add_control('jp_social_vk', [
                'label' => 'Vk',
                'section' => 'jp_social',
                'settings' => 'jp_social_vk',
                'type' => 'url',
                'input_attrs' => [
                    'placeholder' => 'https://vk.com',
                ],
            ]);

            $customize->add_control('jp_social_twitter', [
                'label' => 'Twitter',
                'section' => 'jp_social',
                'settings' => 'jp_social_twitter',
                'type' => 'url',
                'input_attrs' => [
                    'placeholder' => 'https://twitter.com',
                ],
            ]);

            $customize->add_control('jp_social_facebook', [
                'label' => 'Facebook',
                'section' => 'jp_social',
                'settings' => 'jp_social_facebook',
                'type' => 'url',
                'input_attrs' => [
                    'placeholder' => 'https://www.facebook.com',
                ],
            ]);

            $customize->add_control('jp_social_linkedin', [
                'label' => 'Linkedin',
                'section' => 'jp_social',
                'settings' => 'jp_social_linkedin',
                'type' => 'url',
                'input_attrs' => [
                    'placeholder' => 'https://www.linkedin.com',
                ],
            ]);

            $customize->add_control('jp_social_instagram', [
                'label' => 'Instagram',
                'section' => 'jp_social',
                'settings' => 'jp_social_instagram',
                'type' => 'url',
                'input_attrs' => [
                    'placeholder' => 'https://www.instagram.com',
                ],
            ]);

            $customize->add_control('jp_social_odnoklassniki', [
                'label' => 'Odnoklassniki',
                'section' => 'jp_social',
                'settings' => 'jp_social_odnoklassniki',
                'type' => 'url',
                'input_attrs' => [
                    'placeholder' => 'https://ok.ru',
                ],
            ]);

            $customize->add_control('jp_social_google_plus', [
                'label' => 'Google Plus',
                'section' => 'jp_social',
                'settings' => 'jp_social_google_plus',
                'type' => 'url',
                'input_attrs' => [
                    'placeholder' => 'https://plus.google.com',
                ],
            ]);

            $customize->add_control('jp_social_youtube', [
                'label' => 'YouTube',
                'section' => 'jp_social',
                'settings' => 'jp_social_youtube',
                'type' => 'url',
                'input_attrs' => [
                    'placeholder' => 'https://www.youtube.com',
                ],
            ]);

            $customize->add_control('jp_social_pinterest', [
                'label' => 'Pinterest',
                'section' => 'jp_social',
                'settings' => 'jp_social_pinterest',
                'type' => 'url',
                'input_attrs' => [
                    'placeholder' => 'https://www.pinterest.com',
                ],
            ]);

            $customize->add_control('jp_social_tumblr', [
                'label' => 'Tumblr',
                'section' => 'jp_social',
                'settings' => 'jp_social_tumblr',
                'type' => 'url',
                'input_attrs' => [
                    'placeholder' => 'https://www.tumblr.com',
                ],
            ]);

            $customize->add_control('jp_social_flickr', [
                'label' => 'Flickr',
                'section' => 'jp_social',
                'settings' => 'jp_social_flickr',
                'type' => 'url',
                'input_attrs' => [
                    'placeholder' => 'https://www.flickr.com',
                ],
            ]);

            $customize->add_control('jp_social_reddit', [
                'label' => 'Reddit',
                'section' => 'jp_social',
                'settings' => 'jp_social_reddit',
                'type' => 'url',
                'input_attrs' => [
                    'placeholder' => 'https://www.reddit.com',
                ],
            ]);

            $customize->add_control('jp_social_rss', [
                'label' => 'RSS',
                'section' => 'jp_social',
                'settings' => 'jp_social_rss',
                'type' => 'url',
                'input_attrs' => [
                    'placeholder' => 'https://sitename.com/rss',
                ],
            ]);

            $customize->add_control('jp_social_foursquare', [
                'label' => 'Foursquare',
                'section' => 'jp_social',
                'settings' => 'jp_social_foursquare',
                'type' => 'url',
                'input_attrs' => [
                    'placeholder' => 'https://foursquare.com',
                ],
            ]);
        }
    }

    new Social();
}
