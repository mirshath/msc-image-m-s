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

// Fetch images related to the logged-in patient
$patientId = $_SESSION['user']['id'];
$images = $imageManager->getImagesByPatientId($patientId);

// Check if an image ID is passed for viewing
$imageData = null;
if (isset($_GET['id'])) {
    $imageId = $_GET['id'];
    $imageData = $imageManager->getImageById($imageId);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Test Images</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <style>
        .img-preview {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-top: 20px;
        }

        .card-custom {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card-custom:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <?php require_once("./patient_nav.php") ?>

    <div class="container mt-5">
        <h1 class="mb-4 text-center">Your Test Images</h1>

        <?php if (empty($images)): ?>
            <div class="alert alert-warning text-center">No images found.</div>
        <?php else: ?>
            <div class="row g-3">
                <?php foreach ($images as $image): ?>
                    <div class="col-md-4">
                        <div class=" card-custom shadow-sm">
                            <img src="https://msc-project-healthcare-system.s3.eu-north-1.amazonaws.com/<?= htmlspecialchars($image['s3_key']) ?>"
                                alt="Medical Image" class="card-img-top img-preview">
                            <div class="card-body">
                                <h5 class="card-title text-primary">
                                    <?= htmlspecialchars($image['type']) ?>
                                </h5>
                                <p class="card-text text-muted">
                                    <small>Uploaded At: <?= htmlspecialchars($image['uploaded_at']) ?></small>
                                </p>
                                <a href="view_image.php?id=<?= htmlspecialchars($image['id']) ?>"
                                    class="btn btn-primary btn-sm w-100">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($imageData): ?>
            <div class="mt-5">
                <h2>Image Details</h2>
                <p><strong>Image Type:</strong> <?= htmlspecialchars($imageData['type']) ?></p>
                <p><strong>Uploaded At:</strong> <?= htmlspecialchars($imageData['uploaded_at']) ?></p>
                <h3 class="mt-3">Image Preview</h3>
                <img src="https://msc-project-healthcare-system.s3.eu-north-1.amazonaws.com/<?= htmlspecialchars($imageData['s3_key']) ?>"
                    alt="Medical Image" class="img-preview">
                <a href="patient_dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>