<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . "/../db.php";

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'get_bookings':
        try {
            $stmt = $pdo->query("SELECT * FROM bookings WHERE status = 'pending' ORDER BY booking_date, time_slot");
            $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'bookings' => $bookings]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        break;

    case 'confirm_booking':
        $id = intval($_POST['id'] ?? 0);
        if ($id < 1) {
            echo json_encode(['success' => false, 'error' => 'Invalid ID']);
            exit;
        }
        try {
            $stmt = $pdo->prepare("UPDATE bookings SET status = 'confirmed' WHERE id = ? AND status = 'pending'");
            $stmt->execute([$id]);
            echo json_encode(['success' => $stmt->rowCount() > 0]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        break;

    case 'delete_booking':
        $id = intval($_POST['id'] ?? 0);
        if ($id < 1) {
            echo json_encode(['success' => false, 'error' => 'Invalid ID']);
            exit;
        }
        try {
            $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['success' => $stmt->rowCount() > 0]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        break;

    default:
        echo json_encode(['success' => false, 'error' => 'Invalid action: ' . $action]);
}
?>