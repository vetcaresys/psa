<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Staff') {
    header("Location: login.php");
    exit();
}

// Database Connection
$conn = new mysqli("localhost", "root", "", "your_database_name");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Counts
$totalDocs = $conn->query("SELECT COUNT(*) as total FROM document")->fetch_assoc()['total'];
$availableDocs = $conn->query("SELECT COUNT(*) as total FROM document WHERE status='Available'")->fetch_assoc()['total'];
$releasedDocs = $conn->query("SELECT COUNT(*) as total FROM document WHERE status='Released'")->fetch_assoc()['total'];

// Recent Transactions
$transactions = $conn->query("
    SELECT dt.transaction_id, d.registry_number, dt.transaction_type, dt.released_to, dt.date_out
    FROM document_transaction dt
    LEFT JOIN document d ON dt.document_id = d.document_id
    ORDER BY dt.transaction_id DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Dashboard</title>
    <style>
        body { font-family: Arial; background:#f4f6f9; padding:20px; }
        .card { background:white; padding:15px; border-radius:8px; margin-bottom:15px; box-shadow:0 2px 5px rgba(0,0,0,0.1);}
        .stats { display:flex; gap:20px; }
        .stat-box { flex:1; text-align:center; padding:20px; background:#e9f2ff; border-radius:8px; }
        table { width:100%; border-collapse:collapse; margin-top:10px; }
        th, td { padding:10px; border-bottom:1px solid #ddd; text-align:left; }
        th { background:#007bff; color:white; }
        a.button { display:inline-block; padding:8px 15px; background:#007bff; color:white; text-decoration:none; border-radius:5px; margin-right:10px;}
    </style>
</head>
<body>

<h2>Welcome Staff, <?php echo $_SESSION['full_name']; ?> 👋</h2>

<div class="stats">
    <div class="stat-box">
        <h3><?php echo $totalDocs; ?></h3>
        <p>Total Documents</p>
    </div>
    <div class="stat-box">
        <h3><?php echo $availableDocs; ?></h3>
        <p>Available</p>
    </div>
    <div class="stat-box">
        <h3><?php echo $releasedDocs; ?></h3>
        <p>Released</p>
    </div>
</div>

<div class="card">
    <h3>Quick Actions</h3>
    <a href="process_release.php" class="button">Process Release</a>
    <a href="view_documents.php" class="button">View Documents</a>
</div>

<div class="card">
    <h3>Recent Transactions</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Registry No.</th>
            <th>Type</th>
            <th>Released To</th>
            <th>Date Out</th>
        </tr>
        <?php while($row = $transactions->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['transaction_id']; ?></td>
            <td><?php echo $row['registry_number']; ?></td>
            <td><?php echo $row['transaction_type']; ?></td>
            <td><?php echo $row['released_to']; ?></td>
            <td><?php echo $row['date_out']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>

<?php $conn->close(); ?>