<?php
// LAB SHEET 9 - QUESTION 12: Search by name/category and price range
require_once "2.php";
$name = trim($_GET["name"] ?? "");
$category = trim($_GET["category"] ?? "");
$min = ($_GET["min"] ?? "") !== "" ? (float)$_GET["min"] : 0;
$max = ($_GET["max"] ?? "") !== "" ? (float)$_GET["max"] : 999999999;

$sql = "SELECT id, name, category, price FROM products
        WHERE name LIKE ? AND category LIKE ? AND price BETWEEN ? AND ?";
$stmt = $conn->prepare($sql);
$nameLike = "%" . $name . "%";
$categoryLike = "%" . $category . "%";
$stmt->bind_param("ssdd", $nameLike, $categoryLike, $min, $max);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head><title>Search Products</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
<h2>Search Products</h2>
<form method="get">
<label>Name</label><input name="name" value="<?= htmlspecialchars($name) ?>">
<label>Category</label><input name="category" value="<?= htmlspecialchars($category) ?>">
<label>Minimum Price</label><input type="number" step="0.01" name="min" value="<?= htmlspecialchars($_GET["min"] ?? "") ?>">
<label>Maximum Price</label><input type="number" step="0.01" name="max" value="<?= htmlspecialchars($_GET["max"] ?? "") ?>">
<button type="submit">Search</button>
</form>
<table><tr><th>ID</th><th>Name</th><th>Category</th><th>Price</th></tr>
<?php while ($row = $result->fetch_assoc()): ?>
<tr><td><?= (int)$row["id"] ?></td><td><?= htmlspecialchars($row["name"]) ?></td>
<td><?= htmlspecialchars($row["category"]) ?></td><td>₹<?= number_format((float)$row["price"], 2) ?></td></tr>
<?php endwhile; ?>
</table>
</div></body></html>
