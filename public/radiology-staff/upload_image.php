<?php
session_start();
require_once '../../config/db.php';
require_once '../../src/ImageManager.php';
require_once '../../vendor/autoload.php'; // For AWS SDK

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['user'];

if ($user['role'] !== 'radiology_staff') {
    header('Location: ../../index.php'); // Unauthorized access
    exit();
}

// Fetch all patients from the database
$query = "SELECT id, name, email FROM users WHERE role = 'patient'";
$stmt = $pdo->query($query);
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $patientId = $_POST['patient_id'];
    $imageType = $_POST['image_type'];
    $imageFile = $_FILES['image'];

    $uploadDir = '../../uploads/';
    $fileName = uniqid("patient_{$patientId}_") . '.' . pathinfo($imageFile['name'], PATHINFO_EXTENSION);
    $uploadFile = $uploadDir . $fileName;

    // Allowed file types
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

    if (in_array($imageFile['type'], $allowedTypes)) {
        // Move the uploaded file to the temporary upload directory
        if (move_uploaded_file($imageFile['tmp_name'], $uploadFile)) {
            $imageManager = new ImageManager();

            // Define the S3 bucket key
            $s3Key = "uploads/$fileName";

            // Upload the image to S3
            if ($imageManager->uploadToS3('msc-project-healthcare-system', $uploadFile, $s3Key)) {
                // Insert details into the database
                $query = "INSERT INTO images_new (patient_id, s3_key, type) VALUES (:patient_id, :s3_key, :type)";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':patient_id', $patientId);
                $stmt->bindParam(':s3_key', $s3Key);
                $stmt->bindParam(':type', $imageType);

                if ($stmt->execute()) {
                    echo "Image uploaded successfully and details saved to the database.";
                } else {
                    echo "Image uploaded to S3, but failed to save details to the database.";
                }
            } else {
                echo "Failed to upload image to S3.";
            }
        } else {
            echo "Failed to move uploaded file to the temporary directory.";
        }
    } else {
        echo "Invalid file type. Allowed types: JPEG, PNG, GIF.";
    }
}
?>

<?php require_once "./radio_nav.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5 d-flex justify-content-center">
        <div class="card shadow-lg p-4" style="max-width: 600px; width: 100%;">
            <h1 class="text-center text-primary mb-4">Upload Image</h1>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="patient_id" class="form-label">Select Patient</label>
                    <select class="form-select" id="patient_id" name="patient_id" required>
                        <option value="">Select a Patient</option>
                        <?php foreach ($patients as $patient): ?>
                            <option value="<?php echo $patient['id']; ?>">
                                <?php echo htmlspecialchars($patient['name'] . " - " . $patient['email']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="image_type" class="form-label">Image Type</label>
                    <select class="form-select" id="image_type" name="image_type" required>
                        <option value="MRI">MRI</option>
                        <option value="CT">CT</option>
                        <option value="X-ray">X-ray</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Select Image to Upload</label>
                    <input type="file" class="form-control" id="image" name="image" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
