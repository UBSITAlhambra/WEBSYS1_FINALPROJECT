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
        /* Define the primary maroon color and shadow variables */
        :root {
            --primary-maroon: #690303ff; /* Deep Maroon */
            --light-bg: #f8f8f8;
            --box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); 
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: var(--primary-maroon); /* CHANGED: Page background to Maroon */
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
            color: var(--primary-maroon); /* Maroon Heading */
            font-size: 1.6rem;
            font-weight: 600;
        }
        input[type="text"], 
        input[type="date"] {
            width: 85%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            transition: border 0.3s, box-shadow 0.3s;
            text-align: left;
        }
        input:focus {
            border-color: var(--primary-maroon);
            outline: none;
            box-shadow: 0 0 6px rgba(128, 0, 0, 0.3);
        }
        
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        /* Adjusted button padding and font size for smaller appearance */
        button, .cancel-btn {
            padding: 5px; /* Smaller padding */
            border: none;
            font-size: 0.95rem; /* Smaller font size */
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s, transform 0.1s;
            letter-spacing: 1px;
            text-decoration: none;
            width: 48%;
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
        
        /* CANCEL Button (Red/White, contrasting but still urgent) */
        .cancel-btn {
            background: #e74c3c;
            color: white;
        }
        .cancel-btn:hover {
            background: #c0392b;
        }

        button:active, .cancel-btn:active {
            transform: scale(0.98);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    </style>
</head>

<body>
     <form method="POST" action="">
        <h1>Add Clinic Record </h1>

        <input type="text" name="name" placeholder="Student Name" required>
        <input type="text" name="idNum" placeholder="Student ID Number" required>
        <input type="text" name="department" placeholder="Department" required>
        <input type="text" name="complaint" placeholder="Complaint" required>
        <input type="date" name="visitDate" placeholder="Visit Date" required>

        <div class="button-group">
            <button name="add"> Add Record</button>
            <a href="index.php" class="cancel-btn">Cancel</a>
        </div>
    </form>
</body>
</html>