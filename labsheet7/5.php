<?php
include "db.php";

$message = "";

if(isset($_POST['register'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare(
        "INSERT INTO users(name,email,password) VALUES(?,?,?)"
    );

    $stmt->bind_param("sss", $name, $email, $password);

    if($stmt->execute()) {
        $message = "Registration Successful!";
    } else {
        $message = "Email already registered!";
    }
}

if(isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $user = $stmt->get_result()->fetch_assoc();

    if($user && password_verify($password, $user['password'])) {

        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];

        $message = "Login Successful!";
    } else {
        $message = "Invalid Email or Password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register and Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h2>User Registration</h2>

<form method="POST">
    <input type="text" name="name" placeholder="Enter Name" required>
    <input type="email" name="email" placeholder="Enter Email" required>
    <input type="password" name="password" placeholder="Password" required>

    <button type="submit" name="register">Register</button>
</form>

<hr>

<h2>User Login</h2>

<form method="POST">
    <input type="email" name="email" placeholder="Enter Email" required>
    <input type="password" name="password" placeholder="Password" required>

    <button type="submit" name="login">Login</button>
</form>

<p><?php echo htmlspecialchars($message); ?></p>

</div>

</body>
</html>