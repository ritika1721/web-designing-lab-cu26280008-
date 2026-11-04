<!DOCTYPE html>
<html>
<head>
    <title>Form Validation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h1>Registration Form</h1>

<form onsubmit="return validateForm()">

    <input type="text" id="name" placeholder="Enter Name">

    <input type="email" id="email" placeholder="Enter Email">

    <input type="password" id="password"
    placeholder="Enter Password">

    <input type="text" id="address"
    placeholder="Enter Address">

    <button type="submit">Submit</button>

</form>

<p id="message"></p>

</div>

<script src="script.js"></script>

<script>

function validateForm() {

    let name = document.getElementById("name").value.trim();

    let email = document.getElementById("email").value.trim();

    let password = document.getElementById("password").value;

    let address = document.getElementById("address").value.trim();

    let message = document.getElementById("message");

    if(name == "" || email == "" ||
       password == "" || address == "") {

        message.innerHTML = "All fields are required.";
        message.style.color = "red";

        return false;
    }

    if(!email.includes("@") || !email.includes(".")) {

        message.innerHTML = "Enter valid email.";
        message.style.color = "red";

        return false;
    }

    if(password.length < 6) {

        message.innerHTML = "Password must be at least 6 characters.";
        message.style.color = "red";

        return false;
    }

    message.innerHTML = "Form submitted successfully!";
    message.style.color = "green";

    return false;
}

</script>

</body>
</html>