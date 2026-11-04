<?php
include "db.php";

if(!isset($_SESSION['user_id'])) {
    die("Please login to give a review.");
}

$book_id = intval($_GET['id'] ?? 0);
$user_id = $_SESSION['user_id'];

$message = "";

if(isset($_POST['submit'])) {

    $rating = intval($_POST['rating']);
    $comment = trim($_POST['comment']);

    if($rating >= 1 && $rating <= 5 && $comment != "") {

        $stmt = $conn->prepare(
            "INSERT INTO reviews(user_id,book_id,rating,comment)
             VALUES(?,?,?,?)"
        );

        $stmt->bind_param(
            "iiis",
            $user_id,
            $book_id,
            $rating,
            $comment
        );

        $stmt->execute();

        $message = "Review Submitted Successfully!";

    } else {
        $message = "Please enter a valid rating and comment.";
    }
}

$stmt = $conn->prepare(
    "SELECT * FROM reviews WHERE book_id = ?"
);

$stmt->bind_param("i", $book_id);
$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Reviews</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h1>Book Reviews</h1>

<form method="POST">

    <label>Rating</label>

    <select name="rating" required>
        <option value="">Select Rating</option>
        <option value="1">1 Star</option>
        <option value="2">2 Stars</option>
        <option value="3">3 Stars</option>
        <option value="4">4 Stars</option>
        <option value="5">5 Stars</option>
    </select>

    <textarea name="comment"
    placeholder="Write your review" required></textarea>

    <button name="submit">Submit Review</button>

</form>

<p><?php echo htmlspecialchars($message); ?></p>

<h2>Customer Reviews</h2>

<?php while($row = $result->fetch_assoc()) { ?>

    <div class="card">

        <h3>Rating: <?php echo $row['rating']; ?>/5</h3>

        <p><?php echo htmlspecialchars($row['comment']); ?></p>

    </div>

<?php } ?>

</div>

</body>
</html>