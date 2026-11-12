<?php
// LAB SHEET 9 - QUESTION 16: Prevent Cross-Site Scripting (XSS)
function safeOutput($value) {
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}
$comment = $_POST["comment"] ?? "";
?>
<!DOCTYPE html>
<html>
<head><title>XSS Protection</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
<h2>XSS Protection</h2>
<form method="post">
<label>Write a comment</label>
<textarea name="comment" rows="4"><?= safeOutput($comment) ?></textarea>
<button type="submit">Show Comment</button>
</form>
<?php if ($comment !== ""): ?>
<h3>Your comment</h3><p><?= safeOutput($comment) ?></p>
<?php endif; ?>
<p>User input is escaped before it is displayed on the page.</p>
</div></body></html>
