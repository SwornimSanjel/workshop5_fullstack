<?php
require_once "../includes/header.php";

function uploadPortfolioFile($file) {
    $allowedTypes = ["application/pdf", "image/jpeg", "image/png"];
    $maxSize = 2 * 1024 * 1024;

    if ($file["error"] !== 0) {
        throw new Exception("File upload error.");
    }

    if (!in_array($file["type"], $allowedTypes)) {
        throw new Exception("Invalid file type. Only PDF, JPG, PNG allowed.");
    }

    if ($file["size"] > $maxSize) {
        throw new Exception("File size exceeds 2MB.");
    }

    // FIXED PATH (matches your folder name)
    $uploadDir = "../upload/";

    if (!is_dir($uploadDir)) {
        throw new Exception("Upload directory not found.");
    }

    $newName = time() . "_" . basename($file["name"]);
    $destination = $uploadDir . $newName;

    if (!move_uploaded_file($file["tmp_name"], $destination)) {
        throw new Exception("Upload failed.");
    }

    return "File uploaded successfully";
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $message = uploadPortfolioFile($_FILES["portfolio"]);
    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}
?>

<form method="post" enctype="multipart/form-data">
    Upload Portfolio:
    <input type="file" name="portfolio" required>
    <br><br>
    <button type="submit">Upload</button>
</form>

<p><?php echo $message; ?></p>

<?php require_once "../includes/footer.php"; ?>
