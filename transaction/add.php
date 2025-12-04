<?php
session_start();
include "oop.php";
$oop = new oop_class();
$activePage = 'transaction';
include '../sidebar/sidebar.php';
    if(!isset($_SESSION['user_id'])){
        header('Location: ../login/');
    }
// Fetch medicine names
$conn = $oop->get_connection();
$medicineStmt = $conn->prepare("SELECT genericName FROM inventory ORDER BY genericName ASC");
$medicineStmt->execute();
$medicines = $medicineStmt->fetchAll(PDO::FETCH_COLUMN);

// Fetch student names + visitDate (MOST RECENT FIRST)
$studentStmt = $conn->prepare("SELECT name, visitDate FROM studentrecord ORDER BY visitDate DESC limit 5");
$studentStmt->execute();
$students = $studentStmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $quantity        = $_POST['quantity'] ?? '';
    $transactionDate = $_POST['transactionDate'] ?? '';
    $medicineName    = $_POST['medicineName'] ?? '';
    $studentName     = $_POST['studentName'] ?? '';
    $remarks         = $_POST['remarks'] ?? '';

    if ($quantity && $transactionDate && $medicineName && $studentName) {
        $oop->insert_data_by_name($quantity, $transactionDate, $medicineName, $studentName, $remarks);
    } else {
        echo "<script>alert('Please fill in all required fields.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Add New Treatment</title>
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
        select,
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
        select:focus,
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
        .btn-add {
            background: var(--primary-maroon);
            color: #fff;
        }
        .btn-add:hover {
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
        <h2>Add New Treatment</h2>
        
        <div class="form-container">
            <form method="POST" action="">
                <!-- Transaction Info -->
                <div class="form-section">
                    <h3>Treatment Details</h3>
                     <div class="form-row">
                        <div class="form-group">
                            <label for="medicineName">Medicine *</label>
                            <select id="medicineName" name="medicineName" required>
                                <option value="" disabled selected>-- Select Medicine --</option>
                                <?php foreach ($medicines as $medicine): ?>
                                    <option value="<?= htmlspecialchars($medicine) ?>">
                                        <?= htmlspecialchars($medicine) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="studentName">Student *</label>
                            <select id="studentName" name="studentName" required>
                                <option value="" disabled selected>-- Select Student --</option>
                                <?php foreach ($students as $student): ?>
                                    <option value="<?= htmlspecialchars($student['name']) ?>">
                                        <?= htmlspecialchars($student['name'] . " – " . $student['visitDate']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="quantity">Quantity *</label>
                            <input type="text" id="quantity" name="quantity" required>
                        </div>
                        <div class="form-group">
                            <label for="transactionDate">Treatment Date *</label>
                            <input type="date" id="transactionDate" name="transactionDate" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>
                   
                </div>

                <!-- Remarks Section -->
                <div class="form-section">
                    <h3>Treatment / Remarks (Optional)</h3>
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <textarea id="remarks" name="remarks" placeholder="e.g., Given 1 tablet of paracetamol, advised rest and hydration."></textarea>
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" name="add" class="btn btn-add">Finish Treatment</button>
                    <a href="index.php" class="btn btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
