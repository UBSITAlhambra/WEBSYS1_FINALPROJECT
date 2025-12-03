<?php
session_start();
include "oop.php";
$oop = new oop_class();
$activePage = 'inventory';
include '../sidebar/sidebar.php'; 
    if(!isset($_SESSION['user_id'])){
        header('Location: ../login/');
    }
if (isset($_POST['add'])) {
    $genericName = $_POST['genericName'] ?? '';
    $dosage      = $_POST['dosage'] ?? '';
    $category    = $_POST['category'] ?? '';
    $addDate     = $_POST['addDate'] ?? '';
    $expDate     = $_POST['expDate'] ?? '';
    $quantity    = $_POST['quantity'] ?? '';
    
    $oop->insert_data($genericName, $dosage, $category, $quantity, $addDate, $expDate);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Add New Inventory Item</title>
    <style>
        :root {
            --primary-maroon: #800000;
            --light-bg: #f8f8f8; 
            --box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); 
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: var(--light-bg);
            margin: 0;
        }

        .main-content {
            margin-left: 250px;
            padding: 40px 40px 20px 40px;
            min-height: 100vh;
            background: var(--light-bg);
        }

        .form-wrapper {
            max-width: 480px;
            margin: 0 auto;
        }

        form {
            background: #fff;
            padding: 35px 30px;
            border-radius: 12px;
            box-shadow: var(--box-shadow);
            text-align: center;
            animation: fadeIn 0.6s ease-in-out;
        }

        h1 {
            margin-bottom: 25px;
            color: var(--primary-maroon);
            font-size: 1.6rem;
            font-weight: 600;
        }

        input[type="text"], 
        input[type="date"],
        input[type="number"],
        select { 
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            transition: border 0.3s, box-shadow 0.3s;
            text-align: left;
            appearance: none;
            background-color: #fff;
            color: #333;
        }

        input:focus, select:focus {
            border-color: var(--primary-maroon);
            outline: none;
            box-shadow: 0 0 6px rgba(128, 0, 0, 0.3);
        }

        label {
            display: block;
            text-align: left;
            width: 90%;
            margin: 8px auto 0 auto;
            font-size: 0.9rem;
            color: #555;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
            gap: 15px;
        }

        button, .cancel-btn {
            width: 48%;
            padding: 12px;
            border: none;
            font-size: 1.05rem;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s, transform 0.1s;
            letter-spacing: 1px;
            text-decoration: none;
            text-align: center;
        }

        button[name="add"] {
            background: var(--primary-maroon);
            color: #fff;
        }
        button[name="add"]:hover {
            background: #a00000;
        }

        .cancel-btn {
            background: #6c757d;
            color: #fff;
        }
        .cancel-btn:hover {
            background: #545b62;
        }

        button:active, .cancel-btn:active {
            transform: scale(0.98);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-15px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 900px) {
            .main-content { margin-left: 0; padding: 20px; }
        }
    </style>
</head>
<body>
<div class="main-content">
    <div class="form-wrapper">
        <form method="POST" action="">
            <h1>Add Inventory Item</h1>

            <input type="text" name="genericName" placeholder="Generic Name" required> 
            <input type="text" name="dosage" placeholder="Dosage (e.g., 500mg)" required>

            <select name="category" required>
                <option value="" disabled selected>Select Category *</option>
                <option value="Pain Relief">Pain Relief</option>
                <option value="Fever">Fever</option>
                <option value="Allergy">Allergy</option>
                <option value="Wound Care">Wound Care (Bandages/Antiseptics)</option>
                <option value="Other">Other</option>
            </select>
            
            <input type="number" name="quantity" placeholder="Quantity (Initial Stock)" required min="1">

            <label>Add Date</label>
            <input type="date" name="addDate" required>

            <label>Expiry Date</label>
            <input type="date" name="expDate" required>
            
            <div class="button-group">
                <a href="index.php" class="cancel-btn">Cancel</a>
                <button name="add">Add Item</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
