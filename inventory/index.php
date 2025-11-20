<?php
include 'oop.php';
$inventory = new oop_class();
$data = $inventory->show_data();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Inventory Table</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
<h2>Inventory List</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Generic Name</th>
        <th>Dosage</th>
        <th>Brand</th>
        <th>Quantity</th>
        <th>Category</th>
        <th>Added Date</th>
        <th>Expiry Date</th>
    </tr>
    <?php foreach ($data as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['itemID']) ?></td>
            <td><?= htmlspecialchars($row['genericName']) ?></td>
            <td><?= htmlspecialchars($row['dosage']) ?></td>
            <td><?= htmlspecialchars($row['brand']) ?></td>
            <td><?= htmlspecialchars($row['quantity']) ?></td>
            <td><?= htmlspecialchars($row['category']) ?></td>
            <td><?= htmlspecialchars($row['addDate']) ?></td>
            <td><?= htmlspecialchars($row['expDate']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
