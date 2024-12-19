<?php
session_start();
require_once '../../config/db.php';
require_once '../../src/TestBillManager.php';

// Check user authentication and role
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'radiology_staff') {
    header('Location: ../../index.php'); // Unauthorized access
    exit();
}

// Fetch patient_id from GET parameter (assuming you pass it in the URL)
$patient_id = $_GET['patient_id']; // Make sure to sanitize or validate this input

// Create an instance of TestBillManager class
$testBillManager = new TestBillManager($pdo);

// Get the list of tests associated with the patient
$tests = $testBillManager->getPatientTests($patient_id);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $test_id = $_POST['test_id'];
    $fee_amount = $_POST['fee_amount'];
    $status = $_POST['status'];
    $paid_at = $_POST['paid_at']; // Date when payment is made

    // Assign fee to the selected test
    $testBillManager->assignFeeForTest($patient_id, $test_id, $fee_amount, $status, $paid_at);

    // Success message
    echo "<div style='color: green;'>Fee assigned successfully!</div>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Fee for Patient</title>
</head>
<body>
    <h2>Assign Fee for Patient ID: <?php echo htmlspecialchars($patient_id); ?></h2>

    <!-- Fee Assignment Form -->
    <form method="POST">
        <label for="test_id">Test Name:</label>
        <select name="test_id" id="test_id" required>
            <?php foreach ($tests as $test): ?>
                <option value="<?php echo $test['id']; ?>"><?php echo htmlspecialchars($test['test_name']); ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="fee_amount">Fee Amount:</label>
        <input type="number" name="fee_amount" id="fee_amount" required><br><br>

        <label for="status">Payment Status:</label>
        <select name="status" id="status" required>
            <option value="paid">Paid</option>
            <option value="unpaid">Unpaid</option>
        </select><br><br>

        <label for="paid_at">Payment Date:</label>
        <input type="date" name="paid_at" id="paid_at" required><br><br>

        <button type="submit">Assign Fee</button>
    </form>

    <!-- Back to Patient List Link -->
    <br><br>
    <a href="patient_list.php">Back to Patient List</a>
</body>
</html>
