<?php
include 'pdo.php';
$oop = new oop_class();

$fetch_inventory = $oop->show_inventory();
$fetch_studentRecords = $oop->show_studentRecords();
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
    /* CSS Variables matching the Login/Register aesthetic */
:root {
    --primary-maroon: #800000; /* Deep Maroon */
    --light-bg: #f8f8f8;
    --box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); 
}
 
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: var(--light-bg);
}

.main-content {
    margin-left: 270px; /* Preserve sidebar spacing */
    padding: 25px;
}
 
/* General styling for cards and tables */
.rounded {
    border-radius: 8px !important;
}
.shadow-sm {
    box-shadow: var(--box-shadow) !important;
    transition: box-shadow 0.3s ease-in-out;
}

/* Titles and Colors */
.text-primary {
    color: var(--primary-maroon) !important;
}
.fw-bold { font-weight: 600 !important; }

/* Search Bar Styling */
.search-bar {
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 14px 0 24px 0;
}
#searchBox {
    padding: 10px 17px;
    font-size: 15px;
    width: 260px;
    border-radius: 5px;
    border: 1px solid #ccc;
    margin-right: 8px;
}
#Searchresult {
    margin-bottom: 18px;
    min-height: 38px;
    width: 65%;
    margin-left: auto;
    margin-right: auto;
}

/* Maroon Search Button */
button.search-btn {
    padding: 10px 18px;
    background: var(--primary-maroon); /* Maroon background */
    color: #fff;
    border: none;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.2s;
}
button.search-btn:hover {
    background: #a00000; /* Darker maroon on hover */
}

/* Summary Cards */
.col-md-3 > div {
    border: 1px solid #ddd;
    transition: transform 0.2s;
}
.col-md-3 > div:hover {
    transform: translateY(-3px); /* Lift effect on hover */
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
}

/* Table Styling */
.table-light {
    background-color: var(--light-bg) !important;
    border-bottom: 2px solid var(--primary-maroon);
}
.table-striped > tbody > tr:nth-of-type(odd) > * {
    background-color: #f5f5f5; /* Light gray for alternating rows */
}
.table-hover tbody tr:hover td {
    background-color: #ffeaea; /* Very light pink/maroon hue on hover */
}
    </style>
</head>
<body class="bg-light">
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
            <!-- WEEKLY SUMMARY -->
            <div class="col-12 mb-3">
                <h5 class="text-primary mb-2">Weekly Summary</h5>
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="bg-white p-3 rounded shadow-sm">
                            <h6 class="text-muted">Visits This Week</h6>
                            <div class="fs-3 fw-bold text-primary"><?= $weekly_visits ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="bg-white p-3 rounded shadow-sm">
                            <h6 class="text-muted">Items Used</h6>
                            <div class="fs-3 fw-bold text-success"><?= $weekly_items_used ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="bg-white p-3 rounded shadow-sm">
                            <h6 class="text-muted">New Items Added</h6>
                            <div class="fs-3 fw-bold text-warning"><?= $weekly_new_inventory ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="bg-white p-3 rounded shadow-sm">
                            <h6 class="text-muted">Top Complaint</h6>
                            <div class="fw-bold"><?= $common_complaint ?></div>
                        </div>
                    </div>
                </div>
            </div>

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
<!-- ======= AJAX SEARCH BAR ======= -->
    <div class="search-bar">
        <input type="text" id="searchBox" placeholder="Enter Student LRN" oninput="ajaxSearch(this.value)">
        <button class="search-btn" onclick="ajaxSearch()">Search</button>
    </div>
    <div id="Searchresult"></div>
</body>
</html>
