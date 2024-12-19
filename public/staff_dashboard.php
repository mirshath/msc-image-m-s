<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'staff') {
    header("Location: login.php");
    exit();
}
echo "<h1>Welcome, " . $_SESSION['user']['name'] . "!</h1>";
echo "<p>This is your staff dashboard.</p>";





?>


<nav>
    <a href="./radiology_staff/upload_image.php">upload img</a><br>
    <a href="./radiology_staff/view_patients.php">view patients</a><br>
    <a href="./radiology_staff/view_tests.php">View Tests</a><br>
    <a href="logout.php">Logout</a>
</nav>
