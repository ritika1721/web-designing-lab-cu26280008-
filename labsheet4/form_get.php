<!DOCTYPE html>
<html>
<body>

<h2>GET Method Form</h2>

<form method="GET" action="">
    Enter Name:
    <input type="text" name="username" required>
    <input type="submit" value="Submit">
</form>

<?php
if (isset($_GET["username"])) {
    echo "<h3>Hello, " .
         htmlspecialchars($_GET["username"]) .
         "!</h3>";
}
?>

</body>
</html>