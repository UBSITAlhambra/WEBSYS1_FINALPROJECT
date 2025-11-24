<?php
include 'oop.php';
$student = new oop_class();
$data = $student->show_data();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Student Clinic Records</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn {
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }
        .add-btn {
            background-color: #4CAF50;
            color: white;
            margin-bottom: 10px;
            display: inline-block;
        }
        .update-btn {
            background-color: #2196F3;
            color: white;
        }
        .delete-btn {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>

<h2>Student Clinic Records</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>ID Number</th>
        <th>Department</th>
        <th>Complaint</th>
        <th>Visit Date</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($data as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['ID']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['idNum']) ?></td>
            <td><?= htmlspecialchars($row['department']) ?></td>
            <td><?= htmlspecialchars($row['complaint']) ?></td>
            <td><?= htmlspecialchars($row['visitDate']) ?></td>
            <td>
                <a href="update.php?id=<?= $row['ID'] ?>">Edit</a> | 
                <a href="delete.php?id=<?= $row['ID'] ?>" onclick="return confirm('Delete this record?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>

</table>
<br>
<!-- Add New Item Button -->
<a href="add.php" class="btn add-btn">Add New Item</a>
<!-- Add New Item Button -->
<a href="../dashboard_staff/" class="btn add-btn">Dashboard</a>
<a href="../transaction/" class="btn add-btn">Create Transaction</a>
<a href="../studentVital/" class="btn add-btn">Student Vitals</a>
</body>
</html>
