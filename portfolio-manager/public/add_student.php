<?php
require_once "../includes/header.php";

function formatName($name) {
    return ucwords(trim($name));
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function cleanSkills($string) {
    $skills = explode(",", $string);
    return array_map("trim", $skills);
}


function saveStudent($name, $email, $skillsArray) {
    $line = $name . "|" . $email . "|" . implode(",", $skillsArray) . PHP_EOL;
    file_put_contents("../data/students.txt", $line, FILE_APPEND);
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $name = formatName($_POST["name"]);
        $email = $_POST["email"];
        $skills = cleanSkills($_POST["skills"]);

        if (!$name || !validateEmail($email) || empty($skills)) {
            throw new Exception("Invalid input data.");
        }

        saveStudent($name, $email, $skills);
        $success = "Student saved successfully.";

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<form method="post">
    Name: <input type="text" name="name" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    Skills (comma separated): <input type="text" name="skills" required><br><br>
    <button type="submit">Save</button>
</form>

<p style="color:red;"><?php echo $error; ?></p>
<p style="color:green;"><?php echo $success; ?></p>

<?php require_once "../includes/footer.php"; ?>
