<?php
session_start();
if ($_SESSION['role'] != 'Admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
</head>
<body>
  <h1>Welcome Admin, <?php echo $_SESSION['full_name']; ?>!</h1>
  <p>Here you can manage users, view reports, and oversee system operations.</p>
</body>
</html>
