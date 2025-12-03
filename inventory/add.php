<?php
// Assuming oop.php contains your inventory class with the insert_data method
include "oop.php";
$oop = new oop_class();

if (isset($_POST['add'])) {
    $genericName = $_POST['genericName'] ?? '';
    $dosage = $_POST['dosage'] ?? '';
    $category = $_POST['category'] ?? '';
    $addDate = $_POST['addDate'] ?? '';
    $expDate = $_POST['expDate'] ?? '';
    $quantity = $_POST['quantity'] ?? '';
    
    // UPDATED: Removed $brand from the function call
    $oop->insert_data($genericName, $dosage, $category, $quantity, $addDate, $expDate);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Add New Inventory Item</title>
    <style>
        /* Define the primary maroon color and shadow variables */
        :root {
            --primary-maroon: #800000; /* Deep Maroon */
            --light-bg: #f8f8f8; 
            --box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); 
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: var(--light-bg);
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
            font-size: 1.6rem;
            font-weight: 600;
        }
        
        /* Input and Select Styles */
        input[type="text"], 
        input[type="date"],
        input[type="number"],
        select { 
            width: 85%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            transition: border 0.3s, box-shadow 0.3s;
            text-align: left;
            
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            cursor: pointer;
            background-color: white;
            color: #333;
        }
        input:focus, select:focus {
            border-color: var(--primary-maroon);
            outline: none;
            box-shadow: 0 0 6px rgba(128, 0, 0, 0.3);
        }
        
        /* Button Group Styling */
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
        
        /* ADD Button (Maroon) */
        button[name="add"] {
            background: var(--primary-maroon);
            color: white;
        }
        button[name="add"]:hover {
            background: #a00000;
        }
        
        /* CANCEL Button (Gray, non-primary action) */
        .cancel-btn {
            background: #6c757d;
            color: white;
        }
        .cancel-btn:hover {
            background: #545b62;
        }

        button:active, .cancel-btn:active {
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
        <h1>Add Inventory Item </h1>

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
        <input type="date" name="addDate" placeholder="Add Date" required>
        <input type="date" name="expDate" placeholder="Expiry Date" required>
        
        <div class="button-group">
            <a href="index.php" class="cancel-btn">Cancel</a>
            <button name="add">Add Item</button>
        </div>
    </form>
</body>
</html>