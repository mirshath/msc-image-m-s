<?php
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'financial_staff') {
    header("Location: login.php");
    exit();
}

require_once '../../config/db.php';

// Calculate total income from all the tests assigned
$query = "SELECT SUM(b.amount) AS total_income FROM bills b";
$stmt = $pdo->query($query);
$income = $stmt->fetch(PDO::FETCH_ASSOC);

echo "<h2>Total Income</h2>";

if ($income['total_income'] === null) {
    echo "<p>No income data available.</p>";
} else {
    echo "<p>Total income from test fees: $" . number_format($income['total_income'], 2) . "</p>";
}
?>

<a href="financial_staff_dashboard.php">Back to Dashboard</a>
