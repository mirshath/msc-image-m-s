<?php 
session_start();
require_once '../../config/db.php';
require_once '../../src/TestFeeManager.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['user'];

if ($user['role'] !== 'radiology_staff') {
    header('Location: ../../index.php'); // Unauthorized access
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $test_type = $_POST['test_type'];
    $fee_amount = $_POST['fee_amount'];
    
    $testFeeManager = new TestFeeManager($pdo);
    $testFeeManager->assignTestFee($test_type, $fee_amount);
    
    echo "Fee assigned successfully!";
}
?>

<form method="POST">
    <label for="test_type">Test Type:</label>
    <input type="text" name="test_type" id="test_type" required>
    
    <label for="fee_amount">Fee Amount:</label>
    <input type="number" name="fee_amount" id="fee_amount" required>
    
    <button type="submit">Assign Fee</button>
</form>
