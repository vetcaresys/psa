<?php
header('Content-Type: application/json');
require_once '../connectiondb.php';

// 1. Get Parameters
$category = isset($_GET['category']) ? $_GET['category'] : 'Form';
$month    = isset($_GET['month']) ? (int)$_GET['month'] : (int)date('m');
$year     = isset($_GET['year']) ? (int)$_GET['year'] : (int)date('Y');

$target_month_start = "$year-$month-01";
$data = [];

if ($category === 'Device') {
    // --- DEVICE LOGIC ---
    // Simple fetch of hardware details from the secondary table
    $sql = "SELECT 
                i.item_id, 
                i.item_name, 
                d.brand_model, 
                d.serial_no, 
                d.assigned_to,
                d.status
            FROM psa_items i
            LEFT JOIN psa_item_devices d ON i.item_id = d.item_id
            WHERE i.category = 'Device'
            ORDER BY i.item_name ASC";

    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

} else {
    // --- FORM LOGIC (The Ledger Math) ---
    $sql = "SELECT 
        i.item_id,
        i.item_name,
        
        -- Beginning Inventory
        (SELECT IFNULL(SUM(CASE 
            WHEN trans_type = 'Beginning' THEN qty 
            WHEN trans_type = 'Sold' THEN -qty 
            WHEN trans_type = 'Returned_from_PSA' THEN -qty 
            ELSE 0 END), 0) 
         FROM psa_inventory_ledger 
         WHERE item_id = i.item_id AND trans_date < '$target_month_start') as beginning_inventory,
        
        -- Forms Received
        (SELECT dr_number FROM psa_stock_in 
         WHERE item_id = i.item_id AND MONTH(date_received) = $month AND YEAR(date_received) = $year 
         ORDER BY date_received DESC LIMIT 1) as dr_no,
         
        (SELECT IFNULL(SUM(qty_received), 0) FROM psa_stock_in 
         WHERE item_id = i.item_id AND MONTH(date_received) = $month AND YEAR(date_received) = $year) as qty_received,
        
        -- Forms Sold
        (SELECT IFNULL(SUM(qty), 0) FROM psa_inventory_ledger 
         WHERE item_id = i.item_id AND trans_type = 'Sold' 
         AND MONTH(trans_date) = $month AND YEAR(trans_date) = $year) as forms_sold,
                
        -- Forms Returned
        (SELECT IFNULL(SUM(qty), 0) FROM psa_inventory_ledger 
         WHERE item_id = i.item_id AND trans_type = 'Returned_from_PSA' 
         AND MONTH(trans_date) = $month AND YEAR(trans_date) = $year) as forms_returned

    FROM psa_items i
    WHERE i.category = 'Form'
    ORDER BY i.item_name ASC";

    $result = $conn->query($sql);
    
    if ($result) {
        while($row = $result->fetch_assoc()) {
            $beg = (int)$row['beginning_inventory'];
            $rec = (int)$row['qty_received'];
            $sold = (int)$row['forms_sold'];
            $ret = (int)$row['forms_returned'];

            $row['available_for_sale'] = $beg + $rec;
            $row['ending_inventory'] = ($beg + $rec) - $sold - $ret;
            
            $data[] = $row;
        }
    }
}

// 3. Final Output
echo json_encode($data);
$conn->close();