<?php
// LAB SHEET 9 - QUESTION 2
// Common database connection file. Include it on other PHP pages.

$host = "localhost";
$username = "root";
$password = ""; // Add your MySQL password here if you have one.
$database = "webapp_db";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed. Please check MySQL settings.");
}

$conn->set_charset("utf8mb4");
?>
