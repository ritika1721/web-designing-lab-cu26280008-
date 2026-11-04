<?php
include "db.php";

if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if(isset($_GET['add'])) {

    $id = intval($_GET['add']);

    $stmt = $conn->prepare("SELECT stock FROM books WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $book = $stmt->get_result()->fetch_assoc();

    if($book && $book['stock'] > 0) {

        $quantity = $_SESSION['cart'][$id] ?? 0;

        if($quantity < $book['stock']) {
            $_SESSION['cart'][$id] = $quantity + 1;
        }
    }

    header("Location: 6.php");
    exit;
}

if(isset($_POST['update'])) {

    foreach($_POST['qty'] as $id => $qty) {

        $id = intval($id);
        $qty = max(1, intval($qty));

        $stmt = $conn->prepare("SELECT stock FROM books WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $book = $stmt->get_result()->fetch_assoc();

        if($book) {
            $_SESSION['cart'][$id] = min($qty, $book['stock']);
        }
    }
}

if(isset($_GET['remove'])) {
    unset($_SESSION['cart'][intval($_GET['remove'])]);
}

$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h1>My Shopping Cart</h1>

<form method="POST">

<?php foreach($_SESSION['cart'] as $id => $qty) {

    $stmt = $conn->prepare("SELECT * FROM books WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $book = $stmt->get_result()->fetch_assoc();

    if(!$book) continue;

    $subtotal = $book['price'] * $qty;
    $total += $subtotal;
?>

<div class="card">

    <h3><?php echo htmlspecialchars($book['title']); ?></h3>

    <p>Price: ₹<?php echo $book['price']; ?></p>

    <input type="number"
           name="qty[<?php echo $id; ?>]"
           value="<?php echo $qty; ?>"
           min="1"
           max="<?php echo $book['stock']; ?>">

    <p>Subtotal: ₹<?php echo $subtotal; ?></p>

    <a href="6.php?remove=<?php echo $id; ?>">Remove</a>

</div>

<?php } ?>

<h3>Total Amount: ₹<?php echo $total; ?></h3>

<button type="submit" name="update">Update Cart</button>

</form>

<a href="3.php">Continue Shopping</a>
<br><br>
<a href="7.php">Proceed to Checkout</a>

</div>

</body>
</html>