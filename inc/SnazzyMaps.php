<?php

if (!class_exists('SnazzyMaps')) {
    /**
     * Class SnazzyMaps
     */
    class SnazzyMaps
    {
        /**
         * @var wpdb
         */
        private $wpdb;

        /**
         * @var string
         */
        private $table = 'snazzymaps';

        /**
         * @var string
         */
        private $table_name;

        /**
         * @var string
         */
        private $charset_collate;

        /**
         * @var bool
         */
        private $table_exists = false;

        /**
         * @var bool
         */
        private $table_empty = true;

        /**
         * @var array
         */
        private $styles = array();

        /**
         * @var array
         */
        private $pagination = array();

        /**
         * SnazzyMaps constructor.
         */
        public function __construct()
        {
            global $wpdb;
            $this->wpdb = $wpdb;

            if (!in_array($this->table, $this->wpdb->tables)) {
                $this->wpdb->tables[] = $this->table;
            }

            $this->table_name = $this->wpdb->prefix . $this->table;
            $this->charset_collate = $this->wpdb->get_charset_collate();

            $this->isTableExist();
            $this->isTableEmpty();

            $this->createTable();
            $this->fillTable();
        }

        /**
         * Checks if the table exists in the DB
         *
         * @return bool
         */
        public function isTableExist()
        {
            $this->table_exists = $this->table_name === $this->wpdb->get_var("SHOW TABLES LIKE '$this->table_name';");

            return $this->table_exists;
        }

        /**
         * Check if the table is empty
         *
         * @return bool
         */
        public function isTableEmpty()
        {
            if ($this->table_exists) {
                $this->table_empty = false === (bool)$this->wpdb->get_var("SELECT COUNT(*) FROM `$this->table_name`;");
            }

            return $this->table_empty;
        }

        /**
         * Create Table in DB
         *
         * @return void
         */
        public function createTable()
        {
            if (!$this->table_exists) {

                $sql = "CREATE TABLE $this->table_name (
                  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
                  style_id INT NOT NULL,
                  name VARCHAR(255) NOT NULL,
                  image_url VARCHAR(255) NOT NULL,
                  json TEXT NOT NULL,
                  views INT NOT NULL,
                  PRIMARY KEY (id)
                ) $this->charset_collate;";

                $this->wpdb->query($sql);

                $this->table_exists = true;
            }
        }

        /**
         * Drop Table in DB
         *
         * @return void
         */
        public function dropTable()
        {
            if ($this->table_exists) {

                $sql = "DROP TABLE IF EXISTS `$this->table_name`;";

                $this->wpdb->query($sql);

                $this->table_exists = false;

            }
        }

        /**
         * Fills the table with values
         *
         * @return void
         */
        public function fillTable()
        {
            if ($this->table_exists && $this->table_empty) {

                $url = $this->getRemoteUrl();

                $response = $this->getResponse($url);

                if (null !== $response) {
                    $this->pagination = $response['pagination'];
                    $this->styles = $response['styles'];
                }

                $maps = array();

                foreach ($this->styles as $key => $item) {
                    $maps[$key] = [
                        'style_id' => (int)$item['id'],
                        'name' => htmlspecialchars($this->validate_field($item['name'])),
                        'image_url' => htmlspecialchars($this->validate_field($item['imageUrl'])),
                        'json' => $this->validate_field($item['json']),
                        'views' => (int)$item['views'],
                    ];

                    $this->wpdb->insert($this->table_name, $maps[$key], array('%d', '%s', '%s', '%s', '%d'));
                }

                $this->table_empty = false;

            }
        }

        /**
         * Get Remote Url Snazzy Maps
         * @param array $query_data
         * @return string
         */
        public function getRemoteUrl($query_data = array())
        {
            $query_defaults = array(
                'key' => 'ecaccc3c-44fa-486c-9503-5d473587a493',
                'pageSize' => 500,
                'page' => 1,
                'sort' => 'popular',
            );

            $query_data = array_merge($query_defaults, $query_data);

            $query = http_build_query($query_data);

            $url = sprintf('https://snazzymaps.com/explore.json?%s', $query);

            return $url;
        }

        /**
         * Get Response
         *
         * @param $url
         *
         * @return array|mixed|null|object|WP_Error
         */
        public function getResponse($url)
        {
            $response = wp_remote_get($url, array(
                'timeout' => 30,
                'sslverify' => true,
            ));

            if (is_object($response)) {
                return null;
            }

            if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
                $body = wp_remote_retrieve_body($response);
                $response = json_decode($body, true);
            }

            return $response;

        }

        /**
         * Validate fields
         *
         * @param $field
         * @return string
         */
        public function validate_field($field)
        {
            $field = trim($field);
            $field = stripslashes($field);
            $field = strip_tags($field);

            return $field;
        }

        /**
         * Get Snazzy Maps Items
         *
         * @param int $limit
         *
         * @return array|null|object
         */
        public function getItems($limit = 100)
        {
            $limit_value = (int)$limit;

            $results = array();

            if ($this->table_exists && !$this->table_empty) {

                $results = $this->wpdb->get_results(
                    "SELECT `style_id`, `name`, `image_url`, `json` FROM $this->table_name ORDER BY `views` DESC LIMIT $limit_value;",
                    ARRAY_A
                );

            }

            return $results;
        }

        /**
         * Get Snazzy Map Style item By ID
         *
         * @param int $id
         *
         * @return string
         */
        public function getItemJson($id)
        {
            $id = (int)$id;

            $result = '';

            if ($this->table_exists && !$this->table_empty) {

                $result = $this->wpdb->get_row(
                    "SELECT `json` FROM `$this->table_name` WHERE `style_id` = $id LIMIT 1;",
                    ARRAY_A
                );

                return $result['json'];

            }

            return $result;
        }

        /**
         * Get Snazzy Maps Styles
         *
         * @param int $limit
         *
         * @return array
         */
        public function getMapStyles($limit = 100)
        {
            $limit = (int)$limit;
            $items = $this->getItems($limit);

            $styles = array();

            foreach ($items as $item) {
                $styles[$item['style_id']] = ucfirst($item['name']);
            }

            asort($styles, SORT_STRING);

            return $styles;
        }
    }
}
