<?php
include "oop.php";
$studentVitals = new studentVitals();
$data = $studentVitals->show_data();
$activePage = 'vitals';
include '../sidebar/sidebar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Vitals Records</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #fafcff;
        }
        .main-content {
            margin-left: 220px; /* Match your sidebar width */
            padding: 30px 40px 0 40px;
            min-height: 100vh;
        }
        h2 {
            margin-bottom: 26px;
            color: #2b303a;
            letter-spacing: 1px;
            text-align: center;
        }
        table {
            width: 98%;
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
            padding: 8px 16px;
            border-radius: 4.5px;
            font-size: 15px;
            text-decoration: none;
            color: #fff !important;
            display: inline-block;
            margin: 0 2px;
            font-weight: bold;
            border: none;
            transition: background 0.15s;
        }
        .add-btn {
            background-color: #29c772;
            color: #fff;
            margin-bottom: 0;
            margin-right: 10px;
            margin-top: 14px;
        }
        .add-btn:hover { background-color: #178347; }
        .edit-btn { background-color: #298afc; }
        .edit-btn:hover { background-color: #1765b8; }
        .delete-btn { background-color: #fb2555; }
        .delete-btn:hover { background-color: #ab092e; }
        .table-actions {
            white-space: nowrap;
            min-width: 135px;
        }
        @media (max-width: 900px) {
            .main-content { margin-left: 0; padding: 12px; }
            table { width: 98%; }
        }
    </style>
</head>
<body>
<div class="main-content">
    <h2>Student Vitals Records</h2>
    <table>
        <tr>
            <th>Student Name</th>
            <th>Date</th>
            <th>Temperature</th>
            <th>Blood Pressure</th>
            <th>Pulse</th>
            <th>Respiratory Rate</th>
            <th class="table-actions">Actions</th>
        </tr>
        <?php if (count($data) > 0): ?>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['studentName']) ?></td>
                    <td><?= htmlspecialchars($row['vitalDate']) ?></td>
                    <td><?= htmlspecialchars($row['temperature']) ?></td>
                    <td><?= htmlspecialchars($row['bloodPressure']) ?></td>
                    <td><?= htmlspecialchars($row['pulse']) ?></td>
                    <td><?= htmlspecialchars($row['respiratoryRate']) ?></td>
                    <td>
                        <a href="update.php?id=<?= $row['vitalID'] ?>" class="btn edit-btn">Edit</a>
                        <a href="delete.php?id=<?= $row['vitalID'] ?>" class="btn delete-btn"
                           onclick="return confirm('Do you want to delete this record?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" style="color:#b53d3d;font-weight:bold;">No vitals data found.</td>
            </tr>
        <?php endif; ?>
    </table>
    <a href="add.php" class="btn add-btn">➕ Add New Vital Record</a>
</div>
</body>
</html>
