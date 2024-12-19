<?php
session_start();

// Check if the user is logged in and is a doctor
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'doctor') {
    header("Location: login.php");
    exit();
}

// Fetch doctor ID from session
$doctorId = $_SESSION['user']['id'];

require_once '../../config/db.php';

// Query to get patients who have appointments with this doctor
// $query = "
//     SELECT u.id, u.name, u.email 
//     FROM users u
//     JOIN appointments a ON u.id = a.patient_id
//     WHERE a.doctor_id =  ?
// ";
$query = "
    SELECT u.id, u.name, u.email 
    FROM users u
    JOIN appointments a ON u.id = a.patient_id
    WHERE a.doctor_id = ? AND a.status = 'completed' order by id DESC
";
$stmt = $pdo->prepare($query);
$stmt->execute([$doctorId]);
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Patients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php require_once "./doctor_nav.php" ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h3>List of Patients</h3>
                    </div>
                    <div class="card-body">
                        <!-- Table to display patients -->
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($patients)): ?>
                                    <?php foreach ($patients as $patient): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($patient['name']); ?></td>
                                            <td><?php echo htmlspecialchars($patient['email']); ?></td>
                                            <td>
                                                <a href="recommend_tests.php?patient_id=<?php echo $patient['id']; ?>" class="btn btn-success btn-sm">Recommend Tests</a>
                                                <a href="recommend_medications.php?patient_id=<?php echo $patient['id']; ?>" class="btn btn-warning btn-sm">Recommend Medication</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center">No approved appointments found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
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
