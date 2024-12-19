<?php
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'financial_staff') {
    header("Location: login.php");
    exit();
}

require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $testType = $_POST['test_type'];
    $feeAmount = $_POST['fee_amount'];

    $query = "INSERT INTO test_fees (test_type, fee_amount) VALUES (?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$testType, $feeAmount]);

    echo "<p>Fee assigned successfully for the $testType test.</p>";
}
?>

<h2>Assign Fees for Tests</h2>
<form method="POST">
    <label for="test_type">Test Type:</label>
    <input type="text" name="test_type" required><br>

    <label for="fee_amount">Fee Amount:</label>
    <input type="number" name="fee_amount" required><br>

    <button type="submit">Assign Fee</button>
</form>

<a href="financial_staff_dashboard.php">Back to Dashboard</a>
