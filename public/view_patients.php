<?php
session_start();
require_once '../config/db.php';
require_once '../src/User.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['user']; // User information stored in session

if ($user['role'] !== 'radiology_staff') {
    header('Location: index.php'); // Unauthorized access, redirect to homepage
    exit();
}

// Instantiate User class
$userObj = new User($mysqli);
$patients = $userObj->getAllUsers(); // Get all users from the database

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patients</title>
</head>
<body>
    <h1>Patients List</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Patient ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($patients as $patient): ?>
                <?php if ($patient['role'] == 'patient'): ?>
                    <tr>
                        <td><?php echo $patient['id']; ?></td>
                        <td><?php echo $patient['name']; ?></td>
                        <td><?php echo $patient['email']; ?></td>
                        <td><?php echo $patient['status']; ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
