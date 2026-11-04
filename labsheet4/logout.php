<?php
session_start();
session_unset();
session_destroy();

echo "You have been logged out successfully.";
echo '<br><a href="login.php">Login Again</a>';
?>