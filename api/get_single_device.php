<?php
include '../connectiondb.php';

$id = $_GET['id'];

$sql = "SELECT i.item_id, i.item_name, d.brand_model, d.serial_no
        FROM psa_items i
        LEFT JOIN psa_item_devices d ON i.item_id = d.item_id
        WHERE i.item_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

echo json_encode($data);
?>