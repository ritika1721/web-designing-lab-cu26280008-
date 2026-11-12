<?php
// LAB SHEET 9 - QUESTION 10: Delete product with confirmation and safe PHP handler
require_once "2.php";
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
    if ($id) {
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $message = $stmt->affected_rows > 0 ? "Product deleted." : "No product was deleted.";
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Delete Product</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
<h2>Delete Product</h2>
<?php if ($message): ?><p><?= htmlspecialchars($message) ?></p><?php endif; ?>
<?php if ($id && $_SERVER["REQUEST_METHOD"] !== "POST"): ?>
<p>Are you sure you want to delete product number <?= (int)$id ?>?</p>
<form method="post" onsubmit="return confirm('Are you sure you want to delete this product?');">
<input type="hidden" name="id" value="<?= (int)$id ?>">
<button type="submit">Yes, Delete</button>
</form>
<?php else: ?>
<p>Open this page with a product ID, for example 10.php?id=1</p>
<?php endif; ?>
</div></body></html>
