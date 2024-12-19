
<?php
session_start();
require_once '../../config/db.php';
require_once '../../src/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User($pdo);
    $userId = $_POST['user_id'];
    $status = $_POST['status'];

    if ($user->updateUserStatus($userId, $status)) {
        echo "User status updated successfully!";
    } else {
        echo "Error updating user status.";
    }
}

// Fetch all users to display in the dropdown
$user = new User($pdo);
$users = $user->getAllUsers();

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
                   
                    <p class="lead">Status</p>
                </div>
            </div>

       
            <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-info text-white">
                    <h3>Update User Status</h3>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Select User</label>
                            <select name="user_id" id="user_id" class="form-select" required>
                                <option value="" disabled selected>Select a user</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['name']); ?> (ID: <?php echo $user['id']; ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="active">Activate</option>
                                <option value="suspended">Suspend</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">Update Status</button>
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
