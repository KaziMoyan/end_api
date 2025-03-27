<?php
class User {
    private $conn; 

    public function __construct() {
        $host = "localhost";
        $username = "root";
        $password = "";
        $db_name = "end_api";

       
        $this->conn = new mysqli($host, $username, $password, $db_name);

       
        if ($this->conn->connect_error) {
            die("Connection could not be established: " . $this->conn->connect_error);
        }
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM users"; 
        $result = $this->conn->query($sql);

        $users = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) { 
                $users[] = $row;
            }
        }

        return $users;
    }

    public function __destruct() { 
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>
