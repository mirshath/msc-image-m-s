<?php
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'financial_staff') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Staff Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Financial Staff Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="assign_fees.php">Assign Fees</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_patient_bills.php">View Patient Bills</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_income.php">View Income</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-12 text-center">
                <h1>Welcome, <?php echo $_SESSION['user']['name']; ?>!</h1>
                <p class="lead">This is your Financial Staff dashboard.</p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Assign Fees for Tests</h5>
                        <p class="card-text">Assign fees to users for tests and services.</p>
                        <a href="assign_fees.php" class="btn btn-success">Go</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">View Patient Bills</h5>
                        <p class="card-text">View and manage patient billing information.</p>
                        <a href="view_patient_bills.php" class="btn btn-success">Go</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">View Income</h5>
                        <p class="card-text">Monitor income from services provided.</p>
                        <a href="view_income.php" class="btn btn-success">Go</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
