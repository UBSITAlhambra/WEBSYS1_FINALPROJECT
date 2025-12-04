<?php
session_start();
include "oop.php";
$oop = new oop_class();
$activePage = 'transaction';
include '../sidebar/sidebar.php';
    if(!isset($_SESSION['user_id'])){
        header('Location: ../login/');
    }
$medicineName = '';
$studentName  = '';
$row = null;

// Fetch existing transaction
if (isset($_GET['id'])) {
    $transactionID = $_GET['id'];
    $row = $oop->show_update_data($transactionID);

    if ($row) {
        $conn = $oop->get_connection();
        // Get medicine name from inventory
        $stmt = $conn->prepare("SELECT genericName FROM inventory WHERE itemID = :id LIMIT 1");
        $stmt->execute([':id' => $row['itemID']]);
        $medicineName = $stmt->fetchColumn() ?: '';

        // Get student name from studentrecord
        $stmt = $conn->prepare("SELECT name FROM studentrecord WHERE ID = :id LIMIT 1");
        $stmt->execute([':id' => $row['studentID']]);
        $studentName = $stmt->fetchColumn() ?: '';
    }
}

// Handle update submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $quantity        = $_POST['quantity'] ?? '';
    $transactionDate = $_POST['transactionDate'] ?? '';
    $medicineName    = $_POST['medicineName'] ?? '';
    $studentName     = $_POST['studentName'] ?? '';
    $remarks         = $_POST['remarks'] ?? '';
    $transactionID   = $_POST['transactionID'] ?? '';

    if ($quantity && $transactionDate && $medicineName && $studentName && $transactionID) {
        $oop->update_data($quantity, $transactionDate, $medicineName, $studentName, $remarks, $transactionID);
        // after update the function already redirects, so code below is mainly fallback
    } else {
        echo "<script>alert('Please fill in all required fields.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Update Transaction</title>
    <style>
        :root {
            --primary-maroon: #800000;
            --light-bg: #f8f8f8;
            --box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); 
        }
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--light-bg);
        }
        .main-content {
            margin-left: 250px;
            padding: 30px 40px;
            background: var(--light-bg);
            min-height: 100vh;
        }
        h2 {
            margin-bottom: 26px;
            color: var(--primary-maroon);
            letter-spacing: 1px;
            text-align: center;
            font-weight: 600;
        }
        .form-container {
            background: #fff;
            max-width: 700px;
            margin: 0 auto;
            padding: 35px;
            border-radius: 12px;
            box-shadow: var(--box-shadow);
            border: 1px solid #e0e0e0;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-section {
            margin-bottom: 30px;
            padding-bottom: 25px;
            border-bottom: 2px solid #f0f0f0;
        }
        .form-section:last-child {
            border-bottom: none;
        }
        .form-section h3 {
            color: var(--primary-maroon);
            margin-bottom: 15px;
            font-size: 1.2rem;
            font-weight: 600;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
            font-size: 0.95rem;
        }
        input[type="text"], 
        input[type="date"],
        textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1.5px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            box-sizing: border-box;
        }
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        input[type="text"]:focus, 
        input[type="date"]:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary-maroon);
            box-shadow: 0 0 8px rgba(128, 0, 0, 0.2);
        }
        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        .btn {
            flex: 1;
            padding: 14px 20px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }
        .btn-update {
            background: var(--primary-maroon);
            color: #fff;
        }
        .btn-update:hover {
            background: #a00000;
            transform: translateY(-1px);
        }
        .btn-cancel {
            background: #6c757d;
            color: #fff;
        }
        .btn-cancel:hover {
            background: #545b62;
            transform: translateY(-1px);
        }
        @media (max-width: 900px) {
            .main-content { 
                margin-left: 0; 
                padding: 20px; 
            }
            .form-container {
                padding: 25px;
            }
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="main-content">
        <h2>Update Transaction</h2>

        <div class="form-container">
            <?php if (!empty($row)): ?>
                <form method="POST" action="">
                    <!-- Transaction Info -->
                    <div class="form-section">
                        <h3>Transaction Details</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="quantity">Quantity *</label>
                                <input type="text" id="quantity" name="quantity" 
                                       value="<?= htmlspecialchars($row['quantity']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="transactionDate">Transaction Date *</label>
                                <input type="date" id="transactionDate" name="transactionDate" 
                                       value="<?= htmlspecialchars($row['transactionDate']) ?>" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="medicineName">Medicine *</label>
                                <input type="text" id="medicineName" name="medicineName" 
                                       value="<?= htmlspecialchars($medicineName) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="studentName">Student *</label>
                                <input type="text" id="studentName" name="studentName" 
                                       value="<?= htmlspecialchars($studentName) ?>" required>
                            </div>
                        </div>
                    </div>

                    <!-- Remarks -->
                    <div class="form-section">
                        <h3>Treatment / Remarks</h3>
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea id="remarks" name="remarks"
                                      placeholder="Update treatment details or notes."><?= htmlspecialchars($row['remarks'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <input type="hidden" name="transactionID" value="<?= htmlspecialchars($row['transactionID']) ?>">

                    <div class="button-group">
                        <button type="submit" class="btn btn-update">Update Transaction</button>
                        <a href="index.php" class="btn btn-cancel">Cancel</a>
                    </div>
                </form>
            <?php else: ?>
                <p>No transaction found for this ID.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
