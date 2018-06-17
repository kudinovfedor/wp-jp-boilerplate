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
         * SnazzyMaps constructor.
         */
        public function __construct()
        {
            global $wpdb;
            $this->wpdb = $wpdb;
            $this->table_name = $this->wpdb->prefix . 'snazzymaps';
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
            $this->table_exists = $this->table_name === $this->wpdb->get_var("SHOW TABLES LIKE '$this->table_name'");

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
                $this->table_empty = false === (bool)$this->wpdb->get_var("SELECT COUNT(*) FROM `$this->table_name`");
            }

            return $this->table_empty;
        }

        /**
         * Create Table snazzymaps in DB
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
         * Drop Table snazzymaps in DB
         *
         * @return void
         */
        public function dropTable()
        {
            if ($this->table_exists) {

                $sql = "DROP TABLE IF EXISTS `$this->table_name`";

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

                $query_data = array(
                    'key' => 'ecaccc3c-44fa-486c-9503-5d473587a493',
                    'pageSize' => 200,
                    'page' => 1,
                    'sort' => 'popular',
                );

                $query = http_build_query($query_data);

                $url = sprintf('https://snazzymaps.com/explore.json?%s', $query);

                if (extension_loaded('curl')) {

                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $json = curl_exec($ch);

                    $error['errno'] = curl_errno($ch);
                    $error['error'] = curl_error($ch);
                    $error['strerror'] = curl_strerror($error['errno']);

                    curl_close($ch);

                } else {

                    $json = file_get_contents($url);

                }

                $obj = json_decode($json)->styles;

                $maps = array();

                foreach ($obj as $key => $item) {
                    $maps[$key] = [
                        'style_id' => $item->id,
                        'name' => $item->name,
                        'image_url' => $item->imageUrl,
                        'json' => $item->json,
                        'views' => $item->views,
                    ];

                    $this->wpdb->insert($this->table_name, $maps[$key], array('%d', '%s', '%s', '%s', '%d'));
                }

                $this->table_empty = false;

            }
        }

        /**
         * Get Snazzy Maps Items
         *
         * @param int $limit
         * @return array|null|object
         */
        public function getItems($limit = 100)
        {
            $limit_value = (int)$limit;

            $results = array();

            if ($this->table_exists && !$this->table_empty) {

                $results = $this->wpdb->get_results(
                    "SELECT `style_id`, `name`, `image_url`, `json` FROM $this->table_name ORDER BY `name` LIMIT $limit_value",
                    ARRAY_A
                );

            }

            return $results;
        }

        /**
         * Get Snazzy Map Style item By ID
         *
         * @param int $id
         * @return string
         */
        public function getItemJson($id)
        {
            $id = (int)$id;

            $result = '';

            if ($this->table_exists && !$this->table_empty) {

                $result = $this->wpdb->get_row(
                    "SELECT `json` FROM `$this->table_name` WHERE `style_id`=$id LIMIT 1",
                    ARRAY_A
                );

                return $result['json'];

            }

            return $result;
        }

        /**
         * Get Snazzy Maps Styles
         *
         * @return array
         */
        public function getMapStyles()
        {
            $items = $this->getItems();

            $styles = array();

            foreach ($items as $item) {
                $styles[$item['style_id']] = $item['name'];
            }

            return $styles;
        }
    }
}

global $snazzy_maps;

/**
 * @var SnazzyMaps $snazzy_maps
 */
$snazzy_maps = new SnazzyMaps();
