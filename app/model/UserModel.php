<?php 
require_once('config.php');

class UserModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM users"; 
        $result = $this->conn->query($sql);

        $users = [];

        if ($result && $result->num_rows > 0) { 
            while ($row = $result->fetch_assoc()) { 
                $users[] = $row;
            }
        }

        return $users;
    }

    public function createNewUser($name, $phone) {
        $sql = "INSERT INTO users(name, phone) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
    
        if (!$stmt) {
            error_log("Create User Error: " . $this->conn->error);
            return false; 
        }
    
        $stmt->bind_param("ss", $name, $phone);
        return $stmt->execute();
    }
    

    public function updateUser($id, $name, $phone) {
        $sql = "UPDATE users SET name = ?, phone = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            error_log("Update User Error: " . $this->conn->error);
            return false; 
        }

        $stmt->bind_param("ssi", $name, $phone, $id);
        return $stmt->execute();
    }

    public function deleteUser($id) { 
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            error_log("Delete User Error: " . $this->conn->error);
            return false; 
        }

        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
