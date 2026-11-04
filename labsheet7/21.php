<?php
include "db.php";

// Total Orders
$totalOrders = $conn->query(
    "SELECT COUNT(*) AS total FROM orders"
)->fetch_assoc()['total'];

// Total Revenue
$totalRevenue = $conn->query(
    "SELECT SUM(total_amount) AS revenue
     FROM orders
     WHERE status != 'Pending'"
)->fetch_assoc()['revenue'];

// Total Customers
$totalUsers = $conn->query(
    "SELECT COUNT(*) AS total FROM users"
)->fetch_assoc()['total'];

// Total Books
$totalBooks = $conn->query(
    "SELECT COUNT(*) AS total FROM books"
)->fetch_assoc()['total'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h1>Admin Sales Report</h1>

<div class="books">

    <div class="card">

        <h2>Total Orders</h2>

        <h3><?php echo $totalOrders; ?></h3>

    </div>

    <div class="card">

        <h2>Total Revenue</h2>

        <h3>
            ₹<?php echo number_format($totalRevenue ?? 0, 2); ?>
        </h3>

    </div>

    <div class="card">

        <h2>Total Customers</h2>

        <h3><?php echo $totalUsers; ?></h3>

    </div>

    <div class="card">

        <h2>Total Books</h2>

        <h3><?php echo $totalBooks; ?></h3>

    </div>

</div>

</div>

</body>
</html>