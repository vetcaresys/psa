<?php
session_start();
include 'connectiondb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO User (full_name, role, username, password) 
            VALUES ('$full_name', '$role', '$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registration successful!'); window.location='login.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - Philippine Statistics Authority Ozamiz</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{
      font-family: Arial;
      font-size: 12px;
    }
  </style>
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
          <h4>Register</h4>
        </div>
        <div class="card-body">
          <form method="POST">
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="text" email="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Full Name</label>
              <input type="text" name="full_name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Role</label>
              <select name="role" class="form-select" required>
                <!-- <option value="Admin">Admin</option> -->
                <option value="Records Officer">Records Officer</option>
                <option value="Staff">Staff</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button><br></br>
             <a class="nav-link" href="index.php" style="dsiplay: block; text-align: center;">Homepage</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
