<?php
include "db.php";

$sql = "SELECT * FROM books WHERE stock > 0";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Available Books</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Available Books</h1>
</header>

<div class="container">

    <div class="books">

        <?php while($row = $result->fetch_assoc()) { ?>

        <div class="card">

            <img src="<?php echo htmlspecialchars($row['image']); ?>">

            <h3>
                <?php echo htmlspecialchars($row['title']); ?>
            </h3>

            <p>Author:
                <?php echo htmlspecialchars($row['author']); ?>
            </p>

            <p>Price: ₹<?php echo $row['price']; ?></p>

            <p>Stock: <?php echo $row['stock']; ?></p>

            <a href="4.php?id=<?php echo $row['id']; ?>">
                View Details
            </a>

        </div>

        <?php } ?>

    </div>

</div>

</body>
</html>