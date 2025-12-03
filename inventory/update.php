<?php
session_start();
include "oop.php"; // Assuming this is your inventory class
$oop = new oop_class();
// Assuming you have a sidebar, though it wasn't requested in the body for this page, 
// I'll keep the context clean without it for a focused form page.

// 1. Fetch the record to update
$show_update_data = null;
if (isset($_GET['id'])) {
    $ID = $_GET['id'];
    $show_update_data = $oop->show_update_data($ID);
}

// 2. Handle form submission
if (isset($_POST['enter'])) {
    $genericName = $_POST['genericName'] ?? '';
    $dosage = $_POST['dosage'] ?? '';
    // Brand was removed in the Add page, keeping it out here too unless required by DB
    $category = $_POST['category'] ?? '';
    $addDate = $_POST['addDate'] ?? '';
    $expDate = $_POST['expDate'] ?? '';
    $quantity = $_POST['quantity'] ?? ''; // <<< CORRECTED: Quantity retrieved here
    $ID = $_POST['id'] ?? '';
    
    // NOTE: Your update_data function call arguments must match the method signature in oop.php. 
    // Assuming the signature is: update_data($genericName, $dosage, $category, $quantity, $addDate, $expDate, $ID)
    $oop->update_data($genericName, $dosage, $category, $quantity, $addDate, $expDate, $ID);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Update Inventory Item</title>
    <style>
        /* CSS Variables */
        :root {
            --primary-maroon: #800000;
            --light-bg: #f8f8f8;
            --box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); 
            --cancel-gray: #6c757d;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: var(--light-bg); /* Use light background */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        
        .no-data {
            padding: 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: var(--box-shadow);
            color: var(--primary-maroon);
            font-weight: bold;
            max-width: 400px;
            text-align: center;
        }

        form {
            background: #fff;
            padding: 35px 40px;
            border-radius: 12px;
            box-shadow: var(--box-shadow);
            width: 100%;
            max-width: 550px; /* Reduced max-width for better focus */
            animation: fadeIn 0.5s ease-in-out;
        }
        
        h1 {
            color: var(--primary-maroon);
            font-size: 1.8rem;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
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

        button, .btn-cancel {
            flex: 1;
            padding: 14px 20px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s, transform 0.1s;
            text-decoration: none;
            text-align: center;
        }

        .btn-update {
            background: var(--primary-maroon);
            color: #fff;
        }

        .btn-update:hover {
            background: #a00000;
        }

        .btn-cancel {
            background: var(--cancel-gray);
            color: #fff;
        }

        .btn-cancel:hover {
            background: #545b62;
        }

        button:active, .btn-cancel:active {
            transform: scale(0.98);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
<form method="POST" action="">
    <h1>Update Inventory Item</h1>
    
    <?php if (!empty($show_update_data)): 
        $row = $show_update_data;
    ?>
    
    <div class="form-row">
        <div class="form-group">
            <label>Generic Name</label>
            <input type="text" name="genericName" value="<?= htmlspecialchars($row['genericName']) ?>" required>
        </div>
        <div class="form-group">
            <label>Dosage</label>
            <input type="text" name="dosage" value="<?= htmlspecialchars($row['dosage']) ?>" required>
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group">
            <label>Category</label>
            <select name="category" required>
                <option value="Pain Relief" <?= $row['category']=='Pain Relief'?'selected':'' ?>>Pain Relief</option>
                <option value="Fever" <?= $row['category']=='Fever'?'selected':'' ?>>Fever</option>
                <option value="Allergy" <?= $row['category']=='Allergy'?'selected':'' ?>>Allergy</option>
                <option value="Wound Care" <?= $row['category']=='Wound Care'?'selected':'' ?>>Wound Care</option>
                <option value="Other" <?= $row['category']=='Other'?'selected':'' ?>>Other</option>
            </select>
        </div>
        <div class="form-group">
            <label>Quantity</label>
            <input type="number" name="quantity" value="<?= htmlspecialchars($row['quantity']) ?>" required min="0">
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group">
            <label>Add Date</label>
            <input type="date" name="addDate" value="<?= htmlspecialchars($row['addDate']) ?>" required>
        </div>
        <div class="form-group">
            <label>Expiry Date</label>
            <input type="date" name="expDate" value="<?= htmlspecialchars($row['expDate']) ?>" required>
        </div>
    </div>

    <input type="hidden" name="id" value="<?= htmlspecialchars($row['itemID']) ?>">
    
    <div class="button-group">
        <a href="index.php" class="btn btn-cancel">Cancel</a>
        <button name="enter" class="btn-update">Update Details</button>
    </div>

    <?php else: ?>
        <p class="no-data">No inventory item found for this ID.</p>
    <?php endif; ?>
</form>
</body>
</html>