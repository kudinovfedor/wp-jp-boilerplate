<?php

$pagination = array(
    'currentPage' => 1,
    'pageSize'    => 10,
    'totalPages'  => 1769,
    'totalItems'  => 17686,
);

if ( ! function_exists('has_db_table')) {
    /**
     * Checks if the table exists in the DB
     *
     * @param string $table_name
     *
     * @return bool
     */
    function has_db_table($table_name)
    {
        global $wpdb;

        return $table_name === $wpdb->get_var("SHOW TABLES LIKE '$table_name'");
    }
}

if ( ! function_exists('empty_db_table')) {
    /**
     * Check if the table is empty
     *
     * @param string $table_name
     *
     * @return bool
     */
    function empty_db_table($table_name)
    {
        global $wpdb;

        return false === (bool)$wpdb->get_var("SELECT COUNT(*) FROM `$table_name`");
    }
}

if ( ! function_exists('drop_table_snazzymaps')) {
    /**
     * Drop Table snazzymaps from DB
     *
     * @return void
     */
    function drop_table_snazzymaps()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'snazzymaps';

        if (has_db_table($table_name)) {

            $sql = "DROP TABLE IF EXISTS `$table_name`";

            $wpdb->query($sql);

        }
    }
}

if ( ! function_exists('create_table_snazzymaps')) {
    /**
     * Create DB Table snazzymaps
     *
     * @return void
     */
    function create_table_snazzymaps()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'snazzymaps';

        if ( ! has_db_table($table_name)) {

            $charset_collate = $wpdb->get_charset_collate();

            $sql = "CREATE TABLE $table_name (
              id INT UNSIGNED NOT NULL AUTO_INCREMENT,
              name VARCHAR(255) NOT NULL,
              imageUrl VARCHAR(255) NOT NULL,
              json TEXT NOT NULL,
              PRIMARY KEY (id)
            ) $charset_collate;";

            $wpdb->query($sql);

        }

    }
}

if ( ! function_exists('fill_table_snazzymaps')) {
    /**
     * Fills the table with values
     *
     * @return void
     */
    function fill_table_snazzymaps()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'snazzymaps';

        if (has_db_table($table_name) && empty_db_table($table_name)) {

            $query_data = array(
                'key'      => 'ecaccc3c-44fa-486c-9503-5d473587a493',
                'pageSize' => 100,
                'page'     => 1,
                'sort'     => 'popular',
            );

            $query = http_build_query($query_data);

            $url = sprintf('https://snazzymaps.com/explore.json?%s', $query);

            if (extension_loaded('curl')) {

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $json = curl_exec($ch);

                $error['errno']    = curl_errno($ch);
                $error['error']    = curl_error($ch);
                $error['strerror'] = curl_strerror($error['errno']);

                curl_close($ch);

            } else {

                $json = file_get_contents($url);

            }

            $obj = json_decode($json)->styles;

            $maps = array();

            foreach ($obj as $key => $item) {
                $maps[$key] = [
                    'name'     => $item->name,
                    'imageUrl' => $item->imageUrl,
                    'json'     => $item->json,
                ];

                $wpdb->insert($table_name, $maps[$key], array('%s', '%s', '%s',));
            }

        }
    }
}

if ( ! function_exists('get_snazzymaps')) {
    /**
     * Get Snazzy Maps Items
     *
     * @return array|null|object
     */
    function get_snazzymaps()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'snazzymaps';

        $results = $wpdb->get_results("SELECT `id`, `name`, `imageUrl`, `json` FROM $table_name", ARRAY_A);

        return $results;
    }
}


if ( ! function_exists('get_snazzymap_json')) {
    /**
     * Get Snazzy Map Style By ID
     *
     * @param int $id
     *
     * @return array|null|object
     */
    function get_snazzymap_json($id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'snazzymaps';

        $result = $wpdb->get_results("SELECT `json` FROM `$table_name` WHERE `id`=$id", ARRAY_A);

        return $result[0]['json'];
    }
}

if ( ! function_exists('get_snazzymaps_styles')) {
    /**
     * Get Snazzy Maps Styles
     *
     * @return array|null|object
     */
    function get_snazzymaps_styles()
    {
        $styles = get_snazzymaps();

        $choices = array();

        foreach ($styles as $style) {
            $choices[$style['id']] = $style['name'];
        }

        return $choices;
    }
}

//drop_table_snazzymaps();

create_table_snazzymaps();

fill_table_snazzymaps();
