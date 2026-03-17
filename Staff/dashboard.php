<?php
session_start();
include '../connectiondb.php';

// Only staff can access
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'staff') {
    header("Location: ../login.html");
    exit();
}

$staffName = $_SESSION['name'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Dashboard - PSA Supply</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $staffName; ?> (Staff)</h2>
        <p><a href="../logout.php">Logout</a></p>

        <h3>Menu</h3>
        <ul>
            <li><a href="view_inventory.php">View Inventory</a></li>
            <li><a href="make_request.php">Make Request</a></li>
            <li><a href="my_requests.php">My Requests</a></li>
        </ul>
    </div>
</body>
</html>