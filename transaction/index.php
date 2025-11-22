<?php
include "oop.php";
$oop = new oop_class();
$data = $oop->show_data();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaction Records</title>
    <style>
        table {
            width: 90%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        table, th, td {
            border: 1px solid black;
            padding: 10px;
        }
        th {
            background: #f3f3f3;
        }
        a.btn {
            padding: 5px 10px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        a.btn.delete {
            background: red;
        }
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
    </style>
</head>
<body>

<h2 style="text-align:center;">Transaction Records</h2>

<table>
    <tr>
        <th>Medicine</th>
        <th>Student</th>
        <th>Quantity</th>
        <th>Date</th>
        <th>Action</th>
    </tr>

    <?php foreach ($data as $row) { ?>
        <tr>
            <td><?= $row['medicineName']; ?></td>
            <td><?= $row['studentName']; ?></td>
            <td><?= $row['quantity']; ?></td>
            <td><?= $row['transactionDate']; ?></td>

            <td>
                <a class="btn" href="update.php?id=<?= $row['transactionID']; ?>">Update</a>
                <a class="btn delete" 
                   href="delete.php?id=<?= $row['transactionID']; ?>" 
                   onclick="return confirm('Delete this record?');">
                   Delete
                </a>
            </td>
        </tr>
    <?php } ?>

    
</table>
<br>
<!-- Add New Item Button -->
<a href="add.php" class="btn add-btn">Add New Item</a>
<!-- Add New Item Button -->
<a href="#" class="btn add-btn">Home</a>
</body>
</html>
