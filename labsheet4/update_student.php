<?php
require 'connect.php';

$sql = "UPDATE students
        SET email = :email
        WHERE id = :id";

$stmt = $conn->prepare($sql);

$stmt->execute([
    ':email' => 'lavisha.updated@example.com',
    ':id' => 1
]);

if ($stmt->rowCount() > 0) {
    echo "Student record updated successfully!";
} else {
    echo "No record changed. Check the student ID or email.";
}
?>