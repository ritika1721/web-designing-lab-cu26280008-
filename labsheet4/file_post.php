<!DOCTYPE html>
<html>
<body>

<h2>POST Method Form</h2>

<form method="POST" action="">
    Enter Name:
    <input type="text" name="username" required>
    <input type="submit" value="Submit">
</form>

<?php
if (isset($_POST["username"])) {
    echo "<h3>Hello, " .
         htmlspecialchars($_POST["username"]) .
         "!</h3>";
}
?>

</body>
</html>