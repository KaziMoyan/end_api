<?php 

require_once('app/model/UserModel.php');

class UserController {
    public function getUsers() {
        $users = new UserModel(); 
        $result = $users->getAllUsers(); 

        header("Content-Type: application/json");
        echo json_encode(["success" => true, "users" => $result]);
    }

    public function createNewUser() {
        $input = json_decode(file_get_contents('php://input'), true);

        if (json_last_error() !== JSON_ERROR_NONE || !isset($input['name']) || !isset($input['phone'])) {
            http_response_code(400); 
            echo json_encode(["success" => false, "message" => "Invalid input or JSON data"]);
            return;
        }

        $user = new UserModel();
        $result = $user->createNewUser($input['name'], $input['phone']);

        if ($result) {
            http_response_code(201); 
            echo json_encode(["success" => true, "message" => "User created successfully"]);
        } else {
            http_response_code(500); 
            echo json_encode(["success" => false, "message" => "Error creating user"]);
        }
    }

    public function updateUser($id, $name = null, $phone = null) {
        if (!$name || !$phone) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "Invalid input"]);
            return;
        }
    
        $user = new UserModel();
        $result = $user->updateUser($id, $name, $phone);
    
        if ($result) {
            http_response_code(200);
            echo json_encode(["success" => true, "message" => "User updated"]);
        } else {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Update failed"]);
        }
    }
    

    public function deleteUser($id) { 
        if (empty($id) || !is_numeric($id)) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "Invalid or missing User ID"]);
            return;
        }

        $user = new UserModel();
        $result = $user->deleteUser($id); 

        if ($result) {
            http_response_code(200); 
            echo json_encode(["success" => true, "message" => "User deleted successfully"]);
        } else {
            http_response_code(500); 
            echo json_encode(["success" => false, "message" => "Error deleting user"]);
        }
    }
}
?>
