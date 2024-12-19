<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'patient') {
    header("Location: login.php");
    exit();
}

require_once '../../config/db.php';
require_once '../../src/Appointment.php';

$appointment = new Appointment($pdo);

// Fetch patient's appointments
$appointments = $appointment->getAppointmentsForPatient($_SESSION['user']['id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Appointments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>

<body>
    <?php require_once("./patient_nav.php") ?> 
    <div class="container mt-5">
        <h1>Your Appointments</h1>

        <?php if (empty($appointments)): ?>
            <p>You have no upcoming appointments.</p>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Doctor</th>
                        <th>Appointment Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td>Dr. <?= htmlspecialchars($appointment['doctor_id']) ?></td>
                            <td><?= htmlspecialchars($appointment['appointment_date']) ?></td>
                            <td><?= htmlspecialchars($appointment['status']) ?></td>
                            <td>
                                <?php if ($appointment['status'] == 'scheduled'): ?>
                                    <a href="cancel_appointment.php?id=<?= htmlspecialchars($appointment['id']) ?>" class="btn btn-danger btn-sm">Cancel</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
