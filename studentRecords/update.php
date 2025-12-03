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

    $oop->update_data_with_vitals($name, $gender, $idNum, $department,$section, $complaint, $visitDate, $ID, $temperature, $bloodPressure, $pulse, $respiratoryRate, $vitalDate);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Update Clinic Record</title>

<style>
/* CSS Variables */
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

input, select {
    width: 100%;
    padding: 12px 15px;
    border: 1.5px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
    box-sizing: border-box;
}

input:focus, select:focus {
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
    transition: all 0.3s ease;
}

.btn-update {
    background: var(--primary-maroon);
    color: #fff;
}

.btn-update:hover {
    background: #a00000;
    transform: translateY(-2px);
}

.btn-cancel {
    background: #6c757d;
    color: #fff;
}

.btn-cancel:hover {
    background: #545b62;
    transform: translateY(-2px);
}

#section-group {
    display: none;
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

<script>
document.addEventListener("DOMContentLoaded", function () {
    const gradeSelect = document.getElementById("department");
    const sectionGroup = document.getElementById("section-group");

    function toggleSection() {
        sectionGroup.style.display = gradeSelect.value ? "block" : "none";
    }

    gradeSelect.addEventListener("change", toggleSection);

    toggleSection(); // Initial load
});
</script>

</head>
<body>

<div class="main-content">
<h2>Update Clinic Record</h2>

<?php if (!empty($show_update_data)): 
    $row = $show_update_data;
?>
<div class="form-container">
<form method="POST">

    <!-- Student Information -->
    <div class="form-section">
        <h3>Student Information</h3>

        <div class="form-row">
            <div class="form-group">
                <label>Student Name *</label>
                <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" required>
            </div>

            <div class="form-group">
                <label>Gender *</label>
                <select name="gender" required>
                    <option value="Male"   <?= $row['gender']=='Male'?'selected':'' ?>>Male</option>
                    <option value="Female" <?= $row['gender']=='Female'?'selected':'' ?>>Female</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Student ID Number *</label>
                <input type="text" name="idNum" value="<?= $row['idNum'] ?>" required>
            </div>

            <div class="form-group">
                <label>Grade Level *</label>
                <select name="department" id="department" required>
                    <option value="">Select Grade Level</option>
                    <?php 
                    foreach(["Grade 7","Grade 8","Grade 9","Grade 10","Grade 11","Grade 12"] as $grade) {
                        echo "<option value='$grade' ".($row['department']==$grade?'selected':'').">$grade</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group" id="section-group">
            <label>Section *</label>
            <input type="text" name="section" value="<?= htmlspecialchars($row['section']) ?>" required>
        </div>

        <div class="form-group">
            <label>Complaint *</label>
            <select name="complaint" required>
                <option value="">Select Complaint</option>
                <?php
                $complaints = [
                    "Fever","Stomach ache","Menstrual pains (dysmenorrhea)",
                    "Headache","Sore throat","Cough and cold symptoms",
                    "Minor injuries (sprains, cuts, bruises)","Dizziness or fainting",
                    "Asthma exacerbation","Allergic reactions","Influenza (flu)",
                    "Strep throat","Mononucleosis (Mono)",
                    "Pink eye (conjunctivitis)","Vomiting and diarrhea (gastroenteritis)",
                    "Nosebleeds","Chickenpox","Hand, foot, and mouth disease"
                ];
                foreach($complaints as $c){
                    echo "<option value='$c' ".($row['complaint']==$c?'selected':'').">$c</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label>Visit Date *</label>
            <input type="date" name="visitDate" value="<?= $row['visitDate'] ?>" required>
        </div>
    </div>

    <!-- Vitals Section -->
    <div class="form-section">
        <h3>Vital Signs</h3>

        <div class="form-row">
            <div class="form-group">
                <label>Temperature (°C)</label>
                <input type="number" step="0.1" name="temperature" value="<?= $row['temperature'] ?>" min="30" max="42">
            </div>
            <div class="form-group">
                <label>Blood Pressure</label>
                <input type="text" name="bloodPressure" value="<?= $row['bloodPressure'] ?>" placeholder="120/80">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Pulse (bpm)</label>
                <input type="number" name="pulse" value="<?= $row['pulse'] ?>" min="40" max="200">
            </div>
            <div class="form-group">
                <label>Respiratory Rate (rpm)</label>
                <input type="number" name="respiratoryRate" value="<?= $row['respiratoryRate'] ?>" min="10" max="40">
            </div>
        </div>

        <div class="form-group">
            <label>Vitals Date</label>
            <input type="date" name="vitalDate" value="<?= $row['vitalDate'] ?: date('Y-m-d') ?>">
        </div>
    </div>

    <input type="hidden" name="id" value="<?= $row['ID'] ?>">

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