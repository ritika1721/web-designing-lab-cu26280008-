<?php
// LAB SHEET 9 - QUESTION 11: Product pagination using LIMIT and OFFSET
require_once "2.php";
$perPage = 5;
$page = max(1, (int)($_GET["page"] ?? 1));
$total = (int)$conn->query("SELECT COUNT(*) AS total FROM products")->fetch_assoc()["total"];
$totalPages = max(1, (int)ceil($total / $perPage));
$page = min($page, $totalPages);
$offset = ($page - 1) * $perPage;

$stmt = $conn->prepare("SELECT id, name, category, price FROM products ORDER BY id LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $perPage, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head><title>Product Pages</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
<h2>Products - Page <?= $page ?></h2>
<table><tr><th>ID</th><th>Name</th><th>Category</th><th>Price</th></tr>
<?php while ($row = $result->fetch_assoc()): ?>
<tr><td><?= (int)$row["id"] ?></td><td><?= htmlspecialchars($row["name"]) ?></td>
<td><?= htmlspecialchars($row["category"]) ?></td><td>₹<?= number_format((float)$row["price"], 2) ?></td></tr>
<?php endwhile; ?>
</table>
<div class="pages">
<?php if ($page > 1): ?><a href="?page=<?= $page - 1 ?>">Previous</a><?php endif; ?>
<?php for ($i = 1; $i <= $totalPages; $i++): ?>
<a href="?page=<?= $i ?>"><?= $i ?></a>
<?php endfor; ?>
<?php if ($page < $totalPages): ?><a href="?page=<?= $page + 1 ?>">Next</a><?php endif; ?>
</div>
</div></body></html>
