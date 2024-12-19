<?php
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'patient') {
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
    <title>Patient Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require_once("./patient_nav.php") ?> 

    <div class="container mt-5">
        <div class="row">
            <div class="col-12 text-center">
                <h1>Welcome, <?php echo htmlspecialchars($name); ?>!</h1>
                <p class="lead">This is your Patient Dashboard. Use the options below to navigate.</p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-center" >
                    <div class="card-body">
                        <h5 class="card-title">Book Appointment</h5>
                        <p class="card-text">Schedule a new appointment with a doctor.</p>
                        <a href="book_appointment.php" class="btn btn-primary" >Go</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">View Appointments</h5>
                        <p class="card-text">View your upcoming appointments.</p>
                        <a href="view_appointments.php" class="btn btn-primary">Go</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">View Images</h5>
                        <p class="card-text">Access and view your medical images.</p>
                        <a href="view_images.php" class="btn btn-primary">Go</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">View Prescriptions</h5>
                        <p class="card-text">Review your prescribed medications.</p>
                        <a href="view_prescriptions.php" class="btn btn-primary">Go</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Recommended Tests</h5>
                        <p class="card-text">Check your recommended medical tests.</p>
                        <a href="view_tests.php" class="btn btn-primary">Go</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Update Profile</h5>
                        <p class="card-text">Update your personal details and contact information.</p>
                        <a href="update_profile.php" class="btn btn-primary">Go</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
