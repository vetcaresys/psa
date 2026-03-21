<?php
session_start();
header('Content-Type: application/json');

if(!isset($_SESSION['role'])){
    http_response_code(403);
    echo json_encode(['error'=>'Unauthorized']);
    exit();
}

echo json_encode([
    'name' => $_SESSION['name'],
    'role' => $_SESSION['role']
]);
?>