<?php
    session_start();
    include "oop.php";
    $oop = new oop_class();

    if (isset($_GET['id'])) {
        $ID = $_GET['id'];
        $show_update_data = $oop->show_update_data($ID);
    }

if (isset($_POST['enter'])) {
    $genericName = $_POST['genericName'] ?? '';
    $dosage = $_POST['dosage'] ?? '';
    $category = $_POST['category'] ?? '';
    $addDate = $_POST['addDate'] ?? '';
    $expDate = $_POST['expDate'] ?? '';
    $expDate = $_POST['quantity'] ?? '';
    $ID = $_POST['id'] ?? '';
    $oop->update_data($genericName, $dosage, $category, $addDate, $expDate, $ID, $quantity);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Update Inventory Item</title>
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
            max-width: 900px;
            animation: fadeIn 0.5s ease-in-out;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
        }
        th {
            background: #4a90e2;
            color: #fff;
            padding: 12px;
            font-size: 0.9rem;
            text-align: center;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        input[type="text"], 
        input[type="date"] {
            width: 95%; 
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: border 0.3s, box-shadow 0.3s;
        }
        input:focus {
            border-color: #4a90e2;
            outline: none;
            box-shadow: 0 0 5px rgba(74,144,226,0.3);
        }
        button {
            width: 100%;
            padding: 12px;
            border: none;
            background: #2ecc71;
            color: #fff;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s, transform 0.1s;
        }
        button:hover {
            background: #27ae60;
        }
        button:active {
            transform: scale(0.98);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
<form method="POST" action="">
    <?php if (!empty($show_update_data)): 
        $row = $show_update_data;
    ?>
    <table>
        <tr>
            <th>Generic Name</th>
            <th>Dosage</th>
            <th>Brand</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Add Date</th>
            <th>Expiry Date</th>
        </tr>
        <tr>
            <td><input type="text" name="genericName" value="<?= htmlspecialchars($row['genericName']) ?>" required></td>
            <td><input type="text" name="dosage" value="<?= htmlspecialchars($row['dosage']) ?>" required></td>
            <td><input type="text" name="quantity" value="<?= htmlspecialchars($row['quantity']) ?>" required></td>
            <td><input type="text" name="category" value="<?= htmlspecialchars($row['category']) ?>" required></td>
            <td><input type="text" name="quantity" value="<?= htmlspecialchars($row['quantity']) ?>" required></td>
            <td><input type="date" name="addDate" value="<?= htmlspecialchars($row['addDate']) ?>" required></td>
            <td><input type="date" name="expDate" value="<?= htmlspecialchars($row['expDate']) ?>" required></td>
        </tr>
    </table>
    <input type="hidden" name="id" value="<?= htmlspecialchars($row['itemID']) ?>">
    <button name="enter">Update Details</button>
    <?php else: ?>
        <p>No data found for this ID.</p>
    <?php endif; ?>
</form>
</body>
</html>