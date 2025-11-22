<?php
include 'pdo.php';
$oop = new oop_class();
// session_start();
// if (!isset($_SESSION['staff_id'])) {
//     header('Location: ../login/index.php');
//     exit();
// }
// $fetch = $oop->show_datat();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>School Clinic Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <header class="mb-4">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="#">School Clinic</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navMenu">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link active" href="/WEBSYS1_FINALPROJECT/dashboard_staff/index.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="/WEBSYS1_FINALPROJECT/studentRecords/index.php">Visits</a></li>
                        <li class="nav-item"><a class="nav-link" href="/WEBSYS1_FINALPROJECT/inventory/index.php">Inventory</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Settings</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container">
        <div class="bg-white rounded p-4 shadow-sm">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-4 gap-3">
                <div>
                    <h2 class="mb-1 fw-bold">Welcome, Clinic Staff!</h2>
                    <p class="text-muted mb-0">Overview of today's activity</p>
                </div>
                <div class="text-muted small" id="last-updated">Last updated: —</div>
            </div>
            <div class="row g-3 mb-4">
                <div class="col-12 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="fs-2 fw-bold text-primary">120</div>
                            <div class="text-muted">Students Visited Today</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="fs-2 fw-bold text-primary">8</div>
                            <div class="text-muted">Medications Dispensed</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12 col-lg-7">
                    <div class="mb-3">
                        <h5 class="text-primary">Recent Visits</h5>
                    </div>
                    <div class="table-responsive bg-white rounded shadow-sm">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-light">
                                <?php
                                if ($fetch->rowCount() < 1) {
                                    echo "<center><h4>No Visit Records.</h4></center>";
                                } else {
                                    echo "
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Student ID Number</th>
                                        <th>Department</th>
                                        <th>Complaint</th>
                                        <th>Visit Date</th>
                                    </tr>
                                    ";
                                    while ($row = $fetch->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= htmlspecialchars($row['ID']) ?></td>
                                    td><?= htmlspecialchars($row['name']) ?></td>
                                    <td><?= htmlspecialchars($row['idNum']) ?></td>
                                    <td><?= htmlspecialchars($row['department']) ?></td>
                                    <td><?= htmlspecialchars($row['complaint']) ?></td>
                                    <td><?= htmlspecialchars($row['visitDate']) ?></td> 
                                </tr>
                            </tbody>
                        </table>
                        <?php
                            }
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
                        <table class="table table-sm mb-0">
                            <thead class="table-light">
                                <?php
                                if ($fetch->rowCount() < 1) {
                                    echo "<center><h4>No Inventory Records.</h4></center>";
                                } else {
                                    echo "
                                    <tr>
                                        <th>Item ID</th>
                                        <th>Generic Name</th>
                                        <th>Brand</th>
                                        <th>Quantity</th>
                                        <th>Expiry Date</th>
                                    </tr>
                                    ";
                                    while ($row = $fetch->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= htmlspecialchars($row['itemID']) ?></td>
                                    <td><?= htmlspecialchars($row['genericName']) ?></td>
                                    <td><?= htmlspecialchars($row['brand']) ?></td>
                                    <td><?= htmlspecialchars($row['quantity']) ?></td>
                                    <td><?= htmlspecialchars($row['expDate']) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="mb-2">Weekly Logs — Summary</h6>
                            <ul class="list-unstyled mb-0 small">
                                <li class="d-flex justify-content-between"><span>Visits this week</span><strong>540</strong></li>
                                <li class="d-flex justify-content-between"><span>Medications dispensed</span><strong>45</strong></li>
                                <li class="d-flex justify-content-between"><span>Incidents reported</span><strong>4</strong></li>
                                <li class="d-flex justify-content-between"><span>Inventory items restocked</span><strong>8</strong></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <?php
               }
            }
            ?>
        </div>
    </main>

</body>
</html>