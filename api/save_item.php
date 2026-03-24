<?php
header('Content-Type: application/json');
require_once '../connectiondb.php';

$name = $_POST['item_name'];
$cat  = $_POST['category'];

// 1. Insert into Main Table
$sql1 = "INSERT INTO psa_items (item_name, category) VALUES (?, ?)";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param("ss", $name, $cat);

if ($stmt1->execute()) {
    $last_id = $conn->insert_id;

    // 2. Insert into Specific Detail Tables based on Category
    if ($cat === 'Form') {
        $code = $_POST['form_type_code'];
        $qty  = $_POST['qty_per_bundle'];
        $sql2 = "INSERT INTO psa_item_forms (item_id, form_type_code, qty_per_bundle) VALUES (?, ?, ?)";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("isi", $last_id, $code, $qty);
        $stmt2->execute();
    } 
    elseif ($cat === 'Device') {
        $sn = $_POST['serial_no'];
        $bm = $_POST['brand_model'];
        $sql2 = "INSERT INTO psa_item_devices (item_id, serial_no, brand_model) VALUES (?, ?, ?)";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("iss", $last_id, $sn, $bm);
        $stmt2->execute();
    }

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
}
$conn->close();