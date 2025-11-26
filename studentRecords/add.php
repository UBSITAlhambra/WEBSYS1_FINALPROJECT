<?php
// Assuming oop.php contains your oop_class which has the insert_data method
include "oop.php";
$oop = new oop_class();

if (isset($_POST['add'])) {
    $name = $_POST['name'] ?? '';
    $idNum = $_POST['idNum'] ?? '';
    $department = $_POST['department'] ?? '';
    $complaint = $_POST['complaint'] ?? '';
     $visitDate = $_POST['visitDate'] ?? '';

    $oop->insert_data($name, $idNum, $department, $complaint, $visitDate);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Add Clinic Record</title>
<style>
:root {
    --primary-maroon: #690303ff;
    --primary-maroon-hover: #a00000;
    --light-bg: #f8f8f8;
    --box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
}

body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background-color: var(--primary-maroon);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

form {
    background: #fff;
    padding: 35px 30px;
    border-radius: 12px;
    box-shadow: var(--box-shadow);
    width: 100%;
    max-width: 420px;
    text-align: center;
    animation: fadeIn 0.6s ease-in-out;
}

h1 {
    margin-bottom: 25px;
    color: var(--primary-maroon);
    font-size: 1.8rem;
    font-weight: 600;
}

input[type="text"],
input[type="date"],
select[name="complaint"] {
    width: 85%;
    padding: 12px 15px;
    margin: 10px 0 18px 0;
    border: 1.8px solid #ccc;
    border-radius: 8px;
    font-size: 1rem;
    transition: border 0.3s ease, box-shadow 0.3s ease;
    text-align: left;
    appearance: none;
    background: white url("data:image/svg+xml,%3Csvg fill='none' stroke='%23666' stroke-width='2' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E") no-repeat right 15px center / 1rem 1rem;
    cursor: pointer;
}

input[type="text"]:focus,
input[type="date"]:focus,
select[name="complaint"]:focus {
    border-color: var(--primary-maroon);
    outline: none;
    box-shadow: 0 0 8px rgba(169, 0, 0, 0.5);
}

select[name="complaint"] option[disabled] {
    color: #999;
}

.button-group {
    display: flex;
    justify-content: space-between;
    margin-top: 25px;
}

button,
.cancel-btn {
    padding: 8px 0;
    border: none;
    font-size: 1rem;
    font-weight: 700;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.1s ease;
    letter-spacing: 1px;
    width: 48%;
    text-align: center;
    text-decoration: none;
}

button[name="add"] {
    background: var(--primary-maroon);
    color: white;
}

button[name="add"]:hover {
    background: var(--primary-maroon-hover);
}

.cancel-btn {
    background: #e74c3c;
    color: white;
    display: inline-block;
    line-height: normal;
}

.cancel-btn:hover {
    background: #c0392b;
}

button:active,
.cancel-btn:active {
    transform: scale(0.97);
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

</head>

<body>
     <form method="POST" action="">
        <h1>Add Clinic Record </h1>

        <input type="text" name="name" placeholder="Student Name" required>
        <input type="text" name="idNum" placeholder="Student ID Number" required>
        <input type="text" name="department" placeholder="Grade & Section" required>
        <select name="complaint" required>
    <option value="" disabled selected>Select Complaint</option>
    <option value="Fever">Fever</option>
    <option value="Stomach ache">Stomach ache</option>
    <option value="Menstrual pains (dysmenorrhea)">Menstrual pains (dysmenorrhea)</option>
    <option value="Headache">Headache</option>
    <option value="Sore throat">Sore throat</option>
    <option value="Cough and cold symptoms">Cough and cold symptoms</option>
    <option value="Minor injuries (sprains, cuts, bruises)">Minor injuries (sprains, cuts, bruises)</option>
    <option value="Dizziness or fainting">Dizziness or fainting</option>
    <option value="Asthma exacerbation">Asthma exacerbation</option>
    <option value="Allergic reactions">Allergic reactions</option>
    <option value="Influenza (flu)">Influenza (flu)</option>
    <option value="Vomiting and diarrhea (gastroenteritis)">Vomiting and diarrhea (gastroenteritis)</option>
    <option value="Nosebleeds">Nosebleeds</option>
    <option value="Hand, foot, and mouth disease">Hand, foot, and mouth disease</option>
</select>

        <input type="date" name="visitDate" placeholder="Visit Date" required>

        <div class="button-group">
            <button name="add"> Add Record</button>
            <a href="index.php" class="cancel-btn">Cancel</a>
        </div>
    </form>
</body>
</html>