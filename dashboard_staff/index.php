<?php
include 'pdo.php';
$oop = new oop_class();
// session_start();
// if (!isset($_SESSION['staff_id'])) {
//     header('Location: ../login/index.php');
//     exit();
// }

$fetch_inventory = $oop->show_inventory();           
$fetch_studentRecords = $oop->show_studentRecords(); 
$fetch_transactions = $oop->show_transactions();     
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>School Clinic Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Optional: make sidebar links stand out */
        .sidebar .nav-link {
            color: rgba(255,255,255,0.9);
        }
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.1);
            border-radius: .25rem;
        }
        /* Ensure main content has some vertical spacing on small screens */
        .main-content { padding: 1.5rem; }

        /* Sidebar improvements: keep it visible and let it behave as a column so the bottom area stays at the bottom */
        .sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding-bottom: 1rem;
            overflow-y: auto;
        }
        .sidebar nav {
            /* allow nav to grow so the "Logged in as" stays at the bottom */
            flex: 1 1 auto;
        }

        /* On very small screens keep the sidebar compact (stacking behavior already handled by grid) */
        @media (max-width: 575.98px) {
            .sidebar {
                height: auto;
                position: static;
            }
        }
    </style>
</head>
<body class="bg-light">
<div class="container-fluid">
    <div class="row g-0">
        <!-- Sidebar -->
        <aside class="col-12 col-md-3 col-lg-2 bg-primary text-white sidebar p-3">
            <div class="d-flex align-items-center mb-3">
                <a class="navbar-brand text-white fs-5 fw-bold me-auto" href="#">School Clinic</a>
            </div>
            <nav class="nav nav-pills flex-column">
                <a class="nav-link active mb-1" aria-current="page" href="/WEBSYS1_FINALPROJECT/dashboard_staff/index.php">Dashboard</a>
                <a class="nav-link mb-1" href="/WEBSYS1_FINALPROJECT/studentRecords/index.php">Visits</a>
                <a class="nav-link mb-1" href="/WEBSYS1_FINALPROJECT/inventory/index.php">Inventory</a>
                <a class="nav-link mb-1" href="#">Settings</a>
            </nav>
            <div class="mt-auto small text-white-50 pt-3">
                <div>Logged in as: Clinic Staff</div>
            </div>
        </aside>

        <!-- Main content -->
        <main class="col-12 col-md-9 col-lg-10 main-content">
            <div class="bg-white rounded p-4 shadow-sm">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-4 gap-3">
                    <div>
                        <h2 class="mb-1 fw-bold">Welcome, Clinic Staff!</h2>
                        <p class="text-muted mb-0">Overview of today's activity</p>
                    </div>
                    <div class="text-muted small d-none d-md-block" id="last-updated-header">Last updated: <?php echo date('Y-m-d H:i:s'); ?></div>
                </div>

                <div class="row g-4">
                    <div class="col-12 col-lg-7">
                        <div class="mb-3">
                            <h5 class="text-primary">Recent Visits</h5>
                        </div>
                        <div class="table-responsive bg-white rounded shadow-sm mb-3">
                            <?php
                            // show only recent 5 items
                            $limit = 5;
                            if ($fetch_studentRecords->rowCount() > 0) {
                                echo '<table class="table table-striped table-hover align-middle mb-0 small">';
                                echo '<thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>ID Number</th>
                                            <th>Department</th>
                                            <th>Complaint</th>
                                            <th>Visit Date</th>
                                        </tr>
                                      </thead><tbody>';
                                $count = 0;
                                while ($row = $fetch_studentRecords->fetch(PDO::FETCH_ASSOC)) {
                                    if ($count >= $limit) break;
                                    $id = htmlspecialchars($row['ID'] ?? '');
                                    $name = htmlspecialchars($row['name'] ?? '');
                                    $idNum = htmlspecialchars($row['idNum'] ?? '');
                                    $dept = htmlspecialchars($row['department'] ?? '');
                                    $complaint = htmlspecialchars($row['complaint'] ?? '');
                                    $visitDate = htmlspecialchars($row['visitDate'] ?? '');
                                    echo '<tr>';
                                    echo "<td>{$id}</td>";
                                    echo "<td>{$name}</td>";
                                    echo "<td>{$idNum}</td>";
                                    echo "<td>{$dept}</td>";
                                    echo "<td>{$complaint}</td>";
                                    echo "<td>{$visitDate}</td>";
                                    echo '</tr>';
                                    $count++;
                                }
                                echo '</tbody></table>';
                            } else {
                                echo '<div class="p-4 text-center text-muted">No recent visits.</div>';
                            }
                            ?>
                        </div>
                    </div>

                    <div class="col-12 col-lg-5">
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <h5 class="text-primary mb-0">Inventory</h5>
                            <small class="text-muted">Snapshot</small>
                        </div>

                        <div class="table-responsive bg-white rounded shadow-sm mb-3">
                            <?php
                            // show only recent 5 items
                            $limit = 5;
                            if ($fetch_inventory && $fetch_inventory->rowCount() > 0) {
                                echo '<table class="table table-sm mb-0">';
                                echo '<thead class="table-light">
                                        <tr>
                                            <th>Generic Name</th>
                                            <th>Dosage</th>
                                            <th>Brand</th>
                                            <th>Category</th>
                                            <th>Qty</th>
                                            <th>Add Date</th>
                                            <th>Expiry</th>
                                        </tr>
                                      </thead><tbody>';
                                $count = 0;
                                while ($row = $fetch_inventory->fetch(PDO::FETCH_ASSOC)) {
                                    if ($count >= $limit) break;
                                    echo '<tr>';
                                    echo '<td>' . htmlspecialchars($row['genericName'] ?? '') . '</td>';
                                    echo '<td>' . htmlspecialchars($row['dosage'] ?? '') . '</td>';
                                    echo '<td>' . htmlspecialchars($row['brand'] ?? '') . '</td>';
                                    echo '<td>' . htmlspecialchars($row['category'] ?? '') . '</td>';
                                    echo '<td>' . htmlspecialchars($row['quantity'] ?? '') . '</td>';
                                    echo '<td>' . htmlspecialchars($row['addDate'] ?? '') . '</td>';
                                    echo '<td>' . htmlspecialchars($row['expDate'] ?? '') . '</td>';
                                    echo '</tr>';
                                    $count++;
                                }
                                echo '</tbody></table>';
                            } else {
                                echo '<div class="p-4 text-center text-muted">No Inventory Records.</div>';
                            }
                            ?>
                        </div>

                <div class="mt-4">
                    <h5 class="text-primary mb-3">Recent Transactions</h5>
                    <div class="table-responsive bg-white rounded shadow-sm">
                        <?php
                        // show only recent 5 items
                        $limit = 5;
                        if ($fetch_transactions && $fetch_transactions->rowCount() > 0) {
                            echo '<table class="table table-striped table-hover mb-0">';
                            echo '<thead class="table-light">
                                    <tr>
                                        <th>Quantity</th>
                                        <th>Transaction Date</th>
                                        <th>Item ID</th>
                                        <th>Student ID</th>
                                    </tr>
                                  </thead><tbody>';
                            $count = 0;
                            while ($row = $fetch_transactions->fetch(PDO::FETCH_ASSOC)) {
                                if ($count >= $limit) break;
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($row['quantity'] ?? '') . '</td>';
                                echo '<td>' . htmlspecialchars($row['transactionDate'] ?? '') . '</td>';
                                echo '<td>' . htmlspecialchars($row['itemID'] ?? '') . '</td>';
                                echo '<td>' . htmlspecialchars($row['studentID'] ?? '') . '</td>';
                                echo '</tr>';
                                $count++;
                            }
                            echo '</tbody></table>';
                        } else {
                            echo '<div class="p-4 text-center text-muted">No Transactions.</div>';
                        }
                        ?>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>

<!-- Bootstrap JS (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
