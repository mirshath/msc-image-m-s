<?php
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'financial_staff') {
    header("Location: login.php");
    exit();
}

require_once '../../config/db.php';

// Fetch all bills for patients from the database
$query = "SELECT p.name AS patient_name, b.test_type, b.amount, b.paid_at FROM bills b
          JOIN users p ON b.patient_id = p.id";
$stmt = $pdo->query($query);
$bills = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h2>Patient Bills</h2>";

if (empty($bills)) {
    echo "<p>No bills found.</p>";
} else {
    echo "<table border='1'>
            <tr>
                <th>Patient Name</th>
                <th>Test Type</th>
                <th>Amount</th>
                <th>Paid At</th>
            </tr>";

    foreach ($bills as $bill) {
        echo "<tr>
                <td>" . $bill['patient_name'] . "</td>
                <td>" . $bill['test_type'] . "</td>
                <td>" . $bill['amount'] . "</td>
                <td>" . $bill['paid_at'] . "</td>
              </tr>";
    }
    echo "</table>";
}
?>

<a href="financial_staff_dashboard.php">Back to Dashboard</a>
