<?php
header('Content-Type: application/json');
// Turn off error reporting to screen so warnings don't break JSON
ini_set('display_errors', 0); 

include '../connectiondb.php';

// Add this right after your in_array check
 $category = $_GET['category'] ;
if (!in_array($category, ['Device', 'Form', 'All'])) {
    echo json_encode([
        "error" => "Invalid category",
        "received_value" => $category, // This will tell you what was actually passed
        "get_data" => $_GET            // This shows everything in the URL
    ]);
    exit;
}
$month    = isset($_GET['month']) ? (int)$_GET['month'] : (int)date('m');
$year     = isset($_GET['year']) ? (int)$_GET['year'] : (int)date('Y');

$target_month_start = "$year-" . str_pad($month, 2, "0", STR_PAD_LEFT) . "-01";
$data = [];

if ($category === 'Device') {
    $sql = "SELECT 
                i.item_id, 
                i.item_name, 
                d.brand_model,
                d.serial_no
            FROM psa_items i
            LEFT JOIN psa_item_devices d ON i.item_id = d.item_id
            WHERE i.category = 'Device'
            ORDER BY i.item_name ASC";
}else{
    $sql = "SELECT 
        i.item_id,
        i.item_name,
        (SELECT IFNULL(SUM(CASE 
            WHEN trans_type = 'Beginning' THEN qty 
            WHEN trans_type = 'Sold' THEN -qty 
            WHEN trans_type = 'Returned_from_PSA' THEN -qty 
            ELSE 0 END), 0) 
         FROM psa_inventory_ledger 
         WHERE item_id = i.item_id AND trans_date < '$target_month_start') as beginning_inventory,
        (SELECT dr_number FROM psa_stock_in 
         WHERE item_id = i.item_id AND MONTH(date_received) = $month AND YEAR(date_received) = $year 
         ORDER BY date_received DESC LIMIT 1) as dr_no,
        (SELECT IFNULL(SUM(qty_received), 0) FROM psa_stock_in 
         WHERE item_id = i.item_id AND MONTH(date_received) = $month AND YEAR(date_received) = $year) as qty_received,
        (SELECT IFNULL(SUM(qty), 0) FROM psa_inventory_ledger 
         WHERE item_id = i.item_id AND trans_type = 'Sold' 
         AND MONTH(trans_date) = $month AND YEAR(trans_date) = $year) as forms_sold,
        (SELECT IFNULL(SUM(qty), 0) FROM psa_inventory_ledger 
         WHERE item_id = i.item_id AND trans_type = 'Returned_from_PSA' 
         AND MONTH(trans_date) = $month AND YEAR(trans_date) = $year) as forms_returned
    FROM psa_items i
    WHERE i.category = 'Form'
    ORDER BY i.item_name ASC";
}

$result = $conn->query($sql);

if ($result) {
    while($row = $result->fetch_assoc()) {
        if ($category !== 'Device') {
            $beg = (int)$row['beginning_inventory'];
            $rec = (int)$row['qty_received'];
            $sold = (int)$row['forms_sold'];
            $ret = (int)$row['forms_returned'];

            $row['available_for_sale'] = $beg + $rec;
            $row['ending_inventory'] = ($beg + $rec) - $sold - $ret;
        }
        $row['category'] = $category; // Fixed the trailing quote here
        $data[] = $row;
    }
} else {
    // Return SQL error in JSON format
    echo json_encode(["error" => $conn->error]);
    exit;
}

echo json_encode($data);
$conn->close();
?>