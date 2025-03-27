<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

$method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];

$base_path = "end_api/pubblic/index.php/";
$route = str_replace($base_path, "", $request_uri);

header('Content-Type: application/json');

if ($method == 'GET' && $route == "api/hello") { 
    echo json_encode(['message' => 'Hello, this is my PHP endpoint']);
}
?>
