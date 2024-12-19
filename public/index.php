<?php
session_start();
require_once '../config/db.php';
require_once '../src/User.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['user']; // User information stored in session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS System</title>
</head>
<body>
    <h1>Welcome, <?php echo $user['name']; ?></h1>

    <?php if ($user['role'] == 'admin'): ?>
        <a href="create_user.php">Create User</a>
        <a href="suspend_user.php">Suspend User</a>
        <a href="appointments.php">Manage Appointments</a>
    <?php elseif ($user['role'] == 'patient'): ?>
        <a href="view_images.php">View Images</a>
        <a href="view_reports.php">View Reports</a>
        <a href="recommended_tests.php">View Recommended Tests</a>
    <?php elseif ($user['role'] == 'doctor'): ?>
        <a href="view_patients.php">View Patients</a>
        <a href="recommend_tests.php">Recommend Tests</a>
        <a href="view_images.php">View Test Images</a>
        <a href="recommend_medications.php">Recommend Medications</a>
    <?php elseif ($user['role'] == 'radiology_staff'): ?>
        <a href="view_patients.php">View Patients</a>
        <a href="view_tests.php">View Recommended Tests</a>
        <a href="upload_image.php">Upload Image</a>
    <?php elseif ($user['role'] == 'financial_staff'): ?>
        <a href="view_bills.php">View Bills</a>
        <a href="assign_fees.php">Assign Fees</a>
        <a href="view_income.php">View Income</a>
    <?php endif; ?>
    

</body>
</html>
