<?php
session_start();
if ($_SESSION['role'] != 'Records Officer') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Records Officer Dashboard</title>
</head>
<body>
  <h1>Welcome Records Officer, <?php echo $_SESSION['full_name']; ?>!</h1>
  <p>Here you can manage document transactions and storage locations.</p>
</body>
</html>
