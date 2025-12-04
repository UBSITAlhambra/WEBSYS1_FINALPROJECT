<?php
// FILE: login/index.php

// 1. START THE SESSION at the very beginning of the script
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'functions.php';

$auth = new AuthSystem();
$error_message = ''; // Local variable to hold immediate form errors

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($email) || empty($password)) {
        $error_message = "Please fill in both email and password fields.";
    } else {
        $clean_email = htmlspecialchars($email);
        // The $auth->login() method handles the database check, sets $_SESSION vars, 
        // and redirects upon success.
        $auth->login($clean_email, $password);
        
        // If login fails, the method should handle displaying an alert 
        // via PHP script output (as seen in your functions.php).
    }
}

// 2. Display any temporary session messages (e.g., "You have been logged out")
// This is a placeholder structure for robust error/message passing.
$session_message = $_SESSION['message'] ?? '';
unset($_SESSION['message']); // Clear message after displaying

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff Login</title>
    
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
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
            min-height: 100vh;
        }
        
        .custom-card { 
            box-shadow: var(--box-shadow); 
            transition: all 0.3s ease-in-out;
            border: none;
        }
        
        .custom-card:hover {
            box-shadow: var(--hover-shadow);
        }

        h2 { 
            color: var(--primary-maroon);
            font-weight: 600;
        }
        
        .btn-custom-maroon { 
            background-color: white; 
            color: var(--primary-maroon); 
            border: 2px solid var(--primary-maroon); 
            font-weight: 600;
            transition: all 0.2s ease-in-out;
        }
        
        .btn-custom-maroon:hover { 
            background-color: var(--primary-maroon); 
            color: white; 
            box-shadow: 0 4px 8px rgba(128, 0, 0, 0.4);
        }
        
        .link a {
            color: var(--primary-maroon);
            text-decoration: none;
            font-weight: 600;
        }
    </style>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card p-4 custom-card" style="width: 350px;"> 
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Clinic Staff Login </h2>
                
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger text-center" role="alert"><?php echo $error_message; ?></div>
                <?php endif; ?>
                
                <?php if (!empty($session_message)): ?>
                    <div class="alert alert-info text-center" role="alert"><?php echo $session_message; ?></div>
                <?php endif; ?>
                
                <form action="index.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($email); ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-custom-maroon w-100 mt-2">Log In</button>
                </form>
                
                <div class="link text-center mt-3">
                    <p>Need an account? <a href="register.php">Register Here</a></p>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>