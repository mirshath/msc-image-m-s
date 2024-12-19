<?php
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'patient') {
    header("Location: login.php");
    exit();
}

// Include database and ImageManager class
require_once '../../config/db.php';
require_once '../../src/Images.php';

// Initialize ImageManager with the database connection
$imageManager = new ImageManager($pdo);

// Fetch image details from the database based on the image ID
$imageId = $_GET['id'];
$image = $imageManager->getImageById($imageId);

// Ensure the image exists and belongs to the current patient
if (!$image || $image['patient_id'] !== $_SESSION['user']['id']) {
    echo "Image not found or unauthorized access.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Image</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 15px;
            overflow: hidden;
        }

        .card img {
            border-bottom: 1px solid #ddd;
        }

        .card-title {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .btn {
            font-size: 1rem;
            padding: 10px 20px;
        }
    </style>
</head>

<body>
    <?php require_once("./patient_nav.php") ?>
    <div class="container mt-5">
        <h1 class="text-center mb-4 text-primary">View Test Image</h1>
        <div class="row justify-content-center align-items-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-6">
                            <img src="https://msc-project-healthcare-system.s3.eu-north-1.amazonaws.com/<?php echo htmlspecialchars($image['s3_key']); ?>"
                                alt="Test Image" class="img-fluid w-100" style="object-fit: cover;">
                        </div>
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="card-body">
                                <h3 class="card-title text-primary">Image Details</h3>
                                <p class="text-muted mb-2"><strong>Type:</strong> <?= htmlspecialchars($image['type']) ?></p>
                                <p class="text-muted"><strong>Uploaded On:</strong> <?= htmlspecialchars($image['uploaded_at']) ?></p>
                                <a href="view_images.php" class="btn btn-secondary btn-lg mt-3">Back to Your Images</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
