<?php
include "db.php";

if(!isset($_SESSION['user_id'])) {
    die("Please login first.");
}

$order_id = intval($_GET['id'] ?? 0);
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare(
    "SELECT * FROM orders WHERE id=? AND user_id=?"
);

$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();

$order = $stmt->get_result()->fetch_assoc();

if(!$order) {
    die("Order not found.");
}

$stmt = $conn->prepare(
    "SELECT books.title, order_items.quantity,
     order_items.price
     FROM order_items
     JOIN books ON order_items.book_id = books.id
     WHERE order_items.order_id = ?"
);

$stmt->bind_param("i", $order_id);
$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Invoice</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h1>Online Bookstore Invoice</h1>

<h3>Order ID: <?php echo $order['id']; ?></h3>

<p>Date: <?php echo $order['order_date']; ?></p>

<p>Shipping Address:
<?php echo htmlspecialchars($order['shipping_address']); ?></p>

<table border="1" cellpadding="10" width="100%">

<tr>
    <th>Book</th>
    <th>Quantity</th>
    <th>Price</th>
    <th>Total</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>

<tr>

    <td><?php echo htmlspecialchars($row['title']); ?></td>

    <td><?php echo $row['quantity']; ?></td>

    <td>₹<?php echo $row['price']; ?></td>

    <td>
        ₹<?php echo $row['quantity'] * $row['price']; ?>
    </td>

</tr>

<?php } ?>

</table>

<h2>
    Total Amount: ₹<?php echo $order['total_amount']; ?>
</h2>

<p>Status: <?php echo htmlspecialchars($order['status']); ?></p>

<button onclick="window.print()">Print Invoice</button>

</div>

</body>
</html>