<?php
session_start();
include '../connectiondb.php';
header('Content-Type: application/json');

// Only admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    echo json_encode(['error'=>'Unauthorized']);
    exit();
}

$sql = "SELECT r.*, u.full_name 
        FROM requests r
        JOIN users u ON r.user_id = u.user_id
        ORDER BY r.request_id DESC";

$result = $conn->query($sql);

$data = [];
while($row = $result->fetch_assoc()){
    $data[] = $row;
}

echo json_encode($data);
?>