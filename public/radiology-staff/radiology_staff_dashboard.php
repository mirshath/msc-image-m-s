<?php
session_start();

// Check if user is logged in and if the role is 'radiology_staff'
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'radiology_staff') {
    header("Location: login.php"); // Redirect to login page if not logged in or role doesn't match
    exit();
}

$name = $_SESSION['user']['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radiology Staff Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
   <?PHP require_once "./radio_nav.php" ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-12 text-center">
                <h1>Welcome, <?php echo htmlspecialchars($name); ?>!</h1>
                <p class="lead">This is your Radiology Staff Dashboard. Use the options below to navigate.</p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">View Images</h5>
                        <p class="card-text">Browse through uploaded medical images.</p>
                        <a href="view_images.php" class="btn btn-primary">Go</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">View Recommended Tests</h5>
                        <p class="card-text">Review tests recommended for patients.</p>
                        <a href="view_tests.php" class="btn btn-primary">Go</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Upload Image</h5>
                        <p class="card-text">Upload medical images for patient records.</p>
                        <a href="upload_image.php" class="btn btn-primary">Go</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">View Patients</h5>
                        <p class="card-text">patient records.</p>
                        <a href="view_patients.php" class="btn btn-primary">Go</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Fee Add</h5>
                        <p class="card-text">patient records.</p>
                        <a href="testFee.php" class="btn btn-primary">Go</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>