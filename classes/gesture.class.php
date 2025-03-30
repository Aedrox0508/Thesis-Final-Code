<?php

class Gesture{
    public $user_id, $gesture_id, $gesture_name, $gesture_value, $custom_value;
    protected $db;

    public function __construct(){
        $this->db = new Database();
    }

    /* Updating default values with custom ones */
    public function updateGestureValue(){
        $stmt = "UPDATE gestures SET gesture_value = :custom_value WHERE user_id = :user_id AND gesture_id = :gesture_id";
        $sql = $this->db->connect()->prepare($stmt);
        $sql->bindParam(":user_id", $this->user_id);
        $sql->bindParam(":gesture_id", $this->gesture_id);
        $sql->bindParam(":custom_value", $this->custom_value);
        $sql->execute();
    }
    
    /* Thumb Gestures */
    public function thumbGestures($user_id){
        $stmt = "SELECT * FROM gestures WHERE user_id = :user_id ORDER BY gesture_id LIMIT 5";
        $sql = $this->db->connect()->prepare($stmt);
        $sql->bindParam("user_id", $user_id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Index Gestures */
    public function indexGestures($user_id){
        $stmt = "SELECT * FROM gestures WHERE user_id = :user_id ORDER BY gesture_id LIMIT 4 OFFSET 5";
        $sql = $this->db->connect()->prepare($stmt);
        $sql->bindParam("user_id", $user_id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Middle Gestures */
    public function middleGestures($user_id){
        $stmt = "SELECT * FROM gestures WHERE user_id = :user_id ORDER BY gesture_id LIMIT 3 OFFSET 9";
        $sql = $this->db->connect()->prepare($stmt);
        $sql->bindParam("user_id", $user_id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Ring Gestures */
    public function ringGestures($user_id){
        $stmt = "SELECT * FROM gestures WHERE user_id = :user_id ORDER BY gesture_id LIMIT 2 OFFSET 12";
        $sql = $this->db->connect()->prepare($stmt);
        $sql->bindParam("user_id", $user_id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Pinky Gestures */
    public function pinkyGestures($user_id){
        $stmt = "SELECT * FROM gestures WHERE user_id = :user_id ORDER BY gesture_id LIMIT 1 OFFSET 14";
        $sql = $this->db->connect()->prepare($stmt);
        $sql->bindParam("user_id", $user_id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Special Gestures */
    public function specialGestures($user_id){
        $stmt = "SELECT * FROM gestures WHERE user_id = :user_id ORDER BY gesture_id LIMIT 5 OFFSET 15";
        $sql = $this->db->connect()->prepare($stmt);
        $sql->bindParam("user_id", $user_id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>