<?php
include "db.php";

$message = "";

if(isset($_POST['add'])) {

    $id = intval($_POST['id']);
    $qty = intval($_POST['qty']);

    $stmt = $conn->prepare(
        "SELECT stock FROM books WHERE id = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $book = $stmt->get_result()->fetch_assoc();

    if($book) {

        if($qty > 0 && $qty <= $book['stock']) {

            if(!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $current = $_SESSION['cart'][$id] ?? 0;

            if($current + $qty <= $book['stock']) {

                $_SESSION['cart'][$id] = $current + $qty;

                $message = "Book added to cart successfully!";

            } else {

                $message = "Not enough stock available!";
            }

        } else {

            $message = "Invalid quantity or insufficient stock!";
        }

    } else {

        $message = "Book not found!";
    }
}

$result = $conn->query(
    "SELECT * FROM books WHERE stock > 0"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stock Check</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h1>Available Books</h1>

<p><?php echo htmlspecialchars($message); ?></p>

<?php while($row = $result->fetch_assoc()) { ?>

    <div class="card">

        <h3><?php echo htmlspecialchars($row['title']); ?></h3>

        <p>Available Stock: <?php echo $row['stock']; ?></p>

        <form method="POST">

            <input type="hidden" name="id"
            value="<?php echo $row['id']; ?>">

            <input type="number" name="qty"
            min="1" max="<?php echo $row['stock']; ?>"
            value="1" required>

            <button name="add">Add to Cart</button>

        </form>

    </div>

<?php } ?>

</div>

</body>
</html>