<?php
require_once '../src/ImageManager.php'; // Adjust the path if necessary

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $bucket = 'msc-project-healthcare-system'; // Replace with your S3 bucket name
    $filePath = $_FILES['image']['tmp_name'];  // Temporary file path on the server
    $key = 'uploads/' . basename($_FILES['image']['name']); // S3 key (name) for the file

    // Instantiate the ImageManager class
    $imageManager = new ImageManager();

    // Upload the image to S3
    $result = $imageManager->uploadToS3($bucket, $filePath, $key);

    // Handle success or failure
    if ($result) {
        echo "Image uploaded successfully!";
    } else {
        echo "Image upload failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
</head>
<body>
    <h1>Upload Image</h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="image">Choose an image to upload:</label><br>
        <input type="file" name="image" required><br><br>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
