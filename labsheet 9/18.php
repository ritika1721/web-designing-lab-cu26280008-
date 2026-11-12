<?php
// LAB SHEET 9 - QUESTION 18: Simple shopping cart using PHP sessions
session_start();
require_once "2.php";

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? "";
    $id = filter_input(INPUT_POST, "product_id", FILTER_VALIDATE_INT);

    if ($id && $action === "add") {
        $stmt = $conn->prepare("SELECT id FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $_SESSION["cart"][$id] = ($_SESSION["cart"][$id] ?? 0) + 1;
        }
        $stmt->close();
    } elseif ($id && $action === "remove") {
        unset($_SESSION["cart"][$id]);
    } elseif ($id && $action === "update") {
        $quantity = max(1, min(99, (int)($_POST["quantity"] ?? 1)));
        $_SESSION["cart"][$id] = $quantity;
    }
}

$products = $conn->query("SELECT id, name, price FROM products ORDER BY name");
$cartRows = [];
$grandTotal = 0;
if ($_SESSION["cart"]) {
    $ids = array_keys($_SESSION["cart"]);
    $placeholders = implode(",", array_fill(0, count($ids), "?"));
    $types = str_repeat("i", count($ids));
    $stmt = $conn->prepare("SELECT id, name, price FROM products WHERE id IN ($placeholders)");
    $stmt->bind_param($types, ...$ids);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $row["quantity"] = $_SESSION["cart"][$row["id"]];
        $row["subtotal"] = $row["price"] * $row["quantity"];
        $grandTotal += $row["subtotal"];
        $cartRows[] = $row;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head><title>Shopping Cart</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
<h2>Available Products</h2>
<?php while ($p = $products->fetch_assoc()): ?>
<div class="product">
<?= htmlspecialchars($p["name"]) ?> - ₹<?= number_format((float)$p["price"], 2) ?>
<form method="post" class="inline-form">
<input type="hidden" name="product_id" value="<?= (int)$p["id"] ?>">
<input type="hidden" name="action" value="add"><button>Add to Cart</button>
</form></div>
<?php endwhile; ?>
<h2>Your Cart</h2>
<?php if (!$cartRows): ?><p>Your cart is empty.</p><?php endif; ?>
<?php foreach ($cartRows as $item): ?>
<div class="product">
<strong><?= htmlspecialchars($item["name"]) ?></strong>
- ₹<?= number_format((float)$item["price"], 2) ?> each
<form method="post" class="inline-form">
<input type="hidden" name="product_id" value="<?= (int)$item["id"] ?>">
<input type="hidden" name="action" value="update">
<input type="number" name="quantity" min="1" max="99" value="<?= (int)$item["quantity"] ?>">
<button>Update</button>
</form>
<form method="post" class="inline-form">
<input type="hidden" name="product_id" value="<?= (int)$item["id"] ?>">
<input type="hidden" name="action" value="remove"><button>Remove</button>
</form>
Subtotal: ₹<?= number_format((float)$item["subtotal"], 2) ?>
</div>
<?php endforeach; ?>
<h3>Total: ₹<?= number_format($grandTotal, 2) ?></h3>
<?php if ($cartRows): ?><a href="19.php">Proceed to Checkout</a><?php endif; ?>
</div></body></html>
