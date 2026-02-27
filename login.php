<?php
session_start();
include 'connectiondb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql    = "SELECT * FROM User WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // Store session data
            $_SESSION['user_id']   = $user['user_id'];
            $_SESSION['role']      = $user['role'];
            $_SESSION['full_name'] = $user['full_name'];

            // Redirect based on role
            if ($user['role'] == 'Admin') {
                header("Location: Admin/admin_index.php");
            } elseif ($user['role'] == 'Records Officer') {
                header("Location: Record/records_index.php");
            } elseif ($user['role'] == 'Staff') {
                header("Location: Staff/staff_index.php");
            } else {
                header("Location: index.php"); // fallback
            }
            exit();
        } else {
            echo "<script>alert('Invalid password');</script>";
        }
    } else {
        echo "<script>alert('User not found');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - PSA Ozamiz</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
          <h4>Login</h4>
        </div>
        <div class="card-body">
          <form method="POST">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button><br></br>
            <a class="nav-link" href="index.php"style="dsiplay: block; text-align: center;">Homepage</a>
            <a class="nav-link" href="" style="dsiplay: block; text-align: center;">Forgot Password?</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
