<?php
session_start();
require_once '../../config/db.php';
require_once '../../src/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User($pdo);
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($user->createUser($name, $email, $password, $role)) {
        echo "User created successfully!";
    } else {
        echo "Error creating user.";
    }
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
                   
                    <p class="lead">Create user</p>
                </div>
            </div>

            <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header text-center bg-primary text-white">
                        <h3>Create User</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select name="role" id="role" class="form-select" required>
                                    <option value="patient">Patient</option>
                                    <option value="doctor">Doctor</option>
                                    <option value="radiology_staff">Radiology Staff</option>
                                    <option value="financial_staff">Financial Staff</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Create User</button>
                        </form>
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
