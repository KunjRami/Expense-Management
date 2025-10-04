<?php
$opts = [
    'http' => [
        'method' => 'GET',
        'timeout' => 10,
        'ignore_errors' => true,
    ]
];
$context = stream_context_create($opts);
$url = 'http://127.0.0.1:8000/login';
$response = @file_get_contents($url, false, $context);
if ($response === false) {
    echo "Request failed\n";
    var_dump($http_response_header ?? null);
    exit(1);
}
echo substr($response, 0, 2000);
