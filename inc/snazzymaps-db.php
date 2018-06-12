<?php

global $wpdb;
$charset_collate = $wpdb->get_charset_collate();
$table_name      = $wpdb->prefix . 'snazzymaps';

$sql = "CREATE TABLE $table_name (
  id INT NOT NULL,
  name VARCHAR(255),
  imageUrl VARCHAR(255),
  json JSON
) $charset_collate;";

dbDelta($sql);

$url = 'https://snazzymaps.com/explore.json?key=ecaccc3c-44fa-486c-9503-5d473587a493&pageSize=10&page=1';

$json = file_get_contents($url);

dd(json_decode($json)->styles);

