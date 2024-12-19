<?php
session_start();
require_once '../../config/db.php';
require_once '../../src/Staffs.php';

// Check user authentication and role
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../../index.php');
    exit();
}

$staffManager = new Staffs($pdo);

// Handle update request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    if ($staffManager->updateUser($id, $name, $email)) {
        $success = "User updated successfully!";
    } else {
        $error = "Failed to update user.";
    }
}

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $id = $_POST['id'];

    if ($staffManager->deleteUser($id)) {
        $success = "User deleted successfully!";
    } else {
        $error = "Failed to delete user.";
    }
}

// Fetch all non-patient users
$users = $staffManager->getAllNonPatientUsers();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
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

                <div class="container mt-5">
                    <h4 class="text-center mb-4">Manage Users</h4>

                    <!-- Success Message -->
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                    <?php endif; ?>
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>

                    <!-- Users Table -->
                    <table id="usersTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editModal<?php echo $user['id']; ?>">Edit</button>

                                        <!-- Delete Button -->
                                        <form method="POST" action="" class="d-inline">
                                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                            <button type="submit" name="delete_user" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal<?php echo $user['id']; ?>" tabindex="-1"
                                    aria-labelledby="editModalLabel<?php echo $user['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel<?php echo $user['id']; ?>">Edit
                                                    User</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form method="POST" action="">
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                                    <div class="mb-3">
                                                        <label for="name<?php echo $user['id']; ?>"
                                                            class="form-label">Name</label>
                                                        <input type="text" class="form-control"
                                                            id="name<?php echo $user['id']; ?>" name="name"
                                                            value="<?php echo htmlspecialchars($user['name']); ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="email<?php echo $user['id']; ?>"
                                                            class="form-label">Email</label>
                                                        <input type="email" class="form-control"
                                                            id="email<?php echo $user['id']; ?>" name="email"
                                                            value="<?php echo htmlspecialchars($user['email']); ?>"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" name="update_user" class="btn btn-primary">Save
                                                        Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- jQuery -->
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <!-- Bootstrap JS -->
                <script
                    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
                <!-- DataTables JS -->
                <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
                <script>
                    // Initialize DataTables
                    $(document).ready(function () {
                        $('#usersTable').DataTable({
                            "responsive": true,
                            "autoWidth": false,
                            "language": {
                                "search": "Search Users:",
                                "lengthMenu": "Display _MENU_ records per page",
                                "zeroRecords": "No matching users found",
                                "info": "Showing page _PAGE_ of _PAGES_",
                                "infoEmpty": "No records available",
                                "infoFiltered": "(filtered from _MAX_ total records)"
                            }
                        });
                    });
                </script>



            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>