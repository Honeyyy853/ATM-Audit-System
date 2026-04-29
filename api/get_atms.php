<?php
// ============================================
// api/get_atms.php
// Returns all ATMs as JSON array
// ============================================
require_once 'connection.php';
require_once 'auth.php';
require_auth();


try {
    $pdo  = getDB();
    // Use MySQL MONTH() and YEAR() to check if last_audit_date matches the current month/year.
    // We can do it in PHP instead to be clean.
    $stmt = $pdo->query('SELECT id, terminal, address, area, maps, audit_status, last_audit_date, created_at FROM atms ORDER BY area ASC, id ASC');
    $atms = $stmt->fetchAll();

    // Check if audit_status needs resetting for new month
    $currentYearMonth = date('Y-m');
    $updatedCount = 0;
    foreach ($atms as &$atm) {
        if ($atm['audit_status'] == 1 && $atm['last_audit_date']) {
            $auditYearMonth = date('Y-m', strtotime($atm['last_audit_date']));
            if ($auditYearMonth !== $currentYearMonth) {
                // Reset status to 0
                $atm['audit_status'] = 0;
                // We also update the database so it reflects
                $updStmt = $pdo->prepare('UPDATE atms SET audit_status = 0 WHERE id = ?');
                $updStmt->execute([$atm['id']]);
            }
        }
    }

    echo json_encode([
        'success' => true,
        'data'    => $atms,
        'count'   => count($atms),
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to fetch ATMs: ' . $e->getMessage()]);
}
