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

</body>
</html>
