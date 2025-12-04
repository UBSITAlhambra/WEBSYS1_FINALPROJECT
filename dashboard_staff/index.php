.<?php
    session_start();
    include 'pdo.php';
    $oop = new oop_class();
    if(!isset($_SESSION['user_id'])){
        header('Location: ../login/');
    }
    //NOTIFICATION
    $low_stock_items = $oop->get_low_stock_items(50); 
    $expiring_items = $oop->get_expiring_items(90);
    $total_alerts = count($low_stock_items) + count($expiring_items);

    $fetch_inventory = $oop->show_inventory();
    $fetch_studentRecords = $oop->show_studentRecords_with_vitals(); // must be with vitals
    $fetch_transactions = $oop->show_transactions();

    $weekly_visits = $oop->get_weekly_visits()->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    $weekly_items_used = $oop->get_items_used_weekly()->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    $weekly_new_inventory = $oop->get_new_inventory_weekly()->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    $common_complaint = $oop->get_common_complaint_weekly()->fetch(PDO::FETCH_ASSOC)['complaint'] ?? 'None';

    $activePage = 'dashboard';
    include '../sidebar/sidebar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>School Clinic Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    :root {
        --primary-maroon: #800000;
        --primary-maroon-hover: #a00000;
        --light-bg: #f8f8f8;
        --card-bg: #ffffff;
        --shadow-color: rgba(0, 0, 0, 0.1);
        --text-muted: #6c757d;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: var(--light-bg);
        margin: 0;
        padding: 0;
    }

    .main-content {
        margin-left: 270px;
        padding: 30px 40px;
        min-height: 100vh;
        background-color: var(--light-bg);
    }

    .bg-white {
        background-color: var(--card-bg);
    }

    .rounded {
        border-radius: 10px !important;
    }

    .shadow-sm {
        box-shadow: 0 4px 12px var(--shadow-color);
        transition: box-shadow 0.3s ease-in-out;
    }

    .shadow-sm:hover {
        box-shadow: 0 6px 20px var(--shadow-color);
    }

    h2, h5, h6 {
        color: var(--primary-maroon);
        margin-bottom: 15px;
    }

    .fw-bold {
        font-weight: 700 !important;
    }

    .text-primary {
        color: var(--primary-maroon) !important;
    }

    .text-muted {
        color: var(--text-muted);
    }

    .fs-3 {
        font-size: 2rem;
    }

    .fs-4 {
        font-size: 1.5rem;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -15px;
    }

    .col-md-3, .col-lg-6, .col-12 {
        padding: 0 15px;
        margin-bottom: 30px;
    }

    /* Uniform Summary Cards */
    .col-md-3 > div {
        padding: 25px;
        border: 1px solid #e7e7e7;
        text-align: center;
        cursor: default;
        user-select: none;
        border-radius: 10px;
        height: 140px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

        .col-md-3 > div h6 {
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
        }

    /* Uniform Boxes for Tables */
    .col-lg-6 > .table-responsive,
    .col-12 > .table-responsive {
        background-color: var(--card-bg);
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px 20px;

        min-height: 330px;

        box-shadow: 0 5px 15px rgba(0,0,0,0.05);

        overflow-x: auto;
        overflow-y: auto;
    }

    /* Tables */
    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 0.6rem;
        font-size: 0.85rem;
    }

    .table thead tr th {
        background-color: var(--primary-maroon);
        color: #fff;
        font-weight: 700;
        padding: 10px 12px;
        border-radius: 8px 8px 0 0;
        text-align: left;
        font-size: 0.8rem;
    }

    .table tbody tr {
        background-color: var(--card-bg);
        box-shadow: 0 2px 10px -4px rgba(0,0,0,0.1);
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }

        .table tbody tr:hover {
            background-color: #fff0f0;
        }

    .table tbody tr td {
        padding: 10px 12px;
        vertical-align: middle;
    }

    /* Search Bar */
    .search-bar {
        display: flex;
        justify-content: center;
        margin: 25px 0 35px;
    }

    #searchBox {
        width: 300px;
        padding: 14px 18px;
        font-size: 16px;
        border: 2px solid var(--primary-maroon);
        border-radius: 8px 0 0 8px;
        outline: none;
        transition: border-color 0.3s ease;
    }

    #searchBox:focus {
        border-color: var(--primary-maroon-hover);
        box-shadow: 0 0 8px var(--primary-maroon-hover);
    }

    button.search-btn {
        padding: 14px 26px;
        font-weight: 600;
        background-color: var(--primary-maroon);
        border: none;
        color: #fff;
        border-radius: 0 8px 8px 0;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button.search-btn:hover {
        background-color: var(--primary-maroon-hover);
    }

    @media (max-width: 1200px) {
        .main-content {
            margin-left: 0;
            padding: 20px;
        }
        .col-lg-6, .col-12 {
            flex: 0 0 100%;
            max-width: 100%;
        }
}
</style>
    </style>
</head>
<body class="bg-light">
<div class="main-content">

    <div class="bg-white rounded p-4 shadow-sm">
        
    <!--ALERT-->
        <?php if ($total_alerts > 0): 
            $count_low = count($low_stock_items);
            $plural_s = ($count_low > 1) ? 's' : '';
            ?>
            <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
                <i class="fas fa-exclamation-triangle flex-shrink-0 me-3" style="font-size: 1.5rem;"></i>
                <div>
                    <h4 class="alert-heading mb-1">INVENTORY ALERT (<?= $total_alerts ?> Issue<?= $plural_s ?>)</h4>
                    <?php if (!empty($low_stock_items)): ?>
                        <?php 
                            $count_low = count($low_stock_items);
                            $plural_s = ($count_low > 1) ? 's' : '';
                            $verb_is_are = ($count_low > 1) ? 'are' : 'is';
                        ?>
                        <p class="mb-1">
                            <?= $count_low ?> item<?= $plural_s ?> <?= $verb_is_are ?> low on stock. Check here <a href="../inventory/" class="alert-link">Inventory List</a> now.
                        </p>
                    <?php endif; ?>
                    <?php if (!empty($expiring_items)): ?>
                        <?php 
                            $count_exp = count($expiring_items);
                            $plural_s = ($count_exp > 1) ? 's' : '';
                            $verb_is_are = ($count_exp > 1) ? 'are' : 'is';
                        ?>
                        <p class="mb-0">
                            <?= $count_exp ?> item<?= $plural_s ?> <?= $verb_is_are ?> expiring within 90 days.
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

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
            <!-- AJAX SEARCH BAR -->
            <div class="search-bar">
                <input type="text" id="searchBox" placeholder="Enter Student LRN" oninput="ajaxSearch(this.value)">
                <button class="search-btn" onclick="ajaxSearch()">Search</button>
            </div>
            <div id="Searchresult"></div>

            <!-- WEEKLY SUMMARY -->
            <div class="col-12 mb-3">
                <h5 class="text-primary mb-2">Weekly Summary</h5>
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="bg-white p-3 rounded shadow-sm">
                            <h6 class="text-muted">Visits This Week</h6>
                            <div class="fs-3 fw-bold text-primary"><?= htmlspecialchars($weekly_visits) ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="bg-white p-3 rounded shadow-sm">
                            <h6 class="text-muted">Items Used</h6>
                            <div class="fs-3 fw-bold text-success"><?= htmlspecialchars($weekly_items_used) ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="bg-white p-3 rounded shadow-sm">
                            <h6 class="text-muted">New Items Added</h6>
                            <div class="fs-3 fw-bold text-warning"><?= htmlspecialchars($weekly_new_inventory) ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="bg-white p-3 rounded shadow-sm">
                            <h6 class="text-muted">Top Complaint</h6>
                            <div class="fw-bold"><?= htmlspecialchars($common_complaint) ?></div>
                        </div>
                    </div>
                </div>
            </div>
                     <!-- RECENT VISITS FULL-WIDTH -->
            <div class="col-12">
                <h5 class="text-primary mb-2">Recent Visits</h5>
                <div class="table-responsive bg-white rounded shadow-sm p-2" style="max-height: 350px; overflow-y: auto;">
                    <?php
                    if ($fetch_studentRecords && $fetch_studentRecords->rowCount() > 0) {
                        echo '<table class="table table-striped table-hover mb-0 small">';
                        echo '<thead class="table-light sticky-top" style="background-color: #f8f9fa;">
                                <tr>
                                    <th>Name</th>
                                    <th>Student ID</th>
                                    <th>Gender</th>
                                    <th>Grade & Section</th>
                                    <th>Complaint</th>
                                    <th>Medicine</th>
                                    <th>Quantity</th>
                                    <th>Remarks</th>
                                    <th>Date</th>

                                </tr>
                            </thead><tbody>';
                        $fetch_studentRecords->execute();
                        while ($row = $fetch_studentRecords->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row['name']) . "</td>
                                    <td>" . htmlspecialchars($row['idNum']) . "</td>
                                    <td>" . htmlspecialchars($row['gender'] ?? 'N/A') . "</td>
                                    <td>" . htmlspecialchars($row['department'] . ' - ' . ($row['section'] ?? '')) . "</td>
                                    <td>" . htmlspecialchars($row['complaint']) . "</td>
                                    <td>" . htmlspecialchars($row['genericName'] ?? 'N/A') . "</td>
                                    <td>" . htmlspecialchars($row['quantity'] ?? 'N/A') . "</td>
                                    <td>" . htmlspecialchars($row['remarks'] ?? '') . "</td>
                                    <td>" . date('M j', strtotime($row['visitDate'])) . "</td>
                                </tr>";
                        }
                        echo '</tbody></table>';
                    } else {
                        echo '<div class="p-4 text-center text-muted">No recent visits.</div>';
                    }
                    ?>
                </div>
            </div>               

            <!-- TRANSACTIONS AND INVENTORY SIDE BY SIDE -->
            <div class="col-lg-6">
                <h5 class="text-primary mb-2">Recent Transactions</h5>
                <div class="table-responsive bg-white rounded shadow-sm p-2" style="max-height: 350px; overflow-y: auto;">
                    <?php
                    $limit = 10;
                    if ($fetch_transactions && $fetch_transactions->rowCount() > 0) {
                        echo '<table class="table table-striped table-hover mb-0 small">';
                        echo '<thead class="table-light sticky-top" style="background-color: #f8f9fa;">
                                <tr>
                                    <th>Student Name</th>
                                    <th>Medicine Name</th>
                                    <th>Quantity</th>
                                    <th>Date</th>
                                </tr>
                            </thead><tbody>';
                        $count = 0;
                        $fetch_transactions->execute();
                        while ($row = $fetch_transactions->fetch(PDO::FETCH_ASSOC)) {
                            if ($count >= $limit) break;
                            echo "<tr>
                                    <td>" . htmlspecialchars($row['studentName'] ?? 'N/A') . "</td>
                                    <td>" . htmlspecialchars($row['medicineName'] ?? 'N/A') . "</td>
                                    <td>" . htmlspecialchars($row['quantity']) . "</td>
                                    <td>" . date('M j', strtotime($row['transactionDate'])) . "</td>
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
            <div class="col-lg-6">
                <h5 class="text-primary mb-2 d-flex justify-content-between">
                    Inventory <small class="text-muted">Snapshot</small>
                </h5>
                <div class="table-responsive bg-white rounded shadow-sm p-2" style="max-height: 350px; overflow-y: auto;">
                    <?php
                    $limit = 10;
                    if ($fetch_inventory && $fetch_inventory->rowCount() > 0) {
                        echo '<table class="table table-sm mb-0 small">';
                        echo '<thead class="table-light">
                                <tr>
                                    <th>Name</th>
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
                                    <td>" . htmlspecialchars($row['genericName']) . "</td>
                                    <td>" . htmlspecialchars($row['category']) . "</td>
                                    <td>" . htmlspecialchars($row['quantity']) . "</td>
                                    <td>" . htmlspecialchars($row['addDate']) . "</td>
                                    <td>" . htmlspecialchars($row['expDate']) . "</td>
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

        </div><!-- row -->

    </div><!-- card -->
    
</div><!-- main-content -->

<script>
function ajaxSearch() {
    var id = document.getElementById('searchBox').value.trim();
    if (id === "") {
        document.getElementById("Searchresult").innerHTML = "";
        return;
    }
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("Searchresult").innerHTML = this.responseText;
        }
    };
    xhr.open("GET", "searchStudent.php?idNum=" + encodeURIComponent(id), true);
    xhr.send();
}
</script>

</body>
</html>
