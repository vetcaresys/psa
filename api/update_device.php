<?php
include '../connectiondb.php';

$item_id = $_POST['item_id'];
$name = $_POST['item_name'];
$brand = $_POST['brand_model'];
$serial = $_POST['serial_no'];

// Update main table
$conn->query("UPDATE psa_items SET item_name='$name' WHERE item_id='$item_id'");

// Update device table
$conn->query("UPDATE psa_item_devices 
              SET brand_model='$brand', serial_no='$serial' 
              WHERE item_id='$item_id'");

echo json_encode(['status' => 'success']);
?>