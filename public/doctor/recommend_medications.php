<?php
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'doctor') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the medication details
    $patient_id = $_POST['patient_id'];
    $medication = $_POST['medication'];

    // Insert the medication recommendation into the database
    require_once '../../config/db.php';
    $query = "INSERT INTO prescriptions (patient_id, medication) VALUES (?, ?)";
    $stmt = $pdo->prepare($query);

    // Check if the medication was inserted successfully
    if ($stmt->execute([$patient_id, $medication])) {
        // Update the status of the appointment to 'completed'
        $updateQuery = "UPDATE appointments SET status = 'completed' WHERE patient_id = ? AND doctor_id = ?";
        $updateStmt = $pdo->prepare($updateQuery);
        if ($updateStmt->execute([$patient_id, $_SESSION['user']['id']])) {
            $success = "Medication recommended and appointment status updated to completed!";
        } else {
            $error = "Failed to update appointment status.";
        }
    } else {
        $error = "Failed to recommend medication.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommend Medication</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
            max-width: 600px;
        }
        .form-control {
            border-radius: 0.5rem;
        }
        .btn-primary {
            border-radius: 0.5rem;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<?php require_once "./doctor_nav.php"; ?>

<div class="container">
    <h2 class="mb-4">Recommend Medication</h2>

    <!-- Display success or error messages -->
    <?php if (isset($success)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $success; ?>
        </div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <input type="hidden" name="patient_id" value="<?php echo htmlspecialchars($_GET['patient_id']); ?>">
            <label for="medication" class="form-label">Medication Name</label>
            <input type="text" class="form-control" id="medication" name="medication" placeholder="Enter medication name" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Recommend Medication</button>
    </form>

    <div class="mt-4">
        <a href="doctor_dashboard.php" class="btn btn-secondary w-100">Back to Dashboard</a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
