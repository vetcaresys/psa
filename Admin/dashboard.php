<?php
session_start();
include '../connectiondb.php';

// Only admin can access
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.html");
    exit();
}

$adminName = $_SESSION['name'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - PSA Supply</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $adminName; ?> (Admin)</h2>
        <p><a href="../logout.php">Logout</a></p>

        <h3>Menu</h3>
        <ul>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="manage_inventory.php">Manage Inventory</a></li>
            <li><a href="view_requests.php">View Requests</a></li>
        </ul>
    </div>
</body>
</html>