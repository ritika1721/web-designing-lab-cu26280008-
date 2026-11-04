<?php
include "db.php";

$message = "";

if(isset($_POST['add'])) {

    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $category = trim($_POST['category']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $image = trim($_POST['image']);

    $stmt = $conn->prepare(
        "INSERT INTO books(title,author,category,price,stock,image)
         VALUES(?,?,?,?,?,?)"
    );

    $stmt->bind_param(
        "sssdis",
        $title, $author, $category, $price, $stock, $image
    );

    $stmt->execute();

    $message = "Book Added Successfully!";
}

if(isset($_POST['update'])) {

    $id = intval($_POST['id']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);

    $stmt = $conn->prepare(
        "UPDATE books SET price=?, stock=? WHERE id=?"
    );

    $stmt->bind_param("dii", $price, $stock, $id);
    $stmt->execute();

    $message = "Book Updated Successfully!";
}

$books = $conn->query("SELECT * FROM books");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h1>Admin Dashboard</h1>

<h2>Add New Book</h2>

<form method="POST">

    <input type="text" name="title" placeholder="Book Title" required>

    <input type="text" name="author" placeholder="Author" required>

    <input type="text" name="category" placeholder="Category" required>

    <input type="number" step="0.01" name="price" placeholder="Price" required>

    <input type="number" name="stock" placeholder="Stock" required>

    <input type="text" name="image" placeholder="Image Name">

    <button name="add">Add Book</button>

</form>

<h2>Manage Books</h2>

<?php while($row = $books->fetch_assoc()) { ?>

<div class="card">

    <h3><?php echo htmlspecialchars($row['title']); ?></h3>

    <form method="POST">

        <input type="hidden" name="id"
        value="<?php echo $row['id']; ?>">

        <input type="number" step="0.01" name="price"
        value="<?php echo $row['price']; ?>">

        <input type="number" name="stock"
        value="<?php echo $row['stock']; ?>">

        <button name="update">Update</button>

    </form>

</div>

<?php } ?>

<p><?php echo htmlspecialchars($message); ?></p>

</div>

</body>
</html>