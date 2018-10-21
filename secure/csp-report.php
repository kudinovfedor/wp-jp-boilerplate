<?php

//http_response_code(204);

$log_file = dirname(__FILE__) . '/csp.log';
$log_file_size_limit = pow(1024, 2); // 1MB

$data = file_get_contents('php://input');

var_dump(json_encode(json_decode($data), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

if ($data = json_decode($data)) {

    // Prettify the JSON-formatted data.
    $data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL;

    if (file_exists($log_file) && filesize($log_file) > $log_file_size_limit) {
        unlink($log_file);
    }

    file_put_contents($log_file, $data, FILE_APPEND | LOCK_EX);
}
