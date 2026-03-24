<?php
header('Content-Type: application/json');
require_once '../connectiondb.php';

$item_id = $_POST['item_id'];
$qty     = $_POST['qty_sold'];
$ref     = $_POST['ref_no'];

// In the ledger, we store sales as positive numbers but with the 'Sold' tag.
// Our main Inventory SQL query handles the subtraction logic.
$sql = "INSERT INTO psa_inventory_ledger (item_id, trans_type, qty, reference_id) 
        VALUES (?, 'Sold', ?, ?)";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $item_id, $qty, $ref);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

$conn->close();