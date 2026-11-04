<?php
require 'connect.php';

$sql = "CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    enrollment_date DATE NOT NULL
)";

$conn->exec($sql);

echo "Students table created successfully!";
?>