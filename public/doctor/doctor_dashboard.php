<?php
session_start();

// Check if the user is logged in and if they have the correct role
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'doctor') {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['user']['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
   
<?php require_once "./doctor_nav.php" ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-12 text-center">
                <h1>Welcome, <?php echo htmlspecialchars($name); ?>!</h1>
                <p class="lead">This is your Doctor Dashboard. Use the options below to navigate.</p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">View Patients</h5>
                        <p class="card-text">Access patient records and details.</p>
                        <a href="view_patients.php" class="btn btn-success">Go</a>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Recommend Tests</h5>
                        <p class="card-text">Prescribe diagnostic tests for patients.</p>
                        <a href="recommend_tests.php" class="btn btn-success">Go</a>
                    </div>
                </div>
            </div> -->
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">View Test Images</h5>
                        <p class="card-text">Review uploaded test images.</p>
                        <a href="view_images.php" class="btn btn-success">Go</a>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Recommend Medications</h5>
                        <p class="card-text">Suggest medications for patients.</p>
                        <a href="recommend_medications.php" class="btn btn-success">Go</a>
                    </div>
                </div>
            </div> -->
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Success Appointed </h5>
                        <p class="card-text">Suggest medications for patients.</p>
                        <a href="success_appoinment.php" class="btn btn-success">Go</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
