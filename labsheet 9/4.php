<?php
// LAB SHEET 9 - QUESTION 4: Login with password_verify() and session_start()
session_start();
require_once "2.php";
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        session_regenerate_id(true);
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["name"];
        header("Location: 5.php");
        exit;
    } else {
        $message = "Email or password is incorrect.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head><title>Login</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="container">
    <h2>Login</h2>
    <p><?= htmlspecialchars($message) ?></p>
    <form method="post">
        <label>Email</label><input type="email" name="email" required>
        <label>Password</label><input type="password" name="password" required>
        <button type="submit">Login</button>
    </form>
    <p><a href="3.php">Create an account</a></p>
</div>
</body>
</html>
