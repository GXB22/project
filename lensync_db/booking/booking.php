<?php include "../db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LENTECH'S - Booking Requests</title>
<link rel="stylesheet" href="../css/Admin_Dashboard.css">
</head>
<body>

<div class="sidebar">
    <a href=".//dashboard.php">Dashboard</a>
    <a href="./booking_requests.php" class="active">Bookings</a>
    <a href="../studio/studio.php">Studio</a>
    <a href="#">Reports</a>
</div>

<div class="main-content">

<div class="topbar">
    <div class="logo">LENTECH'S</div>
    <div class="top-menu">
        <span>Studio</span>
        <span class="active">Bookings</span>
        <a href="../Logout.php" class="logout-btn">Logout</a>
    </div>
</div>

<div class="booking-requests-container">
    <h2>Booking Requests</h2>
    <div id="message-area"></div>
    <div id="bookings-list">
        <div class="loading">Loading bookings...</div>
    </div>
</div>

</div>

<script src="./js/booking.js"></script>

</body>
</html>