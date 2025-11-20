<?php
include "oop.php";
$oop = new oop_class();

// Fetch medicine names
$conn = $oop->get_connection();
$medicineStmt = $conn->prepare("SELECT genericName FROM inventory ORDER BY genericName ASC");
$medicineStmt->execute();
$medicines = $medicineStmt->fetchAll(PDO::FETCH_COLUMN);

// Fetch student names
$studentStmt = $conn->prepare("SELECT name FROM studentrecord ORDER BY name ASC");
$studentStmt->execute();
$students = $studentStmt->fetchAll(PDO::FETCH_COLUMN);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $quantity = $_POST['quantity'] ?? '';
    $transactionDate = $_POST['transactionDate'] ?? '';
    $medicineName = $_POST['medicineName'] ?? '';
    $studentName = $_POST['studentName'] ?? '';

    if ($quantity && $transactionDate && $medicineName && $studentName) {
        $oop->insert_data_by_name($quantity, $transactionDate, $medicineName, $studentName);
    } else {
        echo "<script>alert('Please fill in all fields.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Add Transaction</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #4a90e2, #50c9c3);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background: #fff;
            padding: 34px 32px;
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 420px;
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
        }
        h1 {
            margin-bottom: 22px;
            color: #333;
            font-size: 1.4rem;
            font-weight: 600;
        }
        input[type="text"], input[type="date"], select {
            width: 80%;
            padding: 13px;
            margin: 11px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            text-align: center;
        }
        input:focus, select:focus {
            border-color: #4a90e2;
            outline: none;
            box-shadow: 0 0 6px rgba(74,144,226,0.3);
        }
        button {
            width: 100%;
            padding: 13px;
            border: none;
            background: #2ecc71;
            color: white;
            font-size: 1.05rem;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s, transform 0.1s;
            margin-top: 13px;
        }
        button:hover {
            background: #27ae60;
        }
        button:active {
            transform: scale(0.97);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <form method="POST" action="">
        <h1>Add Transaction</h1>
        <input type="text" name="quantity" placeholder="Quantity" required>
        <input type="date" name="transactionDate" placeholder="Transaction Date" required>
        <select name="medicineName" required>
            <option value="">-- Select Medicine --</option>
            <?php foreach ($medicines as $medicine): ?>
                <option value="<?= htmlspecialchars($medicine) ?>"><?= htmlspecialchars($medicine) ?></option>
            <?php endforeach; ?>
        </select>
        <select name="studentName" required>
            <option value="">-- Select Student --</option>
            <?php foreach ($students as $student): ?>
                <option value="<?= htmlspecialchars($student) ?>"><?= htmlspecialchars($student) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">➕ ADD</button>
    </form>
</body>
</html>
