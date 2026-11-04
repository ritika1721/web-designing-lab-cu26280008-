<?php
try {
    $age = 15;

    if ($age < 18) {
        throw new Exception("You are not eligible to vote.");
    }

    echo "You are eligible to vote.";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>