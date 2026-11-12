<?php
// LAB SHEET 9 - QUESTION 9: Edit an existing product
require_once "2.php";
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$message = "";

if (!$id) {
    die("Please open this page with an existing product ID, for example 9.php?id=1");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $category = trim($_POST["category"] ?? "");
    $price = filter_var($_POST["price"] ?? "", FILTER_VALIDATE_FLOAT);

    if ($name !== "" && $category !== "" && $price !== false && $price >= 0) {
        $stmt = $conn->prepare("UPDATE products SET name = ?, category = ?, price = ? WHERE id = ?");
        $stmt->bind_param("ssdi", $name, $category, $price, $id);
        $message = $stmt->execute() ? "Product updated." : "Update failed.";
        $stmt->close();
    } else {
        $message = "Please enter valid details.";
    }
}

$stmt = $conn->prepare("SELECT name, category, price FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$product) { die("Product not found."); }
?>
<!DOCTYPE html>
<html>
<head><title>Edit Product</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
<h2>Edit Product</h2><p><?= htmlspecialchars($message) ?></p>
<form method="post">
<label>Name</label><input name="name" value="<?= htmlspecialchars($product["name"]) ?>" required>
<label>Category</label><input name="category" value="<?= htmlspecialchars($product["category"]) ?>" required>
<label>Price</label><input type="number" step="0.01" min="0" name="price" value="<?= htmlspecialchars((string)$product["price"]) ?>" required>
<button type="submit">Update</button>
</form>
</div></body></html>
