<?php
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'doctor') {
    header("Location: ../../login.php");
    exit();
}

require_once '../../config/db.php';

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $patient_id = filter_input(INPUT_POST, 'patient_id', FILTER_VALIDATE_INT);
    $test_name = filter_input(INPUT_POST, 'test_name', FILTER_SANITIZE_STRING);
    $doctor_id = $_SESSION['user']['id'];

    if ($patient_id && $test_name) {
        // Insert the test recommendation into the database
        $query = "INSERT INTO reports (patient_id, doctor_id, report_type, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $pdo->prepare($query);

        if ($stmt->execute([$patient_id, $doctor_id, $test_name])) {
            $success_message = "Test recommended successfully!";
        } else {
            $error_message = "Failed to recommend test. Please try again.";
        }
    } else {
        $error_message = "Invalid input. Please fill in all fields correctly.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommend Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require_once "./doctor_nav.php"; ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h3>Recommend Test</h3>
                    </div>
                    <div class="card-body">
                        <!-- Display success or error messages -->
                        <?php if (!empty($success_message)): ?>
                            <div class="alert alert-success text-center">
                                <?php echo $success_message; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($error_message)): ?>
                            <div class="alert alert-danger text-center">
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <input type="hidden" name="patient_id" value="<?php echo htmlspecialchars($_GET['patient_id']); ?>">

                            <div class="mb-3">
                                <label for="test_name" class="form-label">Test Name</label>
                                <input type="text" class="form-control" name="test_name" id="test_name" placeholder="Enter Test Name" required>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success">Recommend Test</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <a href="doctor_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
