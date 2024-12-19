<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: white;
            padding: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            margin: 10px 0;
            display: block;
        }
        .sidebar a:hover {
            background-color: #495057;
            border-radius: 5px;
            /* padding: 0px 10px; */
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar">
        <h4>Admin</h4>
        <hr>
        <a href="admin_create_user.php">Create User</a>
        <a href="admin_suspend_user.php">Suspend User</a>
        <a href="admin_make_appointment.php">Make Appointment</a>

        <a href="all-patients.php">All Patients</a>
        <a href="all-staffs.php">All Staffs</a>
        <hr>
        <a href="../logout.php" >Logout</a>
    </div>

    <!-- Content Area -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1>Welcome, Admin!</h1>
                    <p class="lead">Manage users and appointments using the options below.</p>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Create User</h5>
                            <p class="card-text">Add new users to the system.</p>
                            <a href="admin_create_user.php" class="btn btn-primary">Go</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Suspend User</h5>
                            <p class="card-text">Suspend or deactivate user accounts.</p>
                            <a href="admin_suspend_user.php" class="btn btn-primary">Go</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Make Appointment</h5>
                            <p class="card-text">Schedule appointments for users.</p>
                            <a href="admin_make_appointment.php" class="btn btn-primary">Go</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Approve Appointments</h5>
                            <p class="card-text">Review and approve user appointments.</p>
                            <a href="approve_appointments.php" class="btn btn-primary">Go</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">All Patients</h5>
                            <p class="card-text">View all registered patients.</p>
                            <a href="all-patients.php" class="btn btn-primary">Go</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">All Staffs</h5>
                            <p class="card-text">View all registered staff members.</p>
                            <a href="all-staffs.php" class="btn btn-primary">Go</a>
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
