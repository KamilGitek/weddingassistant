<?php
require_once '../config/database.php';

class AdminController {
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    public function getDashboardStats() {
        try {
            $stats = [];
            
            // Liczba użytkowników
            $query = "SELECT COUNT(*) as total_users FROM users WHERE role = 'client'";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $stats['total_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_users'];
            
            // Aktywne pakiety
            $query = "SELECT COUNT(*) as active_packages FROM user_packages WHERE status = 'active'";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $stats['active_packages'] = $stmt->fetch(PDO::FETCH_ASSOC)['active_packages'];
            
            // Oczekujące wnioski
            $query = "SELECT COUNT(*) as pending_requests FROM requests WHERE status = 'pending'";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $stats['pending_requests'] = $stmt->fetch(PDO::FETCH_ASSOC)['pending_requests'];
            
            // Ostatnie aktywności
            $query = "SELECT al.*, u.email, up.first_name, up.last_name 
                      FROM activity_logs al 
                      JOIN users u ON al.user_id = u.id 
                      LEFT JOIN user_profiles up ON u.id = up.user_id 
                      ORDER BY al.created_at DESC LIMIT 10";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $stats['recent_activities'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $stats;
        } catch(PDOException $e) {
            return false;
        }
    }
    
    public function getPendingRequests() {
        try {
            $query = "SELECT r.*, u.email, up.first_name, up.last_name 
                      FROM requests r 
                      JOIN users u ON r.user_id = u.id 
                      LEFT JOIN user_profiles up ON u.id = up.user_id 
                      WHERE r.status = 'pending' 
                      ORDER BY r.created_at DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return false;
        }
    }
    
    public function updateRequestStatus($requestId, $status, $adminNotes = '') {
        try {
            $query = "UPDATE requests SET status = :status, admin_notes = :admin_notes, updated_at = NOW() WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':admin_notes', $adminNotes);
            $stmt->bindParam(':id', $requestId);
            return $stmt->execute();
        } catch(PDOException $e) {
            return false;
        }
    }
    
    public function getDefaultChecklists() {
        try {
            $query = "SELECT * FROM default_checklists WHERE is_active = 1 ORDER BY category, name";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return false;
        }
    }
    
    public function updateDefaultChecklist($checklistId, $name, $category, $description, $isActive) {
        try {
            $query = "UPDATE default_checklists SET name = :name, category = :category, description = :description, is_active = :is_active, updated_at = NOW() WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':is_active', $isActive);
            $stmt->bindParam(':id', $checklistId);
            return $stmt->execute();
        } catch(PDOException $e) {
            return false;
        }
    }
}
?>

