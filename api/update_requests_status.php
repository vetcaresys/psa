<?php
session_start();
include '../connectiondb.php';
header('Content-Type: application/json');

// Only admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    echo json_encode(['success'=>false,'message'=>'Unauthorized']);
    exit();
}

if(isset($_POST['request_id']) && isset($_POST['status'])){
    $stmt = $conn->prepare("UPDATE requests SET status=?, approved_by=? WHERE request_id=?");
    $stmt->bind_param("sii", $_POST['status'], $_SESSION['user_id'], $_POST['request_id']);
    $stmt->execute();

    echo json_encode(['success'=>true]);
} else {
    echo json_encode(['success'=>false,'message'=>'Invalid data']);
}
?>