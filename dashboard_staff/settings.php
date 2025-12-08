<?php
// 1. INCLUDE THE GUARD FIRST (Handles session_start, auth check, and No-Cache headers)
include '../login/auth_guard.php'; 

include 'pdo.php';
$oop = new oop_class();

// The guard guarantees $_SESSION['user_id'] is set, so it's safe to use
$userID = $_SESSION['user_id'];

// 2. Fetch user data (Ensure your method name matches, e.g., get_user)
$user = $oop->get_user($userID); 

// Default fallbacks
$staffName = 'N/A';
$staffEmail = 'N/A';

if (is_array($user)) {
    // Construct the name based on your database columns
    $staffName = trim($user['FirstName'] . " " . $user['MiddleName'] . " " . $user['LastName']);
    $staffEmail = $user['Email'];
}

$activePage = 'settings'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Settings - School Clinic</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .main-content {
            margin-left: 270px;
            padding: 25px;
        }
    </style>
</head>

<body class="bg-light">

<?php 
    $activePage = 'settings'; 
    include '../sidebar/sidebar.php';
?>

<!-- MAIN CONTENT -->
<div class="main-content">

    <div class="bg-white shadow-sm rounded p-4">

        <h2 class="fw-bold">Settings</h2>
        <p class="text-muted">Manage your personal and system settings</p>

        <form method="POST" action="settings_update.php">

            <div class="row g-4">

                <!-- Profile Settings -->
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Profile Information</h5>
                            <p class="text-muted small">Update your name and email</p>

                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="full_name" 
                                        value="<?= htmlspecialchars($staffName) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" 
                                        value="<?= htmlspecialchars($staffEmail) ?>" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Password Settings -->
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Change Password</h5>
                            <p class="text-muted small">Update your account password</p>

                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password" class="form-control" name="current_password">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" class="form-control" name="new_password">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" name="confirm_password">
                            </div>
                    </div>
                </div>

            </div>

            <!-- Buttons -->
            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-success">Update Settings</button>
                <a href="../login/logout.php" class="btn btn-danger">Logout</a>
            </div>

        </form>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>
</body>
</html>
</body>
</html>