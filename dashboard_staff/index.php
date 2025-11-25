<?php
include 'pdo.php';
$oop = new oop_class();

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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .main-content {
            margin-left: 270px; /* same width as sidebar */
            padding: 25px;
        }
    </style>
</head>

<body class="bg-light">

<?php 
    $activePage = 'dashboard'; 
    include '../sidebar/sidebar.php'; 
?>

<div class="main-content">

    <div class="bg-white rounded p-4 shadow-sm">
        
        <!-- Header -->
        <div class="d-flex justify-content-between flex-wrap">
            <div>
                <h2 class="fw-bold mb-1">Welcome, Clinic Staff!</h2>
                <p class="text-muted">Overview of today's activity</p>
            </div>

            <div class="text-muted small">
                Last updated: <?= date('Y-m-d H:i:s'); ?>
            </div>
        </div>

        <!-- ROWS -->
        <div class="row g-4 mt-2">

            <!-- ======= RECENT VISITS ======= -->
            <div class="col-lg-7">
                <h5 class="text-primary mb-2">Recent Visits</h5>

                <div class="table-responsive bg-white rounded shadow-sm p-2">
                    <?php
                    $limit = 5;
                    if ($fetch_studentRecords->rowCount() > 0) {
                        echo '<table class="table table-striped table-hover mb-0 small">';
                        echo '<thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>ID #</th>
                                    <th>Department</th>
                                    <th>Complaint</th>
                                    <th>Date</th>
                                </tr>
                              </thead><tbody>';

                        $count = 0;
                        while ($row = $fetch_studentRecords->fetch(PDO::FETCH_ASSOC)) {
                            if ($count >= $limit) break;

                            echo "<tr>
                                    <td>{$row['ID']}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['idNum']}</td>
                                    <td>{$row['department']}</td>
                                    <td>{$row['complaint']}</td>
                                    <td>{$row['visitDate']}</td>
                                  </tr>";

                            $count++;
                        }

                        echo '</tbody></table>';

                    } else {
                        echo '<div class="p-4 text-center text-muted">No recent visits.</div>';
                    }
                    ?>
                </div>
            </div>

            <!-- ======= INVENTORY SNAPSHOT ======= -->
            <div class="col-lg-5">
                <h5 class="text-primary mb-2 d-flex justify-content-between">
                    Inventory <small class="text-muted">Snapshot</small>
                </h5>

                <div class="table-responsive bg-white rounded shadow-sm p-2">
                    <?php
                    $limit = 5;
                    if ($fetch_inventory && $fetch_inventory->rowCount() > 0) {

                        echo '<table class="table table-sm mb-0 small">';
                        echo '<thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Dosage</th>
                                    <th>Brand</th>
                                    <th>Category</th>
                                    <th>Qty</th>
                                    <th>Added</th>
                                    <th>Expiry</th>
                                </tr>
                              </thead><tbody>';

                        $count = 0;
                        while ($row = $fetch_inventory->fetch(PDO::FETCH_ASSOC)) {
                            if ($count >= $limit) break;

                            echo "<tr>
                                    <td>{$row['genericName']}</td>
                                    <td>{$row['dosage']}</td>
                                    <td>{$row['brand']}</td>
                                    <td>{$row['category']}</td>
                                    <td>{$row['quantity']}</td>
                                    <td>{$row['addDate']}</td>
                                    <td>{$row['expDate']}</td>
                                  </tr>";

                            $count++;
                        }

                        echo '</tbody></table>';

                    } else {
                        echo '<div class="p-4 text-center text-muted">No Inventory Records.</div>';
                    }
                    ?>
                </div>
            </div>

            <!-- ======= RECENT TRANSACTIONS ======= -->
            <div class="col-12">
                <h5 class="text-primary mb-2">Recent Transactions</h5>

                <div class="table-responsive bg-white rounded shadow-sm p-2">

                    <?php
                    $limit = 5;
                    if ($fetch_transactions && $fetch_transactions->rowCount() > 0) {

                        echo '<table class="table table-striped table-hover mb-0 small">';
                        echo '<thead class="table-light">
                                <tr>
                                    <th>Qty</th>
                                    <th>Date</th>
                                    <th>Item ID</th>
                                    <th>Student ID</th>
                                </tr>
                              </thead><tbody>';

                        $count = 0;
                        while ($row = $fetch_transactions->fetch(PDO::FETCH_ASSOC)) {
                            if ($count >= $limit) break;

                            echo "<tr>
                                    <td>{$row['quantity']}</td>
                                    <td>{$row['transactionDate']}</td>
                                    <td>{$row['itemID']}</td>
                                    <td>{$row['studentID']}</td>
                                  </tr>";

                            $count++;
                        }

                        echo '</tbody></table>';

                    } else {
                        echo '<div class="p-4 text-center text-muted">No Transactions.</div>';
                    }
                    ?>
                </div>

            </div>

        </div><!-- row -->
    </div><!-- card -->

</div><!-- main-content -->


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
