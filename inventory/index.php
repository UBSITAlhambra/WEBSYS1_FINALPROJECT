<?php
include 'oop.php';
$inventory = new oop_class();
$data = $inventory->show_data();
?>
<?php $activePage = 'inventory'; ?>
<?php include '../sidebar/sidebar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Inventory Table</title>
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

<div class="main-content" style="margin-left: 270px; padding: 25px;">
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
        <th>Actions</th>
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

            <td>
                <a href="update.php?id=<?= $row['itemID'] ?>" class="btn update-btn">Update</a>
                <a href="delete.php?id=<?= $row['itemID'] ?>" class="btn delete-btn"
                   onclick="return confirm('Are you sure you want to delete this item?');">
                   Delete
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<br>
<!-- Add New Item Button -->
<a href="add.php" class="btn add-btn">Add New Item</a>
<!-- Add New Item Button -->
</body>
</html>
