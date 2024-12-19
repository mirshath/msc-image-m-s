<?php
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'doctor') {
    header("Location: login.php");
    exit();
}

// Fetch the images from the database
require_once '../../config/db.php';

$query = "SELECT * FROM images";
$stmt = $pdo->prepare($query);
$stmt->execute();
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h1>Test Images</h1>";
echo "<table border='1'>
        <tr>
            <th>Image Type</th>
            <th>Uploaded At</th>
            <th>Actions</th>
        </tr>";

foreach ($images as $image) {
    echo "<tr>
            <td>" . $image['type'] . "</td>
            <td>" . $image['uploaded_at'] . "</td>
            <td><a href='view_image.php?id=" . $image['id'] . "'>View Image</a></td>
          </tr>";
}
echo "</table>";
?>

<a href="doctor_dashboard.php">Back to Dashboard</a>
