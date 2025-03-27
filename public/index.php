<?php 

ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once('app/controller/UserController.php'); 

$method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];

$script_name = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$base_path = rtrim($script_name, '/') . "/index.php/";

$route = str_replace($base_path, "", $request_uri);
$route = trim($route, "/");

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($method === "OPTIONS") {
    http_response_code(200);
    exit();
}

$users = new UserController();

switch ($method) {
    case 'GET':
        if ($route === "api/hello") {
            echo json_encode(['message' => 'Hello, this is my PHP endpoint']);
        } elseif ($route === "api/get-all-users") {
            $users->getUsers();
        } else {
            http_response_code(404);
            echo json_encode(["success" => false, "message" => "Invalid route"]);
        }
        break;

    case 'POST':
        if ($route === "api/create-new-user") {
            $users->createNewUser();
        } else {
            http_response_code(404);
            echo json_encode(["success" => false, "message" => "Invalid route"]);
        }
        break;

    case 'PUT':
        if (preg_match("/^api\/update-user\/(\d+)$/", $route, $matches)) {
            $userID = $matches[1];
            $users->updateUser($userID);
        } else {
            http_response_code(404);
            echo json_encode(["success" => false, "message" => "Invalid route"]);
        }
        break;

    case 'DELETE':
        if (preg_match("/^api\/delete-user\/(\d+)$/", $route, $matches)) {
            $userID = $matches[1];
            $users->deleteUser($userID);
        } else {
            http_response_code(404);
            echo json_encode(["success" => false, "message" => "Invalid route"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["success" => false, "message" => "Method not allowed"]);
        break;
}
?>
