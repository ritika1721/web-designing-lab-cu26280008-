<?php
include "db.php";

// Get user input
$search = trim($_GET['search'] ?? '');

// Prepare SQL statement
$stmt = $conn->prepare(
    "SELECT * FROM books WHERE title LIKE ?"
);

// Add search value
$value = "%" . $search . "%";

$stmt->bind_param("s", $value);

// Execute query
$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Secure Book Search</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h1>Secure Book Search</h1>

<form method="GET">

    <input type="text" name="search"
    placeholder="Enter Book Name">

    <button type="submit">Search</button>

</form>

<?php while($row = $result->fetch_assoc()) { ?>

    <div class="card">

        <h3>
            <?php echo htmlspecialchars($row['title']); ?>
        </h3>

        <p>
            <?php echo htmlspecialchars($row['author']); ?>
        </p>

        <p>Price: ₹<?php echo $row['price']; ?></p>

    </div>

<?php } ?>

</div>

</body>
</html>