<?php
include "oop.php";
$oop = new studentVitals();

// // Get ID from URL
// if (!isset($_GET['id'])) {
//     echo "<script>alert('No ID found'); window.location='show_vitals.php';</script>";
//     exit;
// }

$vitalID = $_GET['id'];
$data = $oop->show_update_data($vitalID);
$students = $oop->fetch_students();

// if (!$data) {
//     echo "<script>alert('Record not found'); window.location='show_vitals.php';</script>";
//     exit;
// }

// Handle update
if (isset($_POST['update'])) {
    $oop->update_data(
        $_POST['temperature'],
        $_POST['bloodPressure'],
        $_POST['pulse'],
        $_POST['respiratoryRate'],
        $vitalID
    );
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Student Vitals</title>
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
        select, input[type="text"], input[type="number"], input[type="date"] {
            width: 100%;
            padding: 8px;
            margin: 6px 0 15px 0;
            border-radius: 5px;
            border: 1px solid #aaa;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #2980b9;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #1f6690;
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
        .readonly {
            background: #ddd;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Update Student Vitals</h2>

    <form method="POST">

        <!-- Student (READ ONLY) -->
        <label>Student Name</label>
        <select disabled class="readonly">
            <?php foreach ($students as $s): ?>
                <option 
                    value="<?php echo $s['ID']; ?>"
                    <?php echo ($s['ID'] == $data['studentID']) ? 'selected' : ''; ?>
                >
                    <?php echo htmlspecialchars($s['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Vitals Date</label>
        <input type="date" value="<?php echo $data['vitalDate']; ?>" class="readonly" disabled>

        <label>Temperature (°C)</label>
        <input type="number" step="0.1" name="temperature" value="<?php echo $data['temperature']; ?>" required>

        <label>Blood Pressure</label>
        <input type="text" name="bloodPressure" value="<?php echo $data['bloodPressure']; ?>" required>

        <label>Pulse (BPM)</label>
        <input type="number" name="pulse" value="<?php echo $data['pulse']; ?>" required>

        <label>Respiratory Rate</label>
        <input type="number" name="respiratoryRate" value="<?php echo $data['respiratoryRate']; ?>" required>

        <button type="submit" name="update">Update Vitals</button>
    </form>

    <a href="show_vitals.php" class="back-btn">Back to Records</a>
</div>

</body>
</html>
