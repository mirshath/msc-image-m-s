<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'patient') {
    header("Location: login.php");
    exit();
}

require_once '../../config/db.php';
require_once '../../src/Appointment.php';

$appointment = new Appointment($pdo);

// Fetch doctors from the database
$doctors = $pdo->query("SELECT id, name FROM users WHERE role = 'doctor'")->fetchAll();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientId = $_SESSION['user']['id'];
    $doctorId = $_POST['doctor_id'];
    $appointmentDate = $_POST['appointment_date'];

    if ($appointment->bookAppointment($patientId, $doctorId, $appointmentDate)) {
        $message = "Appointment successfully booked!";
    } else {
        $message = "There was an error booking your appointment. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>

<body>
<?php require_once("./patient_nav.php") ?> 
    <div class="container mt-5">
        <h1>Book Appointment</h1>

        <?php if (isset($message)) { echo "<p class='alert alert-info'>$message</p>"; } ?>

        <form method="POST">
            <div class="mb-3">
                <label for="doctor_id" class="form-label">Doctor</label>
                <select class="form-select" id="doctor_id" name="doctor_id" required>
                    <option value="">Select a Doctor</option>
                    <?php foreach ($doctors as $doctor): ?>
                        <option value="<?= htmlspecialchars($doctor['id']) ?>"><?= htmlspecialchars($doctor['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="appointment_date" class="form-label">Appointment Date</label>
                <input type="datetime-local" class="form-control" id="appointment_date" name="appointment_date" required>
            </div>

            <button type="submit" class="btn btn-primary">Book Appointment</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
