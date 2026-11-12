<?php
// LAB SHEET 9 - QUESTION 7: Insert a product using a prepared statement
require_once "2.php";
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $category = trim($_POST["category"] ?? "");
    $price = filter_var($_POST["price"] ?? "", FILTER_VALIDATE_FLOAT);

    if ($name === "" || $category === "" || $price === false || $price < 0) {
        $message = "Please enter valid product details.";
    } else {
        $stmt = $conn->prepare("INSERT INTO products (name, category, price) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $name, $category, $price);
        $message = $stmt->execute() ? "Product added successfully." : "Could not add product.";
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Add Product</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
<h2>Add New Product</h2><p><?= htmlspecialchars($message) ?></p>
<form method="post">
<label>Product Name</label><input name="name" required>
<label>Category</label><input name="category" required>
<label>Price</label><input type="number" name="price" min="0" step="0.01" required>
<button type="submit">Save Product</button>
</form>
<p><a href="8.php">Product List</a></p>
</div></body></html>
