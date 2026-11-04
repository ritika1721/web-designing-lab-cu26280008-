<?php
require 'connect.php';

$sql = "SELECT * FROM students";
$stmt = $conn->query($sql);

echo "<h2>Students Records</h2>";

echo "<table border='1' cellpadding='8'>";
echo "<tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Enrollment Date</th>
      </tr>";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
    echo "<td>" . htmlspecialchars($row['enrollment_date']) . "</td>";
    echo "</tr>";
}

echo "</table>";
?>