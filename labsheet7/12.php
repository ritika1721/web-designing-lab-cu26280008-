<?php
include "db.php";

if(!isset($_SESSION['user_id'])) {
    die("Please login first.");
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare(
    "SELECT * FROM orders
     WHERE user_id = ?
     ORDER BY order_date DESC"
);

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h1>My Order History</h1>

<?php while($row = $result->fetch_assoc()) { ?>

    <div class="card">

        <h3>Order ID: <?php echo $row['id']; ?></h3>

        <p>Total Amount: ₹<?php echo $row['total_amount']; ?></p>

        <p>Date: <?php echo $row['order_date']; ?></p>

        <p>Status:
            <?php echo htmlspecialchars($row['status']); ?>
        </p>

        <a href="16.php?id=<?php echo $row['id']; ?>">
            View Invoice
        </a>

    </div>

<?php } ?>

</div>

</body>
</html>