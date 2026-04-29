<?php
// ============================================
// api/auth.php
// Authentication middleware and helpers
// ============================================
require_once __DIR__ . '/connection.php';

function require_auth() {
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Unauthorized: Please log in']);
        exit;
    }
}
