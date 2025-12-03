<?php
include "oop.php";
$oop = new oop_class();
$data = $oop->show_data();
$activePage = 'transaction';
// Ensure the sidebar is included and loads Bootstrap/Auth Guard
include '../sidebar/sidebar.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaction Records</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <style>
        /* Define the maroon variables and general styles */
        :root {
            --primary-maroon: #800000;
            --light-bg: #f8f8f8;
            --box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); 
        }
        
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Consistent Font */
            background: var(--light-bg);
        }
        
        .main-content {
            margin-left: 250px; /* CORRECTED: Match sidebar width */
            padding: 30px 40px 0 40px;
            background: var(--light-bg);
            min-height: 100vh;
        }
        
        h2 {
            text-align: center;
            margin-bottom: 26px;
            color: var(--primary-maroon); /* Maroon Heading */
            font-weight: 600;
            letter-spacing: 1px;
        }
        
        table {
            width: 95%;
            border-collapse: collapse;
            margin: 0 auto 18px auto;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--box-shadow); /* Consistent shadow */
        }
        
        th, td {
            border: 1px solid #eaeaea;
            padding: 12px 12px;
            text-align: left; /* Left align content for readability */
            font-size: 0.95rem;
        }
        
        th {
            background: var(--light-bg); /* Lighter header background */
            color: var(--primary-maroon); /* Maroon Header Text */
            font-weight: 700;
            border-bottom: 2px solid var(--primary-maroon); /* Stronger bottom border */
            text-align: center;
        }
        
        tr:nth-child(even) { background: #f7fbfc; }
        tr:hover { background: #ffeaea; } /* Light Maroon Hover */
        
        .btn {
            padding: 7px 14px; /* Slightly adjusted padding */
            border-radius: 5px;
            font-size: 14px;
            text-decoration: none;
            color: #fff !important;
            display: inline-block;
            margin: 0 2px;
            font-weight: 600;
            transition: background 0.15s;
            border: none;
        }
        
        /* Action Button Styling */
        .btn.update { background: #2e6db4; } /* Blue for Update */
        .btn.update:hover { background: #1a4d8c; }
        
        .btn.delete { background: #e74c3c; } /* Red for Delete */
        .btn.delete:hover { background: #c0392b; }
        
        .btn.add-btn {
            background-color: var(--primary-maroon); /* Maroon for Add */
            color: #fff;
            margin-bottom: 0;
            margin-right: 8px;
            margin-top: 14px;
            font-size: 15px;
        }
        .btn.add-btn:hover {
            background-color: #a00000;
        }
        
        .table-actions {
            white-space: nowrap;
            min-width: 120px;
            text-align: center;
        }
        
        @media (max-width: 900px) {
            .main-content { margin-left: 0; padding: 12px; }
            table { width: 98%; }
        }
    </style>
</head>
<body>
<div class="main-content">
    <h2>Transaction Records</h2>
    <table>
        <thead>
        <tr>
            <th>Student</th> 
            <th>Medicine</th>
            <th>Quantity</th>
            <th>Remarks</th>
            <th>Date</th>
            <th class="table-actions">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php if(count($data)): ?>
            <?php foreach ($data as $row) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['studentName']) ?></td>
                    <td><?= htmlspecialchars($row['medicineName']) ?></td>
                    <td><?= htmlspecialchars($row['quantity']) ?></td>
                    <td><?= htmlspecialchars($row['remarks']) ?></td>
                    <td><?= htmlspecialchars($row['transactionDate']) ?></td>
                    <td class="table-actions">
                        <a class="btn update" href="update.php?id=<?= $row['transactionID']; ?>">Update</a>
                        <a class="btn delete"
                           href="delete.php?id=<?= $row['transactionID']; ?>"
                           onclick="return confirm('Delete this record?');">
                           Delete
                        </a>
                    </td>
                </tr>
            <?php } ?>
        <?php else: ?>
            <tr><td colspan="6" style="color:var(--primary-maroon);font-weight:bold;">No Transaction Records Found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
    <a href="add.php" class="btn add-btn">Add New Transaction</a>
</div>
</body>
</html>