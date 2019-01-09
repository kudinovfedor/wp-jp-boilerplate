<?php

if (!class_exists('OpenGraph')) {
    /**
     * Class OpenGraph
     *
     * @author Kudinov Fedor <admin@joompress.biz>
     */
    class OpenGraph
    {
        /**
         * OpenGraph constructor.
         */
        public function __construct()
        {
            add_action('wp_head', [$this, 'insertMetaTags']);
            add_filter('language_attributes', [$this, 'addNamespace']);
        }

        /**
         * Filters the language attributes for display in the html tag.
         *
         * @param string $output A space-separated list of language attributes.
         * @return string
         */
        public function addNamespace($output)
        {
            return $output;
        }

        /**
         * Prints scripts or data in the head tag on the front end.
         *
         * @return void
         */
        public function insertMetaTags()
        {
            $locale = esc_attr(get_locale());
            $siteName = esc_attr(get_bloginfo('name'));

            $output = '';

            /*dump(
                'is_singular',
                is_singular(),
                'is_category',
                is_category(),
                'is_tag',
                is_tag(),
                'is_tax',
                is_tax(),
                'is_search',
                is_search(),
                'is_author',
                is_author(),
                'is_archive',
                is_archive(),
                'is_day',
                is_day(),
                'is_month',
                is_month(),
                'is_year',
                is_year(),
                'is_front_page',
                is_front_page(),
                'is_home',
                is_home(),
                'is_page',
                is_page(),
                'is_single',
                is_single()
            );*/

            /*if (is_singular()) {
                $title = get_the_title();
            }

            if (is_category()) {

            }

            if (is_tag()) {

            }

            if (is_tax()) {

            }

            if (is_search()) {

            }

            if (is_author()) {

            }

            if (is_archive()) {

            }

            if (is_day()) {

            }

            if (is_month()) {

            }

            if (is_year()) {
            }

            if (is_front_page()) {

            }

            if (is_home()) {

            }

            if (is_404()) {

            }*/

            if (is_singular()) {
                global $post;

                $title = esc_attr(get_the_title());
                $permalink = esc_url(get_permalink());
                $description = esc_attr(has_excerpt() ? $post->post_excerpt : wp_trim_words($post->post_content, 35,
                    '...'));

                //$output .= '<!-- Facebook Open Graph -->';

                $output .= '<meta property="og:locale" content="' . $locale . '">';
                $output .= '<meta property="og:site_name" content="' . $siteName . '">';

                $output .= '<meta property="og:type" content="article">';
                $output .= '<meta property="og:title" content="' . $title . '">';
                $output .= '<meta property="og:url" content="' . $permalink . '">';
                $output .= '<meta property="og:description" content="' . $description . '">';

                if (has_post_thumbnail()) {
                    $attachmentId = get_post_thumbnail_id($post->ID);
                    $attachmentImage = wp_get_attachment_image_src($attachmentId, 'full');

                    $output .= '<meta property="og:image:url" content="' . esc_url($attachmentImage[0]) . '">';
                    $output .= '<meta property="og:image:width" content="' . intval($attachmentImage[1]) . '">';
                    $output .= '<meta property="og:image:height" content="' . intval($attachmentImage[2]) . '">';
                }

                $output .= '<meta property="article:published_time" content="' . get_the_date('c') . '">';
                $output .= '<meta property="article:modified_time" content="' . get_the_modified_date('c') . '">';

                if ($categories = get_the_category()) {
                    $sections = [];

                    /** @var WP_Term $category */
                    foreach ($categories as $category) {
                        $sections[] = $category->name;
                    }

                    $output .= '<meta property="article:section" content="' . esc_attr(join(', ', $sections)) . '">';
                }

                if ($postTags = get_the_terms($post->ID, 'post_tag')) {
                    $tags = [];

                    /** @var WP_Term $tag */
                    foreach ($postTags as $tag) {
                        $tags[] = $tag->name;
                    }

                    $output .= '<meta property="article:tag" content="' . esc_attr(join(', ', $tags)) . '">';
                }

                $output .= '<meta property="article:author" content="' . esc_attr(get_the_author_meta('display_name',
                        $post->post_author)) . '">';

                //$output .= '<!-- Twitter Cards -->';

                $output .= '<meta name="twitter:card" content="summary">';
                $output .= '<meta name="twitter:site" content="@' . strtolower($siteName) . '">';
                $output .= '<meta name="twitter:url" content="' . $permalink . '">';
                $output .= '<meta name="twitter:title" content="' . $title . '">';
                $output .= '<meta name="twitter:description" content="' . $description . '">';

                if (has_post_thumbnail()) {
                    $attachmentId = get_post_thumbnail_id($post->ID);
                    $attachmentImage = wp_get_attachment_image_src($attachmentId, 'full');

                    $output .= '<meta name="twitter:image" content="' . $attachmentImage[0] . '">';
                }

                if ($creator = get_the_author_meta('twitter', $post->post_author)) {
                    $output .= '<meta name="twitter:creator" content="@' . esc_attr($creator) . '">';
                }

            }

            echo $output;
        }
    }

    //new OpenGraph();
}
