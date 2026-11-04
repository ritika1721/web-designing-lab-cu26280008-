<?php
session_start();

if (isset($_SESSION["username"])) {
    echo "<h2>Welcome, ";
    echo htmlspecialchars($_SESSION["username"]);
    echo "!</h2>";
    echo "<p>You are logged in successfully.</p>";
    echo '<a href="logout.php">Logout</a>';
} else {
    echo "Please login first.";
    echo '<br><a href="login.php">Go to Login</a>';
}
?>S