<?php
include 'pdo.php';
$oop = new oop_class();

// session_start();
// if (!isset($_SESSION['staff_id'])) {
//     header('Location: ../login/index.php');
//     exit();
// }

// Placeholder values (replace with real session data when available)
$staffName = "Clinic Staff";
$staffEmail = "staff@example.com";
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
        .sidebar .nav-link { color: rgba(255,255,255,0.9); }
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.1);
            border-radius: .25rem;
        }
        .sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }
        .sidebar nav { flex: 1 1 auto; }
        @media (max-width: 575.98px) {
            .sidebar { height: auto; position: static; }
        }
    </style>
</head>

<body class="bg-light">

<div class="container-fluid">
    <div class="row g-0">

        <!-- Sidebar -->
        <aside class="col-12 col-md-3 col-lg-2 bg-primary text-white sidebar p-3">
            <div class="d-flex align-items-center mb-3">
                <a class="navbar-brand text-white fs-5 fw-bold me-auto">School Clinic</a>
            </div>

            <nav class="nav nav-pills flex-column">
                <a class="nav-link active mb-1" aria-current="page" href="/WEBSYS1_FINALPROJECT-main/dashboard_staff/index.php">Dashboard</a>
                <a class="nav-link mb-1" href="/WEBSYS1_FINALPROJECT-main/studentRecords/index.php">Visits</a>
                <a class="nav-link mb-1" href="/WEBSYS1_FINALPROJECT-main/inventory/index.php">Inventory</a>
                <a class="nav-link mb-1" href="/WEBSYS1_FINALPROJECT-main/dashboard_staff/settings.php">Settings</a>
            <div class="mt-auto small text-white-50 pt-3">
                Logged in as: Clinic Staff
            </div>
        </aside>

        <!-- Main Content -->
        <main class="col-12 col-md-9 col-lg-10 p-4">

            <div class="bg-white shadow-sm rounded p-4">

                <h2 class="fw-bold">Settings</h2>
                <p class="text-muted">Manage your personal and system settings</p>

                <div class="row g-4">

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
                            <input type="text" class="form-control" name="full_name" value="<?php echo $staffName; ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $staffEmail; ?>">
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

        </div>

        <!-- One unified update button -->
        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-success">Update Settings</button>
            <a href="../WEBSYS1_FINALPROJECT/login/logout.php" class="btn btn-danger">Logout</a>
        </div>
    </form>

            </div>

        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
