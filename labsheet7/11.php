<?php
include "db.php";

$limit = 4;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

if($page < 1) {
    $page = 1;
}

$start = ($page - 1) * $limit;

$total = $conn->query(
    "SELECT COUNT(*) AS total FROM books"
)->fetch_assoc()['total'];

$totalPages = ceil($total / $limit);

$stmt = $conn->prepare(
    "SELECT * FROM books LIMIT ?, ?"
);

$stmt->bind_param("ii", $start, $limit);
$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Pagination</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h1>Books List</h1>

<div class="books">

<?php while($row = $result->fetch_assoc()) { ?>

    <div class="card">

        <h3><?php echo htmlspecialchars($row['title']); ?></h3>

        <p>Author: <?php echo htmlspecialchars($row['author']); ?></p>

        <p>Price: ₹<?php echo $row['price']; ?></p>

    </div>

<?php } ?>

</div>

<h3>Pages</h3>

<?php for($i = 1; $i <= $totalPages; $i++) { ?>

    <a href="11.php?page=<?php echo $i; ?>">
        <?php echo $i; ?>
    </a>

    &nbsp;

<?php } ?>

</div>

</body>
</html>