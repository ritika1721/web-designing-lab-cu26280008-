<?php
// LAB SHEET 9 - QUESTION 5: Protected dashboard
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: 4.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Dashboard</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="container">
    <h2>Welcome, <?= htmlspecialchars($_SESSION["user_name"]) ?>!</h2>
    <p>You have successfully opened the protected dashboard.</p>
    <p><a href="8.php">View Products</a></p>
    <p><a href="6.php">Logout</a></p>
</div>
</body>
</html>
