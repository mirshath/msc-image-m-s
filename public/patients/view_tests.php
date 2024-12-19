<?php
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'patient') {
    header("Location: login.php");
    exit();
}

// Fetch recommended tests for the patient from the database
require_once '../../config/db.php';

$query = "SELECT * FROM reports WHERE patient_id = ? order by id DESC";
$stmt = $pdo->prepare($query);
$stmt->execute([$_SESSION['user']['id']]);
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once("./patient_nav.php"); ?> 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Recommended Tests</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
</head>

<body class="bg-light">
<?php require_once("./patient_nav.php") ?> 
    <div class="container mt-5">
        <div class="card shadow-lg p-4">
            <h1 class="text-center text-primary mb-4">Your Recommended Tests</h1>

            <?php if (empty($reports)) { ?>
                <p class="text-center">No recommended tests found.</p>
            <?php } else { ?>
                <table id="testsTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Test Type</th>
                            <th>Recommended At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reports as $report) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($report['report_type']); ?></td>
                                <td><?php echo htmlspecialchars($report['created_at']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>

            <div class="d-flex justify-content-between">
                <a href="patient_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS CDN -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize DataTables for the table
            $('#testsTable').DataTable({
                "paging": true,       // Enable pagination
                "searching": true,    // Enable search bar
                "ordering": true,     // Enable column sorting
                "info": true,         // Show table information
                "lengthChange": true  // Allow the user to change page size
            });
        });
    </script>
</body>

</html>
