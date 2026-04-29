<?php
// ============================================
// api/check_auth.php
// Returns authentication state for frontend
// ============================================
require_once __DIR__ . '/connection.php';

if (isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => true, 
        'authenticated' => true, 
        'username' => $_SESSION['username']
    ]);
} else {
    echo json_encode([
        'success' => true, 
        'authenticated' => false
    ]);
}
