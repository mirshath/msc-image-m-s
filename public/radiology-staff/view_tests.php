<?php
session_start();
require_once '../../config/db.php';
require_once '../../src/Appointment.php';

// Ensure only radiology staff can access
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'radiology_staff') {
    header('Location: ../../index.php');
    exit();
}

// Instantiate Appointment class and fetch reports
$appointmentObj = new Appointment($pdo);
$reportsWithAppointments = $appointmentObj->getAllReportsWithAppointments();


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Recommended Tests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Recommended Tests for Patients</h1>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Appointment ID</th>
                    <th>Patient ID</th>
                    <th>Doctor ID</th>
                    <th>Appointment Date</th>
                    <th>Status</th>
                    <th>Report Type</th>
                    <th>Report Created Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reportsWithAppointments as $report): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($report['appointment_id']); ?></td>
                        <td><?php echo htmlspecialchars($report['patient_id']); ?></td>
                        <td><?php echo htmlspecialchars($report['doctor_id']); ?></td>
                        <td><?php echo htmlspecialchars($report['appointment_date']); ?></td>
                        <td><?php echo htmlspecialchars($report['status']); ?></td>
                        <td><?php echo htmlspecialchars($report['report_type']); ?></td>
                        <td><?php echo htmlspecialchars($report['report_created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>