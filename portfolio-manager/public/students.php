<?php
require_once "../includes/header.php";

$file = "../data/students.txt";

if (file_exists($file)) {
    $lines = file($file);
    foreach ($lines as $line) {
        list($name, $email, $skills) = explode("|", trim($line));
        $skillsArray = explode(",", $skills);

        echo "<p>";
        echo "<strong>Name:</strong> $name<br>";
        echo "<strong>Email:</strong> $email<br>";
        echo "<strong>Skills:</strong> " . implode(", ", $skillsArray);
        echo "</p><hr>";
    }
} else {
    echo "No students found.";
}

require_once "../includes/footer.php";
