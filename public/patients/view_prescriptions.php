<?php

session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'patient') {
    header("Location: login.php");
    exit();
}

// Fetch prescriptions for the patient from the database
require_once '../../config/db.php';

$query = "SELECT * FROM prescriptions WHERE patient_id = ? ORDER BY id DESC";
$stmt = $pdo->prepare($query);
$stmt->execute([$_SESSION['user']['id']]);
$prescriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Prescriptions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
</head>

<body>
<?php require_once("./patient_nav.php") ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h3>Your Prescriptions</h3>
                    </div>
                    <div class="card-body">
                        <?php


                        if (empty($prescriptions)) {
                            echo "<p class='text-center'>No prescriptions found.</p>";
                        } else {
                            echo "<table id='prescriptionsTable' class='table table-bordered table-striped'>
                                    <thead>
                                        <tr>
                                            <th>Medication</th>
                                            <th>Prescribed At</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

                            foreach ($prescriptions as $prescription) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($prescription['medication']) . "</td>
                                        <td>" . htmlspecialchars($prescription['created_at']) . "</td>
                                      </tr>";
                            }

                            echo "</tbody></table>";
                        }
                        ?>
                    </div>
                    <div class="card-footer text-center">
                        <a href="patient_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS CDN -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize DataTables
            $('#prescriptionsTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "lengthChange": true
            });
        });
    </script>
</body>

</html>