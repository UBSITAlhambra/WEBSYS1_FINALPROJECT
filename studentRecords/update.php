<?php
session_start();
include "oop.php";
$oop = new oop_class();
$activePage = 'visits';
include '../sidebar/sidebar.php';

// Fetch the record to update (with vitals)
$show_update_data = null;
if (isset($_GET['id'])) {
    $ID = $_GET['id'];
    $show_update_data = $oop->show_update_data_with_vitals($ID);
}

// Handle form submission
if (isset($_POST['enter'])) {
    $name = $_POST['name'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $idNum = $_POST['idNum'] ?? '';
    $department = $_POST['department'] ?? '';
    $complaint = $_POST['complaint'] ?? '';
    $visitDate = $_POST['visitDate'] ?? '';
    $ID = $_POST['id'] ?? '';
    
    $temperature = $_POST['temperature'] ?? null;
    $bloodPressure = $_POST['bloodPressure'] ?? null;
    $pulse = $_POST['pulse'] ?? null;
    $respiratoryRate = $_POST['respiratoryRate'] ?? null;
    $vitalDate = $_POST['vitalDate'] ?? date('Y-m-d');

    $oop->update_data_with_vitals($name, $gender, $idNum, $department, $complaint, $visitDate, $ID, $temperature, $bloodPressure, $pulse, $respiratoryRate, $vitalDate);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Update Clinic Record</title>
    <style>
        /* CSS Variables matching index.php */
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
        input[type="number"],
        select {
            width: 100%;
            padding: 12px 15px;
            border: 1.5px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            box-sizing: border-box;
        }
        input[type="text"]:focus, 
        input[type="date"]:focus,
        input[type="number"]:focus,
        select:focus {
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
        .no-data {
            text-align: center;
            padding: 50px;
            color: #666;
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
        <h2>Update Clinic Record</h2>
        
        <?php if (!empty($show_update_data)): 
            $row = $show_update_data;
        ?>
            <div class="form-container">
                <form method="POST" action="">
                    <!-- Student Record Section -->
                    <div class="form-section">
                        <h3>Student Information</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Student Name</label>
                                <input type="text" id="name" name="name" value="<?= htmlspecialchars($row['name']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select id="gender" name="gender" required>
                                    <option value="" disabled <?= empty($row['gender']) ? 'selected' : '' ?>>Select Gender</option>
                                    <option value="Male" <?= ($row['gender'] ?? '') === 'Male' ? 'selected' : '' ?>>Male</option>
                                    <option value="Female" <?= ($row['gender'] ?? '') === 'Female' ? 'selected' : '' ?>>Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="idNum">Student ID Number (LRN)</label>
                                <input type="text" id="idNum" name="idNum" value="<?= htmlspecialchars($row['idNum']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="department">Grade & Section</label>
                                <input type="text" id="department" name="department" value="<?= htmlspecialchars($row['department']) ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="complaint">Complaint</label>
                            <select id="complaint" name="complaint" required>
                                <option value="" disabled>Select Complaint</option>
                                <option value="Fever" <?= $row['complaint'] == 'Fever' ? 'selected' : '' ?>>Fever</option>
                                <option value="Stomach ache" <?= $row['complaint'] == 'Stomach ache' ? 'selected' : '' ?>>Stomach ache</option>
                                <option value="Menstrual pains (dysmenorrhea)" <?= $row['complaint'] == 'Menstrual pains (dysmenorrhea)' ? 'selected' : '' ?>>Menstrual pains (dysmenorrhea)</option>
                                <option value="Headache" <?= $row['complaint'] == 'Headache' ? 'selected' : '' ?>>Headache</option>
                                <option value="Sore throat" <?= $row['complaint'] == 'Sore throat' ? 'selected' : '' ?>>Sore throat</option>
                                <option value="Cough and cold symptoms" <?= $row['complaint'] == 'Cough and cold symptoms' ? 'selected' : '' ?>>Cough and cold symptoms</option>
                                <option value="Minor injuries (sprains, cuts, bruises)" <?= $row['complaint'] == 'Minor injuries (sprains, cuts, bruises)' ? 'selected' : '' ?>>Minor injuries</option>
                                <option value="Dizziness or fainting" <?= $row['complaint'] == 'Dizziness or fainting' ? 'selected' : '' ?>>Dizziness or fainting</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="visitDate">Visit Date</label>
                            <input type="date" id="visitDate" name="visitDate" value="<?= htmlspecialchars($row['visitDate']) ?>" required>
                        </div>
                    </div>

                    <!-- Vitals Section -->
                    <div class="form-section">
                        <h3>Vital Signs</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="temperature">Temperature (°C)</label>
                                <input type="number" step="0.1" id="temperature" name="temperature" value="<?= $row['temperature'] ?: '' ?>" min="30" max="42">
                            </div>
                            <div class="form-group">
                                <label for="bloodPressure">Blood Pressure</label>
                                <input type="text" id="bloodPressure" name="bloodPressure" value="<?= htmlspecialchars($row['bloodPressure'] ?: '') ?>" placeholder="120/80">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="pulse">Pulse (bpm)</label>
                                <input type="number" id="pulse" name="pulse" value="<?= $row['pulse'] ?: '' ?>" min="40" max="200">
                            </div>
                            <div class="form-group">
                                <label for="respiratoryRate">Respiratory Rate (rpm)</label>
                                <input type="number" id="respiratoryRate" name="respiratoryRate" value="<?= $row['respiratoryRate'] ?: '' ?>" min="10" max="40">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="vitalDate">Vitals Date</label>
                            <input type="date" id="vitalDate" name="vitalDate" value="<?= $row['vitalDate'] ?: date('Y-m-d') ?>">
                        </div>
                    </div>

                    <input type="hidden" name="id" value="<?= htmlspecialchars($row['ID']) ?>">

                    <div class="button-group">
                        <button type="submit" name="enter" class="btn btn-update">Update Record</button>
                        <a href="index.php" class="btn btn-cancel">Cancel</a>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <div class="no-data">
                <h3>No Record Found</h3>
                <p>The requested record could not be found. <a href="index.php">Return to records</a></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
