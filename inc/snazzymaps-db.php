<?php

global $wpdb;

$charset_collate = $wpdb->get_charset_collate();
$table_name = $wpdb->prefix . 'snazzymaps';

if ($table_name !== $wpdb->get_var("SHOW TABLES LIKE '$table_name'")) {
    $sql = "CREATE TABLE $table_name (
      id INT UNSIGNED NOT NULL AUTO_INCREMENT,
      name VARCHAR(255) NOT NULL,
      imageUrl VARCHAR(255) NOT NULL,
      json TEXT NOT NULL,
      PRIMARY KEY (id)
    ) $charset_collate;";

    $wpdb->query($sql);

    $pagination = array(
        'currentPage' => 1,
        'pageSize' => 10,
        'totalPages' => 1769,
        'totalItems' => 17686,
    );

    $query_data = array(
        'key' => 'ecaccc3c-44fa-486c-9503-5d473587a493',
        'pageSize' => 100,
        'page' => 1,
        'sort' => 'popular',
    );

    $query = http_build_query($query_data);

    $url = sprintf('https://snazzymaps.com/explore.json?%s', $query);

    if (extension_loaded('curl')) {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $json = curl_exec($ch);

        curl_close($ch);

    } else {

        $json = file_get_contents($url);

    }

    $obj = json_decode($json)->styles;

    $maps = array();

    foreach ($obj as $key => $item) {
        $maps[$key] = [
            'name' => $item->name,
            'imageUrl' => $item->imageUrl,
            'json' => $item->json,
        ];

        $wpdb->insert($table_name, $maps[$key], array('%s', '%s', '%s',));
    }
}
