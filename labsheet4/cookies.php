<?php
// Create a cookie
setcookie("username", "Lavisha", time() + 3600, "/");

echo "Cookie created successfully!";

// Access cookie after browser receives it
if (isset($_COOKIE["username"])) {
    echo "<br>Username: " . $_COOKIE["username"];
} else {
    echo "<br>Refresh the page to access the cookie.";
}

// Delete cookie
if (isset($_GET["delete"])) {
    setcookie("username", "", time() - 3600, "/");
    echo "<br>Cookie deleted successfully!";
}
?>

<br>
<a href="?delete=1">Delete Cookie</a>