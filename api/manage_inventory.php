<?php
session_start();
include '../connectiondb.php';
header('Content-Type: application/json');

// Only admin can access
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    http_response_code(403);
    echo json_encode(['success'=>false,'message'=>'Unauthorized']);
    exit();
}

// Add new item
if(isset($_POST['item_name'])){
    $stmt = $conn->prepare("INSERT INTO items (item_name, description, category, quantity, reorder_level) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssii", $_POST['item_name'], $_POST['description'], $_POST['category'], $_POST['quantity'], $_POST['reorder_level']);
    $stmt->execute();
    echo json_encode(['success'=>true]);
    exit();
}

// Delete item
if(isset($_POST['delete_id'])){
    $stmt = $conn->prepare("DELETE FROM items WHERE item_id = ?");
    $stmt->bind_param("i", $_POST['delete_id']);
    $stmt->execute();
    echo json_encode(['success'=>true]);
    exit();
}

echo json_encode(['success'=>false,'message'=>'Invalid request']);
?>  