<?php
include "oop.php";
$oop = new oop_class();

if (isset($_POST['add'])) {
    $genericName = $_POST['genericName'] ?? '';
    $dosage = $_POST['dosage'] ?? '';
    $brand = $_POST['brand'] ?? '';
    $category = $_POST['category'] ?? '';
    $addDate = $_POST['addDate'] ?? '';
    $expDate = $_POST['expDate'] ?? '';
    $quantity = $_POST['quantity'] ?? '';
    $oop->insert_data($genericName, $dosage, $brand, $category, $quantity, $addDate, $expDate);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Add New Inventory Item</title>
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
        <h1>Add Inventory Item</h1>
        <input type="text" name="genericName" placeholder="Generic Name" required> 
        <input type="text" name="dosage" placeholder="Dosage" required>
        <input type="text" name="brand" placeholder="Brand" required>
        <input type="text" name="category" placeholder="Category" required>
         <input type="text" name="quantity" placeholder="Quantity" required>
        <input type="date" name="addDate" placeholder="Add Date" required>
        <input type="date" name="expDate" placeholder="Expiry Date" required>
        <button name="add">➕ ADD</button>
    </form>
</body>
</html>
