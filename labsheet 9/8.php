<?php
// LAB SHEET 9 - QUESTION 8: Display products in an HTML table
require_once "2.php";
$result = $conn->query("SELECT id, name, category, price FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head><title>Product List</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
<h2>All Products</h2>
<p><a href="7.php">Add Product</a> | <a href="12.php">Search Products</a></p>
<table>
<tr><th>ID</th><th>Name</th><th>Category</th><th>Price</th></tr>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
<td><?= (int)$row["id"] ?></td>
<td><?= htmlspecialchars($row["name"]) ?></td>
<td><?= htmlspecialchars($row["category"]) ?></td>
<td>₹<?= number_format((float)$row["price"], 2) ?></td>
</tr>
<?php endwhile; ?>
</table>
</div></body></html>
