<?php
include "oop.php";
$oop = new studentVitals();

// Fetch students via OOP
$students = $oop->fetch_students();

// Insert record
if (isset($_POST['save'])) {
    $oop->insert_data(
        $_POST['studentID'],
        $_POST['vitalDate'],
        $_POST['temperature'],
        $_POST['bloodPressure'],
        $_POST['pulse'],
        $_POST['respiratoryRate']
    );
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student Vitals</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
        }
        .container {
            width: 450px;
            margin: 40px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px #ccc;
        }
        h2 {
            text-align: center;
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
        }
        select, input[type="text"], input[type="date"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin: 6px 0 15px 0;
            border-radius: 5px;
            border: 1px solid #aaa;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #1f8a4d;
        }
        .back-btn {
            display: block;
            text-align: center;
            margin-top: 12px;
            text-decoration: none;
            color: #333;
        }
        .back-btn:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Add Student Vitals</h2>

    <form method="POST">

        <!-- Student Dropdown -->
        <label>Student Name</label>
        <select name="studentID" required>
            <option value="">-- Select Student --</option>
            <?php foreach ($students as $s): ?>
                <option value="<?php echo $s['ID']; ?>">
                    <?php echo htmlspecialchars($s['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Vitals Date</label>
        <input type="date" name="vitalDate" required>

        <label>Temperature (°C)</label>
        <input type="number" step="0.1" name="temperature" required>

        <label>Blood Pressure (e.g. 120/80)</label>
        <input type="text" name="bloodPressure" required>

        <label>Pulse (BPM)</label>
        <input type="number" name="pulse" required>

        <label>Respiratory Rate (per min)</label>
        <input type="number" name="respiratoryRate" required>

        <button type="submit" name="save">Save Vitals</button>
    </form>

    <a href="show_vitals.php" class="back-btn">Back to Records</a>
</div>

</body>
</html>
