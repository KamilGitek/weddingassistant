<?php
require_once '../config/database.php';

class AuthController {
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    public function register($email, $password, $firstName, $lastName) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $query = "INSERT INTO users (email, password, role) VALUES (:email, :password, 'client')";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            
            if($stmt->execute()) {
                $userId = $this->db->lastInsertId();
                
                $query = "INSERT INTO user_profiles (user_id, first_name, last_name) VALUES (:user_id, :first_name, :last_name)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':user_id', $userId);
                $stmt->bindParam(':first_name', $firstName);
                $stmt->bindParam(':last_name', $lastName);
                
                return $stmt->execute();
            }
            return false;
        } catch(PDOException $e) {
            return false;
        }
    }
    
    public function login($email, $password) {
        try {
            $query = "SELECT u.id, u.email, u.password, u.role, up.first_name, up.last_name 
                      FROM users u 
                      LEFT JOIN user_profiles up ON u.id = up.user_id 
                      WHERE u.email = :email AND u.status = 'active'";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            if($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if(password_verify($password, $user['password'])) {
                    return $user;
                }
            }
            return false;
        } catch(PDOException $e) {
            return false;
        }
    }
    
    public function createSession($userId) {
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+24 hours'));
        
        $query = "INSERT INTO user_sessions (user_id, token, expires_at) VALUES (:user_id, :token, :expires_at)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expires_at', $expiresAt);
        
        if($stmt->execute()) {
            return $token;
        }
        return false;
    }
    
    public function validateSession($token) {
        $query = "SELECT us.user_id, u.role, u.status 
                  FROM user_sessions us 
                  JOIN users u ON us.user_id = u.id 
                  WHERE us.token = :token AND us.expires_at > NOW() AND u.status = 'active'";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }
}
?>

