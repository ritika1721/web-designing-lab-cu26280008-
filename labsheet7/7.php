<?php
include "db.php";

if(!isset($_SESSION['user_id'])) {
    die("Please login first. <a href='5.php'>Login</a>");
}

$message = "";

if(isset($_POST['checkout'])) {

    $address = trim($_POST['address']);
    $user_id = $_SESSION['user_id'];

    if(empty($address) || empty($_SESSION['cart'])) {
        $message = "Enter address and add books to cart.";
    } else {

        $conn->begin_transaction();

        try {

            $total = 0;
            $items = [];

            foreach($_SESSION['cart'] as $id => $qty) {

                $stmt = $conn->prepare(
                    "SELECT price, stock FROM books WHERE id=? FOR UPDATE"
                );

                $stmt->bind_param("i", $id);
                $stmt->execute();

                $book = $stmt->get_result()->fetch_assoc();

                if(!$book || $qty > $book['stock']) {
                    throw new Exception("Book stock is not available.");
                }

                $total += $book['price'] * $qty;

                $items[] = [
                    'id' => $id,
                    'qty' => $qty,
                    'price' => $book['price']
                ];
            }

            $stmt = $conn->prepare(
                "INSERT INTO orders(user_id,total_amount,shipping_address)
                 VALUES(?,?,?)"
            );

            $stmt->bind_param("ids", $user_id, $total, $address);
            $stmt->execute();

            $order_id = $conn->insert_id;

            foreach($items as $item) {

                $stmt = $conn->prepare(
                    "INSERT INTO order_items(order_id,book_id,quantity,price)
                     VALUES(?,?,?,?)"
                );

                $stmt->bind_param(
                    "iiid",
                    $order_id,
                    $item['id'],
                    $item['qty'],
                    $item['price']
                );

                $stmt->execute();

                $stmt = $conn->prepare(
                    "UPDATE books SET stock=stock-? WHERE id=?"
                );

                $stmt->bind_param("ii", $item['qty'], $item['id']);
                $stmt->execute();
            }

            $conn->commit();

            $_SESSION['cart'] = [];

            header("Location: 16.php?id=" . $order_id);
            exit;

        } catch(Exception $e) {

            $conn->rollback();
            $message = $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h1>Checkout Page</h1>

<form method="POST">

    <label>Shipping Address</label>

    <textarea name="address" required></textarea>

    <button type="submit" name="checkout">
        Place Order
    </button>

</form>

<p><?php echo htmlspecialchars($message); ?></p>

</div>

</body>
</html>