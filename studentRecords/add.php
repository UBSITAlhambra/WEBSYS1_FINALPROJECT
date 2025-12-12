<?php
// Assuming oop.php contains your oop_class which has the insert_data_with_vitals method
session_start();
include "oop.php"; 
$oop = new oop_class();
include '../sidebar/sidebar.php';
    if(!isset($_SESSION['user_id'])){
        header('Location: ../login/');
    }
// Handle form submission
if (isset($_POST['add'])) {
    $name = $_POST['name'] ?? '';
    $gender = $_POST['gender'] ?? null; // Can be null now
    $role = $_POST['role'] ?? 'Student'; 
    $idNum = $_POST['idNum'] ?? null;     // Can be null
    $department = $_POST['department'] ?? null; // Can be null
    $complaint = $_POST['complaint'] ?? '';
    $visitDate = $_POST['visitDate'] ?? date('Y-m-d');
    
    $temperature = $_POST['temperature'] ?? null;
    $bloodPressure = $_POST['bloodPressure'] ?? null;
    $pulse = $_POST['pulse'] ?? null;
    $respiratoryRate = $_POST['respiratoryRate'] ?? null;
    $vitalDate = $_POST['vitalDate'] ?? date('Y-m-d');
    $section = $_POST['section'] ?? null; // Can be null

    // Server-Side Validation: Check only always-required fields (Name, Complaint)
    if (empty($name) || empty($complaint)) {
         echo "<script>alert('Error: Name and Complaint are required fields.');</script>";
    } else {
        // Pass all variables, letting the OOP method handle null insertion where appropriate
        $oop->insert_data_with_vitals($name, $gender, $role, $idNum, $department, $section, $complaint, $visitDate, $temperature, $bloodPressure, $pulse, $respiratoryRate, $vitalDate);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Add New Clinic Record</title>
    <style>
        /* CSS Variables matching update.php */
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
        /* Style required indicator */
        .required-label::after {
            content: ' *';
            color: red;
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
            .main-content { margin-left: 0; padding: 20px; }
            .form-container { padding: 25px; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="main-content">
        <h2>Add New Clinic Record</h2>
        
        <div class="form-container">
            <form method="POST" action="">
<div class="form-section">
    <h3>Patient Information</h3>
    <p>Note: All items with a (*) are required</p>

    <div class="form-row">
        <div class="form-group">
            <label for="name" class="required-label">Name</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="gender">Gender</label>
            <select id="gender" name="gender">
                <option value="" selected>Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group">
            <label for="role" class="required-label">Status/Role</label>
            <select id="role" name="role" required onchange="toggleFields()">
                <option value="Student">Regular Student</option>
                <option value="Teaching Staff">Teaching Staff</option>
                <option value="Non-Teaching Staff">Non-Teaching Staff</option>
            </select>
        </div>
        <div class="form-group">
            <label for="idNum" id="idNumLabel">ID Number (LRN for Students)</label>
            <input type="text" id="idNum" name="idNum">
        </div>
    </div>

    <div class="form-row" id="gradeSectionRow">
        <div class="form-group">
            <label for="department" id="gradeLabel">Grade Level</label>
            <select id="department" name="department">
                <option value="" selected>Select Grade Level</option>
                <option value="Grade 7">Grade 7</option>
                <option value="Grade 8">Grade 8</option>
                <option value="Grade 9">Grade 9</option>
                <option value="Grade 10">Grade 10</option>
                <option value="Grade 11">Grade 11</option>
                <option value="Grade 12">Grade 12</option>
            </select>
        </div>
        <div class="form-group">
            <label for="section" id="sectionLabel">Section</label>
            <input type="text" id="section" name="section" placeholder="e.g., ABM, St. Matthew">
        </div>
    </div>
    
    <div class="form-group">
        <label for="complaint" class="required-label">Chief Complaint</label>
        <select id="complaint" name="complaint" required>
            <option value="" disabled selected>Select Complaint</option>
            <option value="Allergy">Allergy</option>
            <option value="Wound">Wound</option>
            <option value="Colds">Colds</option>
            <option value="Cough">Cough</option>
            <option value="Enlarge Tonsils">Enlarge Tonsils</option>
            <option value="Inflammed Throat">Inflammed Throat</option>
            <option value="Hyperacidity">Hyperacidity</option>
            <option value="Dysmenorrhea">Dysmenorrhea</option>
            <option value="Headache">Headache</option>
            <option value="Toothache">Toothache</option>
            <option value="Toothache">Stomachache</option>
        </select>
    </div>

    <div class="form-group">
        <label for="visitDate">Visit Date</label>
        <input type="date" id="visitDate" name="visitDate" value="<?= date('Y-m-d') ?>">
    </div>
</div>


                <div class="form-section">
                    <h3>Vital Signs (Optional)</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="temperature">Temperature (°C)</label>
                            <input type="number" step="0.1" id="temperature" name="temperature" min="30" max="42" placeholder="36.6">
                        </div>
                        <div class="form-group">
                            <label for="bloodPressure">Blood Pressure</label>
                            <input type="text" id="bloodPressure" name="bloodPressure" placeholder="120/80">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="pulse">Pulse (bpm)</label>
                            <input type="number" id="pulse" name="pulse" min="40" max="200" placeholder="72">
                        </div>
                        <div class="form-group">
                            <label for="respiratoryRate">Respiratory Rate (rpm)</label>
                            <input type="number" id="respiratoryRate" name="respiratoryRate" min="10" max="40" placeholder="16">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="vitalDate">Vitals Date</label>
                        <input type="date" id="vitalDate" name="vitalDate" value="<?= date('Y-m-d') ?>">
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" name="add" class="btn btn-add">Add Record</button>
                    <a href="index.php" class="btn btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initial setup on page load
        toggleFields(); 
    });

    function toggleFields() {
        const role = document.getElementById('role').value;
        
        // Fields required only for Students (and optional for Staff)
        const studentRequiredFields = [
            { id: 'idNum', label: document.getElementById('idNumLabel'), required: true, newText: 'Student ID Number (12 digits for LRN)' },
            { id: 'department', label: document.getElementById('gradeLabel'), required: true, newText: 'Grade Level' },
            { id: 'section', label: document.getElementById('sectionLabel'), required: true, newText: 'Section' },
            { id: 'gender', label: document.querySelector('label[for="gender"]'), required: true, newText: 'Gender' },
        ];
        
        // Define the required state based on the selected role
        const isStudent = (role === 'Student');
        
        studentRequiredFields.forEach(field => {
            const element = document.getElementById(field.id);
            const label = field.label;
            
            if (!element) return; // Skip if element isn't found
            
            if (isStudent) {
                // If student is selected, fields are REQUIRED
                element.setAttribute('required', 'required');
                if (label) {
                    label.classList.add('required-label');
                }
                // Update placeholder/text for context
                if (field.id === 'idNum') element.setAttribute('placeholder', 'Student ID Number (12 digits for LRN)');
                
            } else {
                // If staff is selected, fields are OPTIONAL (nulls are passed to PHP)
                element.removeAttribute('required');
                if (label) {
                    label.classList.remove('required-label');
                }
                // Clear values and update placeholder/text for staff
                element.value = '';
                if (field.id === 'idNum') element.setAttribute('placeholder', 'Optional Staff ID');
            }
        });
        
        // Gender is a special case: ensure the prompt is updated
        const genderSelect = document.getElementById('gender');
        if (!isStudent && genderSelect) {
            // When staff is selected, reset gender dropdown to optional prompt
            genderSelect.value = ''; 
            genderSelect.querySelector('option[disabled]').textContent = 'Select Gender (Optional)';
        } else if (isStudent && genderSelect) {
             // When student is selected, change prompt to required
            genderSelect.querySelector('option[disabled]').textContent = 'Select Gender *';
        }
    }
</script>
</body>
</html>