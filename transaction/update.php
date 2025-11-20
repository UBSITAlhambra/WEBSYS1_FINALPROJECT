<?php
include "oop.php";
$oop = new oop_class();

$medicineName = '';
$studentName = '';

if (isset($_GET['id'])) {
    $transactionID = $_GET['id'];
    $row = $oop->show_update_data($transactionID);

    // Look up current medicine and student names
    if ($row) {
        $conn = $oop->get_connection();
        // Get medicine name from inventory
        $stmt = $conn->prepare("SELECT genericName FROM inventory WHERE itemID = :id LIMIT 1");
        $stmt->execute([':id' => $row['itemID']]);
        $medicineName = $stmt->fetchColumn();
        // Get student name from studentrecord
        $stmt = $conn->prepare("SELECT name FROM studentrecord WHERE ID = :id LIMIT 1");
        $stmt->execute([':id' => $row['studentID']]);
        $studentName = $stmt->fetchColumn();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $quantity = $_POST['quantity'] ?? '';
    $transactionDate = $_POST['transactionDate'] ?? '';
    $medicineName = $_POST['medicineName'] ?? '';
    $studentName = $_POST['studentName'] ?? '';
    $transactionID = $_POST['transactionID'] ?? '';

    // Only validate names, not IDs
    if ($quantity && $transactionDate && $medicineName && $studentName && $transactionID) {
        $oop->update_data($quantity, $transactionDate, $medicineName, $studentName, $transactionID);
        // Reload data after update
        $row = $oop->show_update_data($transactionID);
        // Reload names for display
        $conn = $oop->get_connection();
        $stmt = $conn->prepare("SELECT genericName FROM inventory WHERE itemID = :id LIMIT 1");
        $stmt->execute([':id' => $row['itemID']]);
        $medicineName = $stmt->fetchColumn();
        $stmt = $conn->prepare("SELECT name FROM studentrecord WHERE ID = :id LIMIT 1");
        $stmt->execute([':id' => $row['studentID']]);
        $studentName = $stmt->fetchColumn();
    } else {
        echo "<script>alert('Please fill in all fields.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Update Transaction</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #6a0dad, #ffffff);
            margin: 0;
            padding: 30px 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        form {
            background: #fff;
            padding: 34px 32px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.12);
            width: 100%;
            max-width: 420px;
            animation: fadeIn 0.5s ease-in-out;
            text-align: center;
        }
        h1 {
            margin-bottom: 22px;
            color: #333;
            font-size: 1.4rem;
            font-weight: 600;
        }
        input[type="text"],
        input[type="date"] {
            width: 80%;
            padding: 13px;
            margin: 11px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            text-align: center;
        }
        input:focus {
            border-color: #6a0dad;
            outline: none;
            box-shadow: 0 0 6px rgba(106,13,173,0.3);
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
        <h1>Update Transaction</h1>
        <?php if (!empty($row)): ?>
            <input type="text" name="quantity" placeholder="Quantity" value="<?= htmlspecialchars($row['quantity']) ?>" required>
            <input type="date" name="transactionDate" placeholder="Transaction Date" value="<?= htmlspecialchars($row['transactionDate']) ?>" required>
            <input type="text" name="medicineName" placeholder="Medicine Name" value="<?= htmlspecialchars($medicineName) ?>" required>
            <input type="text" name="studentName" placeholder="Student Name" value="<?= htmlspecialchars($studentName) ?>" required>
            <input type="hidden" name="transactionID" value="<?= htmlspecialchars($row['transactionID']) ?>">
            <button type="submit">Update</button>
        <?php else: ?>
            <p>No transaction found for this ID.</p>
        <?php endif; ?>
    </form>
</body>
</html>
