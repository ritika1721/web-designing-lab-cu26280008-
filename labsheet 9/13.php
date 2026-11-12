<?php
// LAB SHEET 9 - QUESTION 13: Sort products by clicking table headings
require_once "2.php";
$allowed = ["name", "category", "price"];
$sort = $_GET["sort"] ?? "name";
if (!in_array($sort, $allowed, true)) { $sort = "name"; }
$order = strtolower($_GET["order"] ?? "asc") === "desc" ? "DESC" : "ASC";
$nextOrder = $order === "ASC" ? "desc" : "asc";

// Column name comes only from the allow-list above.
$result = $conn->query("SELECT id, name, category, price FROM products ORDER BY $sort $order");
function sortLink($column, $label, $current, $next) {
    return '<a href="?sort=' . $column . '&order=' .
        (($current === $column && $next === "asc") ? "desc" : "asc") . '">' .
        htmlspecialchars($label) . '</a>';
}
?>
<!DOCTYPE html>
<html>
<head><title>Sort Products</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
<h2>Sort Products</h2>
<p>Click a heading to change the sorting order.</p>
<table><tr><th>ID</th><th><?= sortLink("name","Name",$sort,$nextOrder) ?></th>
<th><?= sortLink("category","Category",$sort,$nextOrder) ?></th>
<th><?= sortLink("price","Price",$sort,$nextOrder) ?></th></tr>
<?php while ($row = $result->fetch_assoc()): ?>
<tr><td><?= (int)$row["id"] ?></td><td><?= htmlspecialchars($row["name"]) ?></td>
<td><?= htmlspecialchars($row["category"]) ?></td><td>₹<?= number_format((float)$row["price"], 2) ?></td></tr>
<?php endwhile; ?>
</table>
</div></body></html>
