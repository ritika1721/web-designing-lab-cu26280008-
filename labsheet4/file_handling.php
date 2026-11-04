<?php
$filename = "myfile.txt";

// Write data to the file
$file = fopen($filename, "w");

fwrite($file, "Hello Lavisha!\n");
fwrite($file, "Welcome to PHP File Handling.");

fclose($file);

echo "Data written successfully!<br>";

// Read data from the file
$file = fopen($filename, "r");

$content = fread($file, filesize($filename));

fclose($file);

echo "<br>File Content:<br>";
echo nl2br(htmlspecialchars($content));
?>