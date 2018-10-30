<?php

if (!class_exists('ChangeSiteURL')) {
    /**
     * Class ChangeSiteURL
     *
     * @author Kudinov Fedor <admin@joompress.biz>
     */
    class ChangeSiteURL
    {
        /**
         * @var wpdb
         */
        public $wpdb;

        /**
         * @var string
         */
        public $prefix;

        /**
         * @var array
         */
        public $tables = [];

        /**
         * @var array
         */
        public $tables_columns = [];

        /**
         * @var string
         */
        public $site_url = 'http://sites.local';

        public function __construct()
        {
            global $wpdb;
            $this->wpdb = $wpdb;
            $this->prefix = $this->wpdb->prefix;
            $this->tables = $this->wpdb->tables;

            $this->getTablesColumns();

            $this->getSearchResults();
        }

        public function getTablesColumns()
        {
            foreach ($this->tables as $item) {
                $table = $this->prefix . $item;

                $columns = $this->wpdb->get_col("SHOW COLUMNS FROM `$table`");

                $this->tables_columns[$item] = $columns;
            }
        }

        public function getWhereOrLike($table)
        {
            $arr = [];
            $query = '';

            if (!empty($this->tables_columns[$table])) {
                foreach ($this->tables_columns[$table] as $column) {
                    $arr[] = "`$column` LIKE '%$this->site_url%'";
                }

                $query = 'WHERE ' . implode(' OR ', $arr);
            }

            return $query;
        }

        public function getSearchResults()
        {
            foreach ($this->tables as $item) {
                $table = $this->prefix . $item;
                $condition = $this->getWhereOrLike($item);

                $results = $this->wpdb->query("SELECT * FROM `$table` $condition");

                echo sprintf('<p>%d matches in the table <b>%s</b></p>', $results, $table);
            }
        }

        /**
         * Init Change Site URL
         *
         * @example ChangeSiteURL::init('https://joompress.biz', 'https://brainworks.com.ua');
         *
         * @param string $old_url - Old URL address
         * @param string $new_url - New URL address
         *
         * @return void
         */
        public static function init($old_url, $new_url)
        {
            if (filter_var($old_url, FILTER_VALIDATE_URL) && filter_var($new_url, FILTER_VALIDATE_URL)) {
                global $wpdb;

                // Options
                $options = $wpdb->query("UPDATE `$wpdb->options` SET `option_value` = REPLACE(`option_value`, '$old_url', '$new_url') WHERE `option_name` = 'home' OR `option_name` = 'siteurl'");

                // Posts
                $posts = $wpdb->query("UPDATE `$wpdb->posts` SET `guid` = REPLACE(`guid`, '$old_url', '$new_url')");
                $wpdb->query("UPDATE `$wpdb->posts` SET `post_content` = REPLACE(`post_content`, '$old_url', '$new_url')");

                // Post Meta
                $postmeta = $wpdb->query("UPDATE `$wpdb->postmeta` SET `meta_value` = REPLACE(`meta_value`, '$old_url', '$new_url')");

                if (0 === $options && 0 === $posts && 0 === $postmeta) {

                    echo sprintf('<p>No match for replacement in the tables (<i>options, posts, postmeta</i>) <b>not found</b>.</p>');

                } else {

                    echo sprintf('<p>Affected rows: options - <b>%d</b>, posts - <b>%d</b>, postmeta = <b>%d</b>.</p>',
                        $options, $posts, $postmeta
                    );

                }

            } else {

                echo '<p style="color: #f00;"><b>Invalid one of the URL addresses.</b></p>';

            }

        }
    }
}

if (!function_exists('change_site_url')) {
    /**
     * Change Site URL
     *
     * @example change_site_url('https://joompress.biz', 'https://brainworks.com.ua');
     *
     * @param string $old_url - Old URL address
     * @param string $new_url - New URL address
     *
     * @return void
     */
    function change_site_url($old_url, $new_url)
    {
        if (class_exists('ChangeSiteURL')) {
            ChangeSiteURL::init($old_url, $new_url);
        }
    }
}
