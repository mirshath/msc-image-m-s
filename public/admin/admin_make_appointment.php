<?php
session_start();
require_once '../../config/db.php';
require_once '../../src/Appointment.php';

// Fetch patients and doctors for the dropdowns
$patientsQuery = "SELECT id, name FROM users WHERE role = 'patient'";
$doctorsQuery = "SELECT id, name FROM users WHERE role = 'doctor'";

$patientsStmt = $pdo->query($patientsQuery);
$doctorsStmt = $pdo->query($doctorsQuery);

$patients = $patientsStmt->fetchAll(PDO::FETCH_ASSOC);
$doctors = $doctorsStmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment = new Appointment($pdo);
    $patientId = $_POST['patient_id'];
    $doctorId = $_POST['doctor_id'];
    $appointmentDate = $_POST['appointment_date'];

    if ($appointment->createAppointment($patientId, $doctorId, $appointmentDate)) {
        echo "Appointment created successfully!";
    } else {
        echo "Error creating appointment.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: white;
            padding: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            margin: 10px 0;
            display: block;
        }

        .sidebar a:hover {
            background-color: #495057;
            border-radius: 5px;
            /* padding: 0px 10px; */
        }

        .content {
            flex-grow: 1;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <h4>Admin</h4>
            <hr>
            <a href="admin_create_user.php">Create User</a>
            <a href="admin_suspend_user.php">Suspend User</a>
            <a href="admin_make_appointment.php">Make Appointment</a>

            <a href="all-patients.php">All Patients</a>
            <a href="all-staffs.php">All Staffs</a>
            <hr>
            <a href="../logout.php" >Logout</a>
        </div>

        <!-- Content Area -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">

                        <p class="lead">Book a appointment.</p>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header text-center bg-success text-white">
                                <h3>Make Appointment</h3>
                            </div>
                            <div class="card-body">
                                <form method="POST">
                                    <div class="mb-3">
                                        <label for="patient_id" class="form-label">Select Patient</label>
                                        <select name="patient_id" id="patient_id" class="form-select" required>
                                            <option value="">Select a Patient</option>
                                            <?php foreach ($patients as $patient): ?>
                                                <option value="<?php echo $patient['id']; ?>">
                                                    <?php echo htmlspecialchars($patient['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="doctor_id" class="form-label">Select Doctor</label>
                                        <select name="doctor_id" id="doctor_id" class="form-select" required>
                                            <option value="">Select a Doctor</option>
                                            <?php foreach ($doctors as $doctor): ?>
                                                <option value="<?php echo $doctor['id']; ?>">
                                                    <?php echo htmlspecialchars($doctor['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="appointment_date" class="form-label">Appointment Date & Time</label>
                                        <input type="datetime-local" name="appointment_date" id="appointment_date"
                                            class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100">Create Appointment</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>