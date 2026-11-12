<?php
// LAB SHEET 9 - QUESTION 14: Upload a product image safely
require_once "2.php";
$message = "";
$uploadDir = __DIR__ . "/uploads/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["photo"])) {
    $productId = filter_input(INPUT_POST, "product_id", FILTER_VALIDATE_INT);
    $file = $_FILES["photo"];

    if (!$productId || $file["error"] !== UPLOAD_ERR_OK) {
        $message = "Select a product and a valid image.";
    } elseif ($file["size"] > 2 * 1024 * 1024) {
        $message = "Image size must be 2 MB or less.";
    } else {
        $imageInfo = getimagesize($file["tmp_name"]);
        $allowedTypes = ["image/jpeg" => "jpg", "image/png" => "png", "image/webp" => "webp"];
        $mime = $imageInfo["mime"] ?? "";

        if (!$imageInfo || !isset($allowedTypes[$mime])) {
            $message = "Only JPG, PNG and WEBP images are allowed.";
        } else {
            $fileName = bin2hex(random_bytes(12)) . "." . $allowedTypes[$mime];
            $destination = $uploadDir . $fileName;

            if (move_uploaded_file($file["tmp_name"], $destination)) {
                $relativePath = "uploads/" . $fileName;
                $stmt = $conn->prepare("UPDATE products SET photo = ? WHERE id = ?");
                $stmt->bind_param("si", $relativePath, $productId);
                $stmt->execute();
                $message = $stmt->affected_rows >= 0 ? "Image uploaded." : "Could not update product.";
                $stmt->close();
            } else {
                $message = "Upload failed.";
            }
        }
    }
}
$products = $conn->query("SELECT id, name FROM products ORDER BY name");
?>
<!DOCTYPE html>
<html>
<head><title>Product Image Upload</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
<h2>Upload Product Photo</h2><p><?= htmlspecialchars($message) ?></p>
<form method="post" enctype="multipart/form-data">
<label>Select Product</label><select name="product_id" required>
<option value="">Choose product</option>
<?php while ($p = $products->fetch_assoc()): ?>
<option value="<?= (int)$p["id"] ?>"><?= htmlspecialchars($p["name"]) ?></option>
<?php endwhile; ?>
</select>
<label>Choose Image (JPG, PNG or WEBP, max 2 MB)</label>
<input type="file" name="photo" accept=".jpg,.jpeg,.png,.webp" required>
<button type="submit">Upload</button>
</form>
</div></body></html>
