<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../auth/AuthController.php';

$auth = new AuthController();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if(isset($data['action'])) {
        switch($data['action']) {
            case 'register':
                if(isset($data['email']) && isset($data['password']) && isset($data['firstName']) && isset($data['lastName'])) {
                    $result = $auth->register($data['email'], $data['password'], $data['firstName'], $data['lastName']);
                    echo json_encode(['success' => $result]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
                }
                break;
                
            case 'login':
                if(isset($data['email']) && isset($data['password'])) {
                    $user = $auth->login($data['email'], $data['password']);
                    if($user) {
                        $token = $auth->createSession($user['id']);
                        if($token) {
                            echo json_encode([
                                'success' => true, 
                                'user' => $user, 
                                'token' => $token
                            ]);
                        } else {
                            echo json_encode(['success' => false, 'error' => 'Session creation failed']);
                        }
                    } else {
                        echo json_encode(['success' => false, 'error' => 'Invalid credentials']);
                    }
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
