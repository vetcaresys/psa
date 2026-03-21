<?php
session_start();
include '../connectiondb.php';

// Optional: check if logged in
if(!isset($_SESSION['role'])){
    http_response_code(403);
    echo json_encode(['error'=>'Unauthorized']);
    exit();
}

// Fetch all inventory
$result = $conn->query("SELECT * FROM items ORDER BY item_id DESC");
$items = [];
while($row = $result->fetch_assoc()){
    $items[] = $row;
}

// Return JSON
header('Content-Type: application/json');
echo json_encode($items);
?>