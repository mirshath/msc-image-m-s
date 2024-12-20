<?php
session_start();

require_once '../../config/db.php';
require_once '../../src/Images.php';

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'doctor') {
    header("Location: login.php");
    exit();
}


// Pagination settings
$perPage = 10; // Number of images per page
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1; // Current page, default to 1
$offset = ($page - 1) * $perPage; // Calculate the offset

// Fetch patient images with pagination
$imageObj = new ImageManager($pdo);
$patientImages = $imageObj->getPatientImages($perPage, $offset);

// Get total number of images to calculate total pages
$totalStmt = $pdo->query("SELECT COUNT(DISTINCT patient_id) AS total_patients FROM images_new");
$total = $totalStmt->fetch(PDO::FETCH_ASSOC)['total_patients'];
$totalPages = ceil($total / $perPage);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Images</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include "./doctor_nav.php"; ?>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Patient Images</h1>
        <div class="accordion" id="patientAccordion">
            <?php
            $currentPatientId = null;
            foreach ($patientImages as $image):
                if ($currentPatientId !== $image['patient_id']):
                    if ($currentPatientId !== null): ?>
                    </div>
                </div>
                </div>
            <?php endif;
                    $currentPatientId = $image['patient_id']; ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading<?php echo $image['patient_id']; ?>">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse<?php echo $image['patient_id']; ?>" aria-expanded="false"
                        aria-controls="collapse<?php echo $image['patient_id']; ?>">
                        <?php echo "Patient: " . htmlspecialchars($image['patient_name']); ?>
                    </button>
                </h2>
                <div id="collapse<?php echo $image['patient_id']; ?>" class="accordion-collapse collapse"
                    aria-labelledby="heading<?php echo $image['patient_id']; ?>" data-bs-parent="#patientAccordion">
                    <div class="accordion-body">
                        <div class="row">
                        <?php endif; ?>
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <!-- Make the image clickable -->
                                <img src="https://msc-project-healthcare-system.s3.eu-north-1.amazonaws.com/<?php echo htmlspecialchars($image['s3_key']); ?>"
                                    class="card-img-top" alt="<?php echo htmlspecialchars($image['image_type']); ?>"
                                    data-bs-toggle="modal" data-bs-target="#imageModal<?php echo $image['image_id']; ?>">
                                <!-- Link to modal -->
                                <div class="card-body">
                                    <h5 class="card-title">Type: <?php echo htmlspecialchars($image['image_type']); ?></h5>
                                    <p class="card-text">
                                        Image ID: <?php echo $image['image_id']; ?><br>
                                        Uploaded At: <?php echo $image['uploaded_at']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for image preview -->
                        <div class="modal fade" id="imageModal<?php echo $image['image_id']; ?>" tabindex="-1"
                            aria-labelledby="imageModalLabel<?php echo $image['image_id']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="imageModalLabel<?php echo $image['image_id']; ?>">Image
                                            Preview</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="https://msc-project-healthcare-system.s3.eu-north-1.amazonaws.com/<?php echo htmlspecialchars($image['s3_key']); ?>"
                                            class="img-fluid" alt="<?php echo htmlspecialchars($image['image_type']); ?>">
                                        <!-- Larger image -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                    <?php if ($currentPatientId !== null): ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    </div>

    <!-- Pagination Controls -->
    <div class="pagination-container">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item <?php echo ($page == 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php echo ($page == $totalPages) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>