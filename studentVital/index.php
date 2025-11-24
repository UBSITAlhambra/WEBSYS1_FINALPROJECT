<?php
include "oop.php";
$studentVitals = new studentVitals();
$data = $studentVitals->show_data();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Vitals Records</title>
    <style>
        body {
            font-family: Arial;
            background: #f7f7f7;
        }
        .container {
            width: 85%;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px #ccc;
        }
        table { 
            border-collapse: collapse; 
            width: 100%; 
            margin-top: 10px;
        }
        th, td { 
            border: 1px solid #999; 
            padding: 8px; 
            text-align: center; 
        }
        th { 
            background-color: #f2f2f2; 
        }

        .btn {
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            color: white;
        }
        .add-btn {
            background-color: #27ae60;
            padding: 10px 16px;
            display: inline-block;
        }
        .edit-btn {
            background-color: #2980b9;
        }
        .delete-btn {
            background-color: #c0392b;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    
<div class="container">

    <h2>Student Vitals Records</h2>



    <table>
        <tr>
            <th>Vital ID</th>
            <th>Student Name</th>
            <th>Date</th>
            <th>Temperature</th>
            <th>Blood Pressure</th>
            <th>Pulse</th>
            <th>Respiratory Rate</th>
            <th>Actions</th>
        </tr>

        <?php if (count($data) > 0): ?>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['vitalID']) ?></td>
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
                <td colspan="8">No vitals data found.</td>
            </tr>
        <?php endif; ?>
    </table>

    <br>
    <a href="../dashboard_staff/" class="btn add-btn" style="background:#7f8c8d;">Dashboard</a>
        <!-- Add Button -->
        <a href="add.php" class="btn add-btn">Add New Vital Record</a>

</div>

</body>
</html>
