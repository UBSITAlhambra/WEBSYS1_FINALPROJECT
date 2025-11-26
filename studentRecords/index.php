<?php
include 'oop.php';
$student = new oop_class();
$data = $student->show_data();
$activePage = 'visits';
include '../sidebar/sidebar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Student Clinic Records</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .main-content {
            margin-left: 220px; /* Adjust if your sidebar is wider/narrower */
            padding: 30px 40px 0 40px;
            background: #fafcff;
            min-height: 100vh;
        }
        h2 {
            margin-bottom: 26px;
            color: #2b303a;
            letter-spacing: 1px;
            text-align: center;
        }
        table {
            width: 97%;
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
        .btn.add-btn {
            background-color: #29c772;
            color: #fff;
            margin-bottom: 0;
            margin-right: 10px;
            margin-top: 14px;
        }
        .btn.add-btn:hover { background-color: #178347; }
        .btn.update-btn {
            background-color: #298afc;
        }
        .btn.update-btn:hover {
            background-color: #1765b8;
        }
        .btn.delete-btn {
            background-color: #fb2555;
        }
        .btn.delete-btn:hover {
            background-color: #ab092e;
        }
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
        <h2>Student Clinic Records</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>ID Number</th>
                <th>Department</th>
                <th>Complaint</th>
                <th>Visit Date</th>
                <th class="table-actions">Actions</th>
            </tr>
            <?php if(count($data)): ?>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['idNum']) ?></td>
                        <td><?= htmlspecialchars($row['department']) ?></td>
                        <td><?= htmlspecialchars($row['complaint']) ?></td>
                        <td><?= htmlspecialchars($row['visitDate']) ?></td>
                        <td>
                            <a href="update.php?id=<?= $row['ID'] ?>" class="btn update-btn">Edit</a>
                            <a href="delete.php?id=<?= $row['ID'] ?>" class="btn delete-btn"
                               onclick="return confirm('Delete this record?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="color:#b53d3d;font-weight:bold;">No Student Clinic Records Found.</td>
                </tr>
            <?php endif; ?>
        </table>
        <a href="add.php" class="btn add-btn"> Add New Student</a>
        <a href="../transaction/" class="btn add-btn" style="background:#2977f6;">View Transaction</a>
    </div>
</body>
</html>
