<?php
header('Content-Type: application/json');
require_once '../connectiondb.php';

// Get the category from the URL (e.g., 'Form' or 'Device')
$category = isset($_GET['category']) ? $_GET['category'] : '';

if (empty($category)) {
    echo json_encode(['error' => 'Category is required']);
    exit;
}

// SQL: Select only the ID and Name to keep the payload light for the dropdown
$sql = "SELECT item_id, item_name FROM psa_items WHERE category = ? ORDER BY item_name ASC";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();

    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }

    // Return the array (even if empty) to the JavaScript fetch call
    echo json_encode($items);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

$stmt->close();
$conn->close();