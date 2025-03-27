<?php 

require_once('app/model/UserModel.php');

class UserController {
    public function getUsers() {
        $users = new User(); 
        $result = $users->getAllUsers(); 

        header("Content-Type: application/json");

        
        echo json_encode(["success" => true, "users" => $result]);
    }

    public function createNewUser() {
        $input = json_decode(file_get_contents('php://input'), true);

        if (isset($input['name']) && isset($input['phone'])) {
            $user = new User();
            $result = $user->createNewUser($input['name'], $input['phone']);

            if ($result) {
                http_response_code(201); //response code
                echo json_encode(["success" => true, "message" => "User created successfully"]);
            } else {
                http_response_code(500); //Server Error
                echo json_encode(["success" => false, "message" => "Error creating user"]);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(["success" => false, "message" => "Invalid input"]);
        }
    }
}
?>
