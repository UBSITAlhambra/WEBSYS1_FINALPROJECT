<?php
session_start();
include "oop.php";
$oop = new oop_class();

// Fetch the record to update
if (isset($_GET['id'])) {
    $ID = $_GET['id'];
    $show_update_data = $oop->show_update_data($ID);
}

// Handle form submission
if (isset($_POST['enter'])) {
    $name = $_POST['name'] ?? '';
    $idNum = $_POST['idNum'] ?? '';
    $department = $_POST['department'] ?? '';
    $complaint = $_POST['complaint'] ?? '';
    $visitDate = $_POST['visitDate'] ?? '';
    $ID = $_POST['id'] ?? '';

    $oop->update_data($name, $idNum, $department, $complaint, $visitDate, $ID);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Update Clinic Record</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #6a0dad, #ffffff);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        form {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
            animation: fadeIn 0.5s ease-in-out;
        }
        h1 { text-align: center; margin-bottom: 20px; color: #333; }
        input[type="text"], input[type="date"] {
            width: 90%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
        }
        button {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border: none;
            background: #2ecc71;
            color: #fff;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
        }
        button:hover { background: #27ae60; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<form method="POST" action="">
    <h1>Update Clinic Record</h1>

    <?php if (!empty($show_update_data)): 
        $row = $show_update_data;
    ?>
        <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" placeholder="Student Name" required>
        <input type="text" name="idNum" value="<?= htmlspecialchars($row['idNum']) ?>" placeholder="Student ID Number" required>
        <input type="text" name="department" value="<?= htmlspecialchars($row['department']) ?>" placeholder="Department" required>
        <input type="text" name="complaint" value="<?= htmlspecialchars($row['complaint']) ?>" placeholder="Complaint" required>
        <input type="date" name="visitDate" value="<?= htmlspecialchars($row['visitDate']) ?>" placeholder="Visit Date" required>

        <input type="hidden" name="id" value="<?= htmlspecialchars($row['ID']) ?>">

        <button name="enter">Update Record</button>
    <?php else: ?>
        <p>No data found for this ID.</p>
    <?php endif; ?>
</form>

</body>
</html>
