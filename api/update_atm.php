<?php
// ============================================
// api/update_atm.php
// Updates an ATM record by ID
// Expects POST body: JSON { id, terminal, address, area, maps }
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

$id       = (int) $body['id'];
$terminal = trim($body['terminal'] ?? '');
$address  = trim($body['address']  ?? '');
$area     = trim($body['area']     ?? '');
$maps     = trim($body['maps']     ?? '');

try {
    $pdo  = getDB();

    // Verify the record exists
    $check = $pdo->prepare('SELECT id FROM atms WHERE id = :id');
    $check->execute([':id' => $id]);
    if (!$check->fetch()) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'ATM not found']);
        exit;
    }

    $stmt = $pdo->prepare(
        'UPDATE atms SET terminal = :terminal, address = :address, area = :area, maps = :maps WHERE id = :id'
    );
    $stmt->execute([
        ':terminal' => $terminal,
        ':address'  => $address,
        ':area'     => $area,
        ':maps'     => $maps,
        ':id'       => $id,
    ]);

    echo json_encode(['success' => true, 'message' => 'ATM updated successfully']);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to update ATM: ' . $e->getMessage()]);
}
