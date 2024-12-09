<?php
include 'dbconn.php';

$month = isset($_GET['month']) ? intval($_GET['month']) : null;
$year = isset($_GET['year']) ? intval($_GET['year']) : null;

$sql = "SELECT app_status, COUNT(*) AS count FROM application WHERE 1=1";

if ($month) {
    $sql .= " AND MONTH(app_date) = $month";
}
if ($year) {
    $sql .= " AND YEAR(app_date) = $year";
}

$sql .= " GROUP BY app_status";

$result = $dbconn->query($sql);

$data = [
    "Pending" => 0,
    "Approved" => 0,
    "Rejected" => 0
];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[$row['app_status']] = $row['count'];
    }
}

echo json_encode([
    'labels' => array_keys($data),
    'data' => array_values($data)
]);

$dbconn->close();
?>
