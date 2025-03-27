<?php 

require_once('app/model/UserModel.php');

class UserController {
    public function getUsers() {
        $users = new User(); 
        $result = $users->getAllUsers(); 

        header("Content-Type: application/json");

        
        echo json_encode(["success" => true, "users" => $result]);
    }
}
?>
