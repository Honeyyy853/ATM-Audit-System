<?php
// ============================================
// api/logout.php
// Destroys the PHP session
// ============================================
require_once __DIR__ . '/connection.php';

session_unset();
session_destroy();

echo json_encode(['success' => true, 'message' => 'Logged out successfully']);
