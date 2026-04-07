<?php
include "db.php";

$month = isset($_GET['month']) ? intval($_GET['month']) : date('m');
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

$sql = "SELECT * FROM events WHERE MONTH(date) = $month AND YEAR(date) = $year";
$result = $conn->query($sql);

$events = [];

while($row = $result->fetch_assoc()) {
    $events[] = $row;
}

echo json_encode($events);
?>