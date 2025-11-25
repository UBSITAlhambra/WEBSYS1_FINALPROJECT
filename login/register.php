<?php
// Include the core class file
include 'functions.php';

$auth = new AuthSystem();
$error_message = '';

// Use null coalescing to retain input values on validation error
$fname = $_POST['fname'] ?? '';
$mname = $_POST['mname'] ?? ''; 
$lname = $_POST['lname'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($fname) || empty($lname) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = "First name, last name, email, and passwords are required.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters long.";
    } else {
        
        // Sanitize inputs before passing to the method
        $clean_fname = htmlspecialchars($fname);
        $clean_mname = htmlspecialchars($mname);
        $clean_lname = htmlspecialchars($lname);
        $clean_email = filter_var($email, FILTER_SANITIZE_EMAIL); 
        
        // The class method handles hashing and database insertion.
        $auth->register($clean_fname, $clean_mname, $clean_lname, $clean_email, $password);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Registration</title>
    <style>
        
        :root {
            --primary-maroon: #800000; 
            --light-bg: #f8f8f8;
            --box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            --hover-shadow: 0 8px 25px rgba(128, 0, 0, 0.4);
        }

        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0; 
        }
        
        .form-container { 
            background: white; 
            padding: 35px;
            border-radius: 12px;
            box-shadow: var(--box-shadow); 
            width: 350px; 
            transition: all 0.3s ease-in-out;
        }
        
        .form-container:hover {
            box-shadow: var(--hover-shadow);
        }
        
        h2 { 
            text-align: center; 
            color: var(--primary-maroon);
            margin-bottom: 30px; 
            font-weight: 600;
        }
        
        label { 
            display: block; 
            margin-bottom: 5px; 
            font-weight: 500;
            color: #444; 
            font-size: 0.95rem;
        }
        
        input { 
            width: 100%; 
            padding: 12px;
            margin-bottom: 25px; 
            border: 1px solid #ddd; 
            border-radius: 6px;
            box-sizing: border-box; 
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        input:focus {
            border-color: var(--primary-maroon);
            outline: none;
            box-shadow: 0 0 5px rgba(128, 0, 0, 0.3);
        }
        
        
        button { 
            width: 100%; 
            padding: 12px; 
            
        
            background-color: white; 
            color: var(--primary-maroon); 
            border: 2px solid var(--primary-maroon);
            
            border-radius: 6px; 
            cursor: pointer; 
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.2s ease-in-out; 
        }
        
        button:hover { 
            
            background-color: var(--primary-maroon); 
            color: white; 
            box-shadow: 0 4px 8px rgba(128, 0, 0, 0.4); 
        }
        
        
        .error { 
            color: red; 
            text-align: center; 
            margin-bottom: 15px; 
            font-weight: bold;
        }
        
        .link { 
            text-align: center; 
            margin-top: 20px; 
            font-size: 0.9rem;
        }

        .link a {
            color: var(--primary-maroon);
            text-decoration: none;
            font-weight: 600;
        }

        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Clinic Staff Registration </h2>
        <?php if (!empty($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        
        <form action="register.php" method="POST">
            
            <label for="fname">First Name</label>
            <input type="text" id="fname" name="fname" required value="<?php echo htmlspecialchars($fname); ?>">
            
            <label for="mname">Middle Name (Optional)</label>
            <input type="text" id="mname" name="mname" value="<?php echo htmlspecialchars($mname); ?>">
            
            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lname" required value="<?php echo htmlspecialchars($lname); ?>">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($email); ?>">
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            
            <button type="submit">Register Account</button>
        </form>
        
        <div class="link">
            <p>Already have an account? <a href="index.php">Login Here</a></p>
        </div>
    </div>
</body>
</html>