<?php
include "db.php";

if(!isset($_SESSION['user_id'])) {
    die("Please login first.");
}

$user_id = $_SESSION['user_id'];

if(isset($_GET['add'])) {

    $book_id = intval($_GET['add']);

    $stmt = $conn->prepare(
        "INSERT IGNORE INTO wishlist(user_id,book_id)
         VALUES(?,?)"
    );

    $stmt->bind_param("ii", $user_id, $book_id);
    $stmt->execute();
}

if(isset($_GET['remove'])) {

    $id = intval($_GET['remove']);

    $stmt = $conn->prepare(
        "DELETE FROM wishlist WHERE id=? AND user_id=?"
    );

    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
}

$result = $conn->prepare(
    "SELECT wishlist.id, books.title, books.price
     FROM wishlist
     JOIN books ON wishlist.book_id=books.id
     WHERE wishlist.user_id=?"
);

$result->bind_param("i", $user_id);
$result->execute();

$books = $result->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Wishlist</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h1>My Wishlist</h1>

<?php while($row = $books->fetch_assoc()) { ?>

    <div class="card">

        <h3><?php echo htmlspecialchars($row['title']); ?></h3>

        <p>Price: ₹<?php echo $row['price']; ?></p>

        <a href="17.php?remove=<?php echo $row['id']; ?>">
            Remove from Wishlist
        </a>

    </div>

<?php } ?>

<h2>Add Books to Wishlist</h2>

<?php
$allBooks = $conn->query("SELECT * FROM books");
?>

<?php while($book = $allBooks->fetch_assoc()) { ?>

    <p>
        <?php echo htmlspecialchars($book['title']); ?>

        <a href="17.php?add=<?php echo $book['id']; ?>">
            Add to Wishlist
        </a>
    </p>

<?php } ?>

</div>

</body>
</html>