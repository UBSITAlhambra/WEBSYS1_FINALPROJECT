<?php
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
            padding: 35px 30px;
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 420px;
            text-align: center;
            animation: fadeIn 0.6s ease-in-out;
        }
        h1 {
            margin-bottom: 25px;
            color: #333;
            font-size: 1.6rem;
            font-weight: 600;
        }
        input[type="text"], 
        input[type="date"] {
            width: 80%;
            padding: 14px;
            margin: 14px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            transition: border 0.3s, box-shadow 0.3s;
            text-align: center;
        }
        input:focus {
            border-color: #4a90e2;
            outline: none;
            box-shadow: 0 0 6px rgba(74,144,226,0.3);
        }
        button {
            width: 100%;
            padding: 14px;
            border: none;
            background: #2ecc71;
            color: white;
            font-size: 1.1rem;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s, transform 0.1s;
            margin-top: 15px;
            letter-spacing: 1px;
        }
        button:hover {
            background: #27ae60;
        }
        button:active {
            transform: scale(0.98);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>
    <form method="POST" action="">
        <h1>Add Clinic Record</h1>

        <input type="text" name="name" placeholder="Student Name" required>
        <input type="text" name="idNum" placeholder="Student ID Number" required>
        <input type="text" name="department" placeholder="Department" required>
        <input type="text" name="complaint" placeholder="Complaint" required>
        <input type="date" name="visitDate" placeholder="Visit Date" required>

        <button name="add">➕ ADD RECORD</button>
    </form>
</body>
</html>
