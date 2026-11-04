<?php
include "db.php";

$search = trim($_GET['search'] ?? '');
$category = trim($_GET['category'] ?? '');

$sql = "SELECT * FROM books WHERE stock > 0";
$params = [];
$types = "";

if($search != "") {

    $sql .= " AND (title LIKE ? OR author LIKE ?)";
    $value = "%".$search."%";

    $params[] = $value;
    $params[] = $value;

    $types .= "ss";
}

if($category != "") {

    $sql .= " AND category = ?";

    $params[] = $category;
    $types .= "s";
}

$stmt = $conn->prepare($sql);

if(count($params) > 0) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Books</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h1>Search Books</h1>

<form method="GET">

    <input type="text" name="search"
    placeholder="Search by title or author"
    value="<?php echo htmlspecialchars($search); ?>">

    <select name="category">

        <option value="">All Categories</option>
        <option value="Programming">Programming</option>
        <option value="Education">Education</option>
        <option value="Fiction">Fiction</option>

    </select>

    <button type="submit">Search</button>

</form>

<div class="books">

<?php while($row = $result->fetch_assoc()) { ?>

    <div class="card">

        <h3><?php echo htmlspecialchars($row['title']); ?></h3>

        <p>Author: <?php echo htmlspecialchars($row['author']); ?></p>

        <p>Price: ₹<?php echo $row['price']; ?></p>

        <a href="4.php?id=<?php echo $row['id']; ?>">
            View Details
        </a>

    </div>

<?php } ?>

</div>

</div>

</body>
</html>