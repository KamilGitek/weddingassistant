<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../admin/AdminController.php';

$admin = new AdminController();

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET['action'])) {
        switch($_GET['action']) {
            case 'dashboard_stats':
                $stats = $admin->getDashboardStats();
                echo json_encode(['success' => true, 'data' => $stats]);
                break;
                
            case 'pending_requests':
                $requests = $admin->getPendingRequests();
                echo json_encode(['success' => true, 'data' => $requests]);
                break;
                
            case 'default_checklists':
                $checklists = $admin->getDefaultChecklists();
                echo json_encode(['success' => true, 'data' => $checklists]);
                break;
                
            default:
                echo json_encode(['success' => false, 'error' => 'Invalid action']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'No action specified']);
    }
} elseif($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if(isset($data['action'])) {
        switch($data['action']) {
            case 'update_request_status':
                if(isset($data['request_id']) && isset($data['status'])) {
                    $result = $admin->updateRequestStatus($data['request_id'], $data['status'], $data['admin_notes'] ?? '');
                    echo json_encode(['success' => $result]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
                }
                break;
                
            case 'update_checklist':
                if(isset($data['checklist_id']) && isset($data['name']) && isset($data['category'])) {
                    $result = $admin->updateDefaultChecklist(
                        $data['checklist_id'], 
                        $data['name'], 
                        $data['category'], 
                        $data['description'] ?? '', 
                        $data['is_active'] ?? 1
                    );
                    echo json_encode(['success' => $result]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
                }
                break;
                
            default:
                echo json_encode(['success' => false, 'error' => 'Invalid action']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'No action specified']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
}
?>

