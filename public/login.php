<?php
session_start();
require_once '../config/db.php';
require_once '../src/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form inputs
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Initialize User class
    $user = new User($pdo);

    // Fetch user details by email
    $userDetails = $user->getUserByEmail($email);

    if ($userDetails && password_verify($password, $userDetails['password'])) {
        // Store user details in session
        $_SESSION['user'] = $userDetails;

        // Redirect based on user role
        switch ($userDetails['role']) {
            case 'patient':
                header("Location: patients/patient_dashboard.php");
                break;
            case 'doctor':
                header("Location: doctor/doctor_dashboard.php");
                break;
            case 'radiology_staff':
                header("Location: radiology-staff/radiology_staff_dashboard.php");
                break;
            case 'financial_staff':
                header("Location: financial_staff/financial_staff_dashboard.php");
                break;
            case 'admin':
                header("Location: admin/admin_dashboard.php");
                break;
            default:
                echo "Invalid role.";
                exit();
        }
        exit();
    } else {
        echo "Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
        <h2 class="text-center text-primary mb-4">Login</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
            <div class="text-center mt-3">
                <a href="./register.php" class="text-decoration-none">Don't have an account? Register</a>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

