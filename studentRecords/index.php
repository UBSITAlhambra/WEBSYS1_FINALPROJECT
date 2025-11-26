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
       /* CSS Variables matching the Login/Register aesthetic */
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
    margin-left: 250px; /* MATCHES standard sidebar width */
    padding: 30px 40px 0 40px;
    background: var(--light-bg);
    min-height: 100vh;
}
h2 {
    margin-bottom: 26px;
    color: var(--primary-maroon); /* Maroon Heading */
    letter-spacing: 1px;
    text-align: center;
    font-weight: 600;
}
table {
    width: 97%;
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
    text-align: center;
    font-size: 0.95rem;
}
th {
    background: var(--light-bg); /* Lighter header background */
    color: var(--primary-maroon); /* Maroon Header Text */
    font-weight: 700;
    border-bottom: 2px solid var(--primary-maroon); /* Stronger bottom border */
}
tr:nth-child(even) { background: #f7fbfc; }
tr:hover { background: #ffeaea; } /* Light Maroon Hover */
.btn {
    padding: 7px 16px;
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
.btn.add-btn {
    background-color: var(--primary-maroon); /* Maroon for Add */
    color: #fff;
    margin-bottom: 0;
    margin-right: 10px;
    margin-top: 14px;
}
.btn.add-btn:hover { background-color: #a00000; } /* Darker Maroon */
.btn.update-btn {
    background-color: #2e6db4; /* Blue for Edit */
}
.btn.update-btn:hover {
    background-color: #1a4d8c;
}
.btn.delete-btn {
    background-color: #e74c3c; /* Red for Delete */
}
.btn.delete-btn:hover {
    background-color: #c0392b;
}
.table-actions {
    white-space: nowrap;
    min-width: 135px;
    text-align: center;
}
.top-buttons {
     text-align: right; 
     margin-bottom: 10px;
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
                <th>LRN</th>
                <th>Grade & Section</th>
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
    </div>
</body>
</html>
