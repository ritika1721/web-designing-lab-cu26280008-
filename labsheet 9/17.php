<?php
// LAB SHEET 9 - QUESTION 17: Remember Me cookie and welcome message
session_start();
require_once "2.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        session_regenerate_id(true);
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["name"];

        if (isset($_POST["remember"])) {
            // Store only the email for convenience, never the password.
            setcookie("remember_email", $email, [
                "expires" => time() + (30 * 24 * 60 * 60),
                "path" => "/",
                "httponly" => true,
                "samesite" => "Lax"
            ]);
        } else {
            setcookie("remember_email", "", time() - 3600, "/");
        }
    } else {
        $error = "Invalid login details.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head><title>Remember Me</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
<?php if (isset($_SESSION["user_id"])): ?>
<h2>Welcome back, <?= htmlspecialchars($_SESSION["user_name"]) ?>!</h2>
<p><a href="6.php">Logout</a></p>
<?php else: ?>
<h2>Login with Remember Me</h2>
<p><?= htmlspecialchars($error ?? "") ?></p>
<form method="post">
<label>Email</label><input type="email" name="email" value="<?= htmlspecialchars($_COOKIE["remember_email"] ?? "") ?>" required>
<label>Password</label><input type="password" name="password" required>
<label class="inline"><input type="checkbox" name="remember" value="1"> Remember Me</label>
<button type="submit">Login</button>
</form>
<?php endif; ?>
</div></body></html>
