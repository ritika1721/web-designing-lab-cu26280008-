<?php
// LAB SHEET 9 - QUESTION 3: User registration
require_once "2.php";
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($name === "" || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
        $message = "Enter a name, valid email and password of at least 6 characters.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hash);

        if ($stmt->execute()) {
            $message = "Registration completed. You can now log in.";
        } else {
            $message = "This email may already be registered.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Register</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="container">
    <h2>Create Account</h2>
    <p><?= htmlspecialchars($message) ?></p>
    <form method="post">
        <label>Name</label><input type="text" name="name" required>
        <label>Email</label><input type="email" name="email" required>
        <label>Password (minimum 6 characters)</label><input type="password" name="password" minlength="6" required>
        <button type="submit">Register</button>
    </form>
    <p><a href="4.php">Go to Login</a></p>
</div>
</body>
</html>
