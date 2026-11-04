<?php
include "db.php";

if(isset($_POST['update'])) {

    $id = intval($_POST['id']);
    $status = $_POST['status'];

    $allowed = ['Pending', 'Shipped', 'Delivered'];

    if(in_array($status, $allowed, true)) {

        $stmt = $conn->prepare(
            "UPDATE orders SET status=? WHERE id=?"
        );

        $stmt->bind_param("si", $status, $id);
        $stmt->execute();
    }
}

$result = $conn->query(
    "SELECT orders.*, users.name
     FROM orders
     JOIN users ON orders.user_id=users.id
     ORDER BY orders.id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Orders</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h1>Customer Orders</h1>

<?php while($row = $result->fetch_assoc()) { ?>

<div class="card">

    <h3>Order ID: <?php echo $row['id']; ?></h3>

    <p>Customer: <?php echo htmlspecialchars($row['name']); ?></p>

    <p>Total: ₹<?php echo $row['total_amount']; ?></p>

    <p>Address:
    <?php echo htmlspecialchars($row['shipping_address']); ?></p>

    <form method="POST">

        <input type="hidden" name="id"
        value="<?php echo $row['id']; ?>">

        <select name="status">

            <option>Pending</option>
            <option>Shipped</option>
            <option>Delivered</option>

        </select>

        <button name="update">Update Status</button>

    </form>

</div>

<?php } ?>

</div>

</body>
</html>