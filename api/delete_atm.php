<?php
// ============================================
// api/delete_atm.php
// Deletes an ATM record by ID
// Expects POST body: JSON { id }
// ============================================
require_once 'connection.php';
require_once 'auth.php';
require_auth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$body = json_decode(file_get_contents('php://input'), true);

if (!$body || empty($body['id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ATM ID is required']);
    exit;
}

$id = (int) $body['id'];

try {
    $pdo = getDB();

    // Verify record exists first
    $check = $pdo->prepare('SELECT id FROM atms WHERE id = :id');
    $check->execute([':id' => $id]);
    if (!$check->fetch()) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'ATM not found']);
        exit;
    }

    $stmt = $pdo->prepare('DELETE FROM atms WHERE id = :id');
    $stmt->execute([':id' => $id]);

    echo json_encode(['success' => true, 'message' => 'ATM deleted successfully']);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to delete ATM: ' . $e->getMessage()]);
}
