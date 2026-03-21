<?php
session_start();
include 'connectiondb.php';

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'admin') {
                header("Location: admin/dashboard.html");
            } else {
                header("Location: staff/dashboard.html");
            }
            exit();
        } else {
            echo "<script>alert('Wrong password!'); window.location='login.html';</script>";
        }
    } else {
        echo "<script>alert('User not found!'); window.location='login.html';</script>";
    }
}
?>