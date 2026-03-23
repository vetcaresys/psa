<?php
header('Content-Type: application/json');
require_once '../connectiondb.php'; // Path to your db connection

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['username']) && isset($data['password']) && isset($data['role_id'])) {
    $user = $conn->real_escape_string($data['username']);
    
    // Hash the password
    $pass = password_hash($data['password'], PASSWORD_DEFAULT);
    $role = (int)$data['role_id'];

    // Check if user already exists
    $check = $conn->prepare("SELECT psa_user_id FROM psa_users WHERE psa_username = ?");
    $check->bind_param("s", $user);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "Username already taken"]);
        exit;
    }

    // Insert new user
    $sql = "INSERT INTO psa_users (psa_username, psa_password, psa_role_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $user, $pass, $role);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Registration successful!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error creating account"]);
    }
}
$conn->close();
?>