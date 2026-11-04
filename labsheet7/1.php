<!DOCTYPE html>
<html>
<head>
    <title>Online Bookstore</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Online Bookstore</h1>
    <p>Find Your Favourite Books Here</p>
</header>

<nav>
    <a href="1.php">Home</a>
    <a href="3.php">Books</a>
    <a href="5.php">Login</a>
    <a href="6.php">Cart</a>
</nav>

<div class="container">

    <h2>Search Books</h2>

    <form action="10.php" method="GET">
        <input type="text" name="search"
        placeholder="Search books...">

        <button type="submit">Search</button>
    </form>

    <h2>Categories</h2>

    <p>Programming | Fiction | Science | History</p>

    <h2>Featured Books</h2>

    <div class="books">

        <div class="card">
            <img src="https://picsum.photos/200/200?1">
            <h3>Python Programming</h3>
            <p>Price: ₹400</p>
        </div>

        <div class="card">
            <img src="https://picsum.photos/200/200?2">
            <h3>Web Development</h3>
            <p>Price: ₹500</p>
        </div>

        <div class="card">
            <img src="https://picsum.photos/200/200?3">
            <h3>Database Systems</h3>
            <p>Price: ₹350</p>
        </div>

    </div>

    <h2>Special Offer</h2>

    <h3>Get 20% Discount on Selected Books!</h3>

</div>

<footer>
    <p>© 2026 Online Bookstore</p>
</footer>

</body>
</html>