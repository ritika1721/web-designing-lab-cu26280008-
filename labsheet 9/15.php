<?php
// LAB SHEET 9 - QUESTION 15: SQL injection protection
require_once "2.php";

// UNSAFE EXAMPLE (do not use): $sql = "SELECT * FROM users WHERE email = '$email'";
// A value such as ' OR '1'='1 could change the meaning of that query.

// SAFE VERSION: prepared statement keeps user input separate from SQL code.
$email = trim($_GET["email"] ?? "");
$message = "";

if ($email !== "") {
    $stmt = $conn->prepare("SELECT id, name, email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $message = $user ? "Matching account found: " . $user["name"] : "No matching account.";
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head><title>SQL Injection Protection</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
<h2>SQL Injection Protection</h2>
<p>Try entering an email address. The value is passed using a prepared statement.</p>
<form method="get"><label>Email</label><input type="text" name="email" value="<?= htmlspecialchars($email) ?>">
<button type="submit">Check</button></form>
<p><?= htmlspecialchars($message) ?></p>
</div></body></html>
