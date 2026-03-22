<?php
session_start();
header('Content-Type: application/json');
require_once '../connectiondb.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['username']) && isset($data['password'])) {
    $user = $conn->real_escape_string($data['username']);
    $pass = $data['password'];

    // 1. Get User and Role
    $sql = "SELECT u.psa_user_id, u.psa_username, u.psa_password, u.psa_role_id, r.psa_role_name 
            FROM psa_users u 
            JOIN psa_roles r ON u.psa_role_id = r.psa_roles_id 
            WHERE u.psa_username = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    $userData = $result->fetch_assoc();

    // 2. Verify Password
    if ($userData && password_verify($pass, $userData['psa_password'])) {
        
        // Start the "Memory" (Session)
        $_SESSION['user_id'] = $userData['psa_user_id'];
        $_SESSION['role_id'] = $userData['psa_role_id'];

        // 3. Get Dynamic Permissions for this Role
        $perm_sql = "SELECT p.perm_name, p.perm_slug 
                     FROM permissions p
                     JOIN psa_role_permissions rp ON p.perm_id = rp.perm_id
                     WHERE rp.role_id = ?";
        
        $perm_stmt = $conn->prepare($perm_sql);
        $perm_stmt->bind_param("i", $userData['psa_role_id']);
        $perm_stmt->execute();
        $perm_result = $perm_stmt->get_result();
        
        $modules = [];
        while($row = $perm_result->fetch_assoc()) {
            $modules[] = $row;
        }

        // Store permissions in session for server-side security checks later
        $_SESSION['modules'] = array_column($modules, 'perm_slug');

        echo json_encode([
            "success" => true,
            "role" => $userData['psa_role_name'],
            "modules" => $modules
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid username or password"]);
    }
}
$conn->close();
?>