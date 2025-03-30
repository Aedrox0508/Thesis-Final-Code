<?php

require "database.class.php";

class User{
    public $username, $password;
    protected $db;


    public function __construct(){
        $this->db = new Database;
    }

    public function signinUser($username, $userpassword) {
        $sql = "SELECT * FROM users WHERE username = :username";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':username', $username);
        $query->execute();
        
        $accountData = $query->fetch(PDO::FETCH_ASSOC);
        if ($accountData) {
            if (password_verify($userpassword, $accountData['password'])) {
                return $accountData; 
            }
        }
        return false;
    }

    public function signupUser()
    {
        $db = $this->db->connect();
        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $hashedPassword);
    
        if (!$stmt->execute()) {
            error_log("Failed to insert user");
            return false;
        }
    
        $user_id = $db->lastInsertId();
    
        $gestures = [
            ["Communication 1", "Thumb", "1.png"],
            ["Communication 2", "Thumb Index", "2.png"],
            ["Communication 3", "Thumb Middle", "3.png"],
            ["Communication 4", "Thumb Ring", "4.png"],
            ["Communication 5", "Thumb Pinky", "5.png"],
            ["Communication 6", "Index", "6.png"],
            ["Communication 7", "Index Middle", "7.png"],
            ["Communication 8", "Index Ring", "8.png"],
            ["Communication 9", "Index Pinky", "9.png"],
            ["Communication 10", "Middle", "10.png"],
            ["Communication 11", "Middle Ring", "11.png"],
            ["Communication 12", "Middle Pinky", "12.png"],
            ["Communication 13", "Ring", "13.png"],
            ["Communication 14", "Ring Pinky", "14.png"],
            ["Communication 15", "Pinky", "15.png"],
            ["Communication 16", "Index & Middle & Ring & Pinky", "16.png"],
            ["Communication 17", "Index & Middle & Ring", "17.png"],
            ["Communication 18", "Thumb & Middle & Ring", "18.png"],
            ["Communication 19", "Middle & Ring & Pinky", "19.png"],
            ["Communication 20", "Thumb, Index, Middle, Ring, Pinky", "20.png"],
        ];
        

        try {
            $db->beginTransaction(); // Start transaction for efficiency
            $stmt2 = $db->prepare("INSERT INTO gestures (user_id, gesture_name, gesture_value, gesture_image) 
                                   VALUES (:user_id, :gesture_name, :gesture_value, :gesture_image)");
            $stmt2->bindParam(":user_id", $user_id);
            foreach ($gestures as $gesture) {
                $stmt2->bindParam(":gesture_name", $gesture[0]);
                $stmt2->bindParam(":gesture_value", $gesture[1]);
                $stmt2->bindParam(":gesture_image", $gesture[2]);
                $stmt2->execute();
            }
            
            $db->commit();
            return true;
        } catch (Exception $e) {
            $db->rollBack(); 
            error_log("Failed to insert gestures: " . $e->getMessage());
            return false;
        }
    }
    

}


?>