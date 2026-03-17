<?php
session_start();
include 'connectiondb.php';

if (isset($_POST['register'])) {

    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = 'staff'; // Default role

    // Check if email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already registered!'); window.location='register.html';</script>";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $full_name, $email, $hashed_password, $role);

    if ($stmt->execute()) {
        // Automatically log in the new staff
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['name'] = $full_name;
        $_SESSION['role'] = $role;

        echo "<script>alert('Registration successful! You are logged in as staff.'); window.location='staff/dashboard.php';</script>";
        exit();
    } else {
        echo "<script>alert('Registration failed!'); window.location='register.html';</script>";
        exit();
    }
}
?>