<?php
include "db.php";

$id = intval($_GET['id'] ?? 0);

$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$book = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<?php if($book) { ?>

    <h1><?php echo htmlspecialchars($book['title']); ?></h1>

    <p>Author:
        <?php echo htmlspecialchars($book['author']); ?>
    </p>

    <p>Category:
        <?php echo htmlspecialchars($book['category']); ?>
    </p>

    <p>Price: ₹<?php echo $book['price']; ?></p>

    <p>Available Stock: <?php echo $book['stock']; ?></p>

    <img src="<?php echo htmlspecialchars($book['image']); ?>"
    width="200">

<?php } else { ?>

    <h2>Book Not Found</h2>

<?php } ?>

<br>
<a href="3.php">Back to Books</a>

</div>

</body>
</html>