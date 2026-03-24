<?php
header('Content-Type: application/json');
require_once '../connectiondb.php';

$item_id = $_POST['item_id'];
$dr      = $_POST['dr_number'];
$qty     = $_POST['qty_received'];
$date    = $_POST['date_received'];

// Start Transaction so both tables update together
$conn->begin_transaction();

try {
    // 1. Record the Receipt
    $stmt1 = $conn->prepare("INSERT INTO psa_stock_in (item_id, dr_number, qty_received, date_received) VALUES (?, ?, ?, ?)");
    $stmt1->bind_param("isis", $item_id, $dr, $qty, $date);
    $stmt1->execute();

    // 2. Update the Ledger (Type 'Beginning' or 'Adjustment' to increase stock)
    $stmt2 = $conn->prepare("INSERT INTO psa_inventory_ledger (item_id, trans_type, qty, reference_id) VALUES (?, 'Beginning', ?, ?)");
    $stmt2->bind_param("iis", $item_id, $qty, $dr);
    $stmt2->execute();

    $conn->commit();
    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
$conn->close();