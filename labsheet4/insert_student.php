<?php
require 'connect.php';

$sql = "INSERT INTO students (name, email, enrollment_date)
        VALUES (:name, :email, :enrollment_date)";

$stmt = $conn->prepare($sql);

$stmt->execute([
    ':name' => 'Lavisha',
    ':email' => 'lavisha@example.com',
    ':enrollment_date' => date('Y-m-d')
]);

echo "Student record inserted successfully!";
?>