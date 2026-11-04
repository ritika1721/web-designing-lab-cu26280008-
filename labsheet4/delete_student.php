<?php
require 'connect.php';

$sql = "DELETE FROM students WHERE id = :id";
$stmt = $conn->prepare($sql);

$stmt->execute([
    ':id' => 1
]);

if ($stmt->rowCount() > 0) {
    echo "Student record deleted successfully!";
} else {
    echo "No student record found with this ID.";
}
?>