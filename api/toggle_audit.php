<?php
// ============================================
// api/toggle_audit.php
// Toggles the audit status of an ATM
// Expects POST body: JSON { id, audit_status }
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

if (!$body || empty($body['id']) || !isset($body['audit_status'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ATM ID and audit_status are required']);
    exit;
}

$id = (int) $body['id'];
$audit_status = (int) $body['audit_status'];
$last_audit_date = $audit_status == 1 ? date('Y-m-d') : null;

try {
    $pdo = getDB();

    // Verify the record exists
    $check = $pdo->prepare('SELECT id FROM atms WHERE id = :id');
    $check->execute([':id' => $id]);
    if (!$check->fetch()) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'ATM not found']);
        exit;
    }

    $stmt = $pdo->prepare(
        'UPDATE atms SET audit_status = :audit_status, last_audit_date = :last_audit_date WHERE id = :id'
    );
    $stmt->execute([
        ':audit_status' => $audit_status,
        ':last_audit_date' => $last_audit_date,
        ':id' => $id,
    ]);

    // Return updated record
    $row = $pdo->prepare('SELECT id, terminal, address, area, maps, audit_status, last_audit_date, created_at FROM atms WHERE id = :id');
    $row->execute([':id' => $id]);
    $atm = $row->fetch();

    echo json_encode(['success' => true, 'message' => 'Audit status updated', 'data' => $atm]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to update audit status: ' . $e->getMessage()]);
}
