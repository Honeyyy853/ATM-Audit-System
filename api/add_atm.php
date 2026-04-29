<?php
// ============================================
// api/add_atm.php
// Inserts a new ATM record
// Expects POST body: JSON { terminal, address, area, maps }
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

if (!$body) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid JSON body']);
    exit;
}

// Sanitize / default
$terminal = trim($body['terminal'] ?? '');
$address  = trim($body['address']  ?? '');
$area     = trim($body['area']     ?? '');
$maps     = trim($body['maps']     ?? '');

if ($terminal === '' && $address === '' && $area === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'At least one field (Terminal, Address, or Area) is required']);
    exit;
}

try {
    $pdo  = getDB();
    $stmt = $pdo->prepare(
        'INSERT INTO atms (terminal, address, area, maps) VALUES (:terminal, :address, :area, :maps)'
    );
    $stmt->execute([
        ':terminal' => $terminal,
        ':address'  => $address,
        ':area'     => $area,
        ':maps'     => $maps,
    ]);

    $newId = (int) $pdo->lastInsertId();

    // Return the newly created row
    $row = $pdo->prepare('SELECT id, terminal, address, area, maps, audit_status, last_audit_date, created_at FROM atms WHERE id = :id');
    $row->execute([':id' => $newId]);
    $atm = $row->fetch();

    http_response_code(201);
    echo json_encode(['success' => true, 'message' => 'ATM added successfully', 'data' => $atm]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to add ATM: ' . $e->getMessage()]);
}
