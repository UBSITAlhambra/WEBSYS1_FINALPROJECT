<?php
include "oop.php";
$oop = new oop_class();
$data = $oop->show_data();
$activePage = 'transaction';
include '../sidebar/sidebar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaction Records</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .main-content {
            margin-left: 220px; /* Adjust if your sidebar width is different */
            padding: 30px 40px 0 40px;
            background: #fafcff;
            min-height: 100vh;
        }
        h2 {
            text-align: center;
            margin-bottom: 26px;
            color: #2b303a;
            letter-spacing: 1px;
        }
        table {
            width: 95%;
            border-collapse: collapse;
            margin: 0 auto 18px auto;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 14px rgba(0,0,0,0.08);
        }
        th, td {
            border: 1px solid #eaeaea;
            padding: 12px 12px;
            text-align: center;
        }
        th {
            background: #f0f4fb;
            color: #222;
            font-weight: 600;
        }
        tr:nth-child(even) { background: #f7fbfc; }
        tr:hover { background: #e7f7ff; }
        .btn {
            padding: 7px 16px;
            border-radius: 5px;
            font-size: 15px;
            text-decoration: none;
            color: #fff !important;
            display: inline-block;
            margin: 0 2px;
            font-weight: bold;
            transition: background 0.15s;
            border: none;
        }
        .btn.update { background: #298afc; }
        .btn.update:hover { background: #1765b8; }
        .btn.delete { background: #fb2555; }
        .btn.delete:hover { background: #ab092e; }
        .btn.add-btn {
            background-color: #29c772;
            color: #fff;
            margin-bottom: 0;
            margin-right: 8px;
            margin-top: 14px;
        }
        .btn.add-btn:hover {
            background-color: #178347;
        }
        .table-actions {
            white-space: nowrap;
            min-width: 120px;
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
        <tr>
            <th>Medicine</th>
            <th>Student</th>
            <th>Quantity</th>
            <th>Date</th>
            <th class="table-actions">Action</th>
        </tr>
        <?php if(count($data)): ?>
            <?php foreach ($data as $row) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['medicineName']) ?></td>
                    <td><?= htmlspecialchars($row['studentName']) ?></td>
                    <td><?= htmlspecialchars($row['quantity']) ?></td>
                    <td><?= htmlspecialchars($row['transactionDate']) ?></td>
                    <td>
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
            <tr><td colspan="5" style="color:#b53d3d;font-weight:bold;">No Transaction Records Found.</td></tr>
        <?php endif; ?>
    </table>
    <a href="add.php" class="btn add-btn">➕ Add New Item</a>
</div>
</body>
</html>
