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

            if (is_front_page() || is_archive()) {
                wp_enqueue_script('load-more-posts');
            }
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
                'order' => 'DESC', // ASC, DESC
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
