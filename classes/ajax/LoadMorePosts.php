<?php

if (!class_exists('LoadMorePosts')) {
    /**
     * Class LoadMorePosts
     */
    class LoadMorePosts
    {
        /**
         * LoadMorePosts constructor.
         */
        public function __construct()
        {
            add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
            add_action('customize_register', [$this, 'customizeRegister']);

            if (wp_doing_ajax()) {
                add_action('wp_ajax_load_more_posts', [$this, 'ajaxCallback']);
                add_action('wp_ajax_nopriv_load_more_posts', [$this, 'ajaxCallback']);
            }
        }

        /**
         * Enqueue a script
         */
        public function enqueueScripts()
        {
            $src = get_template_directory_uri() . '/assets/js/load-more-posts.js';

            wp_register_script('load-more-posts', $src, [], null, true);

            wp_localize_script('load-more-posts', 'jpAjax', [
                'action' => 'load_more_posts',
                'nonce' => wp_create_nonce('load_more_posts_action'),
                'url' => admin_url('admin-ajax.php'),
            ]);

            $condition = is_front_page() || is_home() || is_archive();

            if (get_theme_mod('jp_load_more_enable') && $condition) {
                wp_enqueue_script('load-more-posts');
            }
        }

        /**
         * Customize
         *
         * @param $customize WP_Customize_Manager
         * @return void
         */
        public function customizeRegister($customize)
        {
            // Section Load More
            $customize->add_section('jp_load_more', [
                'title' => 'Load More',
                'description' => 'If this function enabled, the pagination will ignore.',
                'panel' => 'jp_theme_options',
            ]);

            $customize->add_setting('jp_load_more_enable', [
                'default' => 0,
                'sanitize_callback' => 'wp_validate_boolean',
            ]);

            $customize->add_setting('jp_load_more_label', [
                'default' => 'Load more posts...',
                'sanitize_callback' => '',
            ]);

            $customize->add_control('jp_load_more_enable', [
                'label' => 'Enable/Disable',
                'section' => 'jp_load_more',
                'settings' => 'jp_load_more_enable',
                'type' => 'checkbox',
            ]);

            $customize->add_control('jp_load_more_label', [
                'label' => 'Button Label',
                'section' => 'jp_load_more',
                'settings' => 'jp_load_more_label',
                'type' => 'text',
            ]);
        }

        /**
         * Fires Ajax actions for users.
         */
        public function ajaxCallback()
        {
            check_ajax_referer('load_more_posts_action', 'nonce');

            $paged = empty($_POST['paged']) ? 1 : $_POST['paged'] + 1;

            $args = [
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => get_option('posts_per_page'),
                'order' => 'ASC', // ASC, DESC
                'orderby' => 'date',
                'paged' => $paged,
            ];

            $query = new WP_Query($args);

            $data = [
                'posts' => [],
                'posts_count' => $query->post_count,
                'posts_per_page' => intval($args['posts_per_page']),
                'query_vars' => $args,
            ];

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();

                    $data['posts'][] = [
                        'id' => get_the_ID(),
                        'date' => get_the_date(),
                        'link' => get_permalink(),
                        'tags' => $this->getTags(),
                        'title' => get_the_title(),
                        'author' => $this->getAuthor(),
                        'excerpt' => get_the_excerpt(),
                        'content' => get_the_content(),
                        'datetime' => get_the_date('c'),
                        'comments' => $this->getCommentsInfo(),
                        'categories' => $this->getCategories(),
                        'attachment' => $this->getAttachmentImageSizes(),
                    ];
                }

                wp_reset_postdata();
            }

            wp_send_json_success($data, 200);

            /*if (empty($data)) {
                wp_send_json_error($data, 404);
            }*/
        }

        /**
         * Get Author
         *
         * @return array
         */
        public function getAuthor()
        {
            $author_id = get_the_author_meta('ID');

            $author = [
                'name' => get_the_author(),
                'link' => esc_url(get_author_posts_url($author_id)),
            ];

            return $author;
        }

        /**
         * Get Tags
         *
         * @return array
         */
        public function getTags()
        {
            $tags = [];

            $terms = get_the_terms(get_the_ID(), 'post_tag');

            foreach ($terms as $term) {
                $tags[] = [
                    'id' => $term->term_id,
                    'name' => $term->name,
                    'link' => get_term_link($term, 'post_tag'),
                ];
            }

            return $tags;
        }

        /**
         * Get Categories
         *
         * @return array
         */
        public function getCategories()
        {
            $categories = [];

            foreach (get_the_category() as $category) {
                $categories[] = [
                    'id' => $category->term_id,
                    'name' => $category->cat_name,
                    'link' => get_category_link($category),
                ];
            }

            return $categories;
        }

        /**
         * Get Attachment Image Sizes
         *
         * @return array
         */
        public function getAttachmentImageSizes()
        {
            $thumbnails = [];

            $image_sizes = get_intermediate_image_sizes();

            foreach ($image_sizes as $size) {

                $thumbnail_id = get_post_thumbnail_id();
                $image = wp_get_attachment_image_src($thumbnail_id, $size);
                $alt = trim(strip_tags(get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true)));

                if ($image) {
                    list($src, $width, $height) = $image;

                    $thumbnail = [
                        'src' => $src,
                        'alt' => $alt,
                        'width' => $width,
                        'height' => $height,
                    ];

                    $thumbnails[$size] = $thumbnail;
                }
            }

            $thumbnails['length'] = count($thumbnails);

            return $thumbnails;
        }

        /**
         * Get Comments Info
         *
         * @return array
         */
        public function getCommentsInfo()
        {
            $comments = [
                'status' => comments_open(),
                'count' => intval(get_comments_number()),
            ];

            return $comments;
        }
    }

    new LoadMorePosts();
}

if (!function_exists('jp_load_more')) {
    /**
     * @param bool $echo
     * @return string
     */
    function jp_load_more($echo = true)
    {
        /** @var WP_Query $wp_query */
        global $wp_query;

        $total = isset($wp_query->max_num_pages) ? intval($wp_query->max_num_pages) : 1;
        $current = get_query_var('paged') ? intval(get_query_var('paged')) : 1;

        /*$categories = get_the_category();
        $category = $categories[0];
        $current_category = get_queried_object();*/

        $attrs = [];

        $data = [
            'post-type' => get_post_type(),
            //'category-id' => $category->term_id,
            //'category-name' => $category->name,
            //'category-slug' => $category->slug,
        ];

        foreach ($data as $attr => $value) {
            $attrs[] = sprintf('data-%s="%s"', $attr, esc_attr($value));
        }

        $output = sprintf(
            '<button class="btn btn-primary js-load-more" %s type="button">%s</button>',
            join($attrs, ' '), __('Load more posts...', 'joompress')
        );

        if ($total < 2) {
            return;
        }

        if ($echo) {
            echo $output;
        }

        return $output;
    }
}
