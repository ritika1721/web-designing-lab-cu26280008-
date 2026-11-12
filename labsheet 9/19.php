<?php
// LAB SHEET 9 - QUESTION 19: Save cart orders using a database transaction
session_start();
require_once "2.php";
$message = "";

if (!isset($_SESSION["user_id"])) {
    $message = "Please log in before checkout.";
} elseif (empty($_SESSION["cart"])) {
    $message = "Your shopping cart is empty.";
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = (int)$_SESSION["user_id"];
    $cart = $_SESSION["cart"];

    try {
        $conn->begin_transaction();

        $select = $conn->prepare("SELECT price FROM products WHERE id = ?");
        $insert = $conn->prepare("INSERT INTO orders (user_id, product_id, quantity, total_price) VALUES (?, ?, ?, ?)");

        foreach ($cart as $productId => $quantity) {
            $productId = (int)$productId;
            $quantity = max(1, (int)$quantity);

            $select->bind_param("i", $productId);
            $select->execute();
            $product = $select->get_result()->fetch_assoc();

            if (!$product) {
                throw new Exception("A product in the cart is no longer available.");
            }

            $total = (float)$product["price"] * $quantity;
            $insert->bind_param("iiid", $userId, $productId, $quantity, $total);
            $insert->execute();
        }

        $conn->commit();
        $_SESSION["cart"] = [];
        $message = "Order placed successfully!";
        $select->close();
        $insert->close();
    } catch (Throwable $e) {
        $conn->rollback();
        $message = "Checkout could not be completed. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Checkout</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
<h2>Checkout</h2>
<p><?= htmlspecialchars($message) ?></p>
<?php if (isset($_SESSION["user_id"]) && !empty($_SESSION["cart"])): ?>
<form method="post"><button type="submit">Confirm Order</button></form>
<?php endif; ?>
<p><a href="18.php">Back to Cart</a></p>
</div></body></html>
