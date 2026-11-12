<?php
// LAB SHEET 9 - QUESTION 20: Live product search using JavaScript fetch (AJAX)
require_once "2.php";

if (isset($_GET["suggest"])) {
    header("Content-Type: application/json; charset=UTF-8");
    $term = trim($_GET["suggest"]);
    $like = "%" . $term . "%";
    $stmt = $conn->prepare("SELECT id, name, category, price FROM products WHERE name LIKE ? OR category LIKE ? ORDER BY name LIMIT 8");
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    echo json_encode($items);
    $stmt->close();
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Live Product Search</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
<h2>Live Product Search</h2>
<label>Enter product name or category</label>
<input type="text" id="searchBox" placeholder="Start typing...">
<div id="suggestions"></div>
</div>
<script>
const searchBox = document.getElementById("searchBox");
const suggestions = document.getElementById("suggestions");

searchBox.addEventListener("input", async function () {
    const term = this.value.trim();
    suggestions.innerHTML = "";

    if (term.length < 1) return;

    try {
        const response = await fetch("20.php?suggest=" + encodeURIComponent(term));
        const products = await response.json();

        if (products.length === 0) {
            suggestions.textContent = "No products found.";
            return;
        }

        products.forEach(product => {
            const item = document.createElement("p");
            item.textContent = product.name + " (" + product.category + ") - Rs. " + product.price;
            suggestions.appendChild(item);
        });
    } catch (error) {
        suggestions.textContent = "Search is not available right now.";
    }
});
</script>
</body></html>
