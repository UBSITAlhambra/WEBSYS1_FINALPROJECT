<?php
// FILE: login/index.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'functions.php';

$auth = new AuthSystem();
$error_message = ''; 

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($email) || empty($password)) {
        $error_message = "Please fill in both email and password fields.";
    } else {
        $clean_email = htmlspecialchars($email);
        $auth->login($clean_email, $password);
    }
}

$session_message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff Login</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <style>
        :root {
            --primary-maroon: #800000;
            --light-bg: #f8f8f8;
            --box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); 
            --hover-shadow: 0 8px 25px rgba(128, 0, 0, 0.4);
        }

        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh;
            overflow: hidden; 
            position: relative;
        }

        /* 1. BLURRED IMAGE LAYER */
        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: url('../images/BCNHS.jpg'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            filter: blur(10px);
            transform: scale(1.1); 
            z-index: -2;
        }

        /* 2. MAROON OVERLAY LAYER */
        body::after {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(128, 0, 0, 0.55); 
            z-index: -1;
        }

        /* 3. LOGIN FORM CARD */
        .custom-card { 
            background: white; 
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
            border-radius: 12px;
            padding: 35px;
            position: relative;
            width: 100%;
            max-width: 350px;
            transition: all 0.3s ease-in-out;
        }

        .login-logo {
            width: 150px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        
        .custom-card:hover {
            box-shadow: var(--hover-shadow);
        }

        h2 { color: var(--primary-maroon); font-weight: 600; }
        
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
        
        .link a { color: var(--primary-maroon); text-decoration: none; font-weight: 600; }

        /* LOADING OVERLAY STYLES */
        .loading-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(80, 0, 0, 0.98); /* Solid deep maroon */
            z-index: 9999;
            display: none; /* Hidden by default */
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: white;
            text-align: center;
        }

        .loading-logo {
            width: 100px;
            animation: pulse 1.5s infinite ease-in-out;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.1); opacity: 1; }
            100% { transform: scale(1); opacity: 0.8; }
        }
    </style>
</head>
<body>

    <div id="loading-overlay" class="loading-overlay">
        <img src="../images/logo.png" class="loading-logo mb-3" alt="Logo">
        <p class="mt-3 fw-bold">Verifying Credentials...</p>
    </div>

    <div class="container d-flex justify-content-center align-items-center">
        <div class="card p-4 custom-card"> 
            <div class="card-body">
                <div class="text-center mb-4">
                    <img src="../images/logo.png" alt="School Logo" class="login-logo">
                </div>

                <h2 class="card-title text-center mb-4">Clinic Staff Login</h2>
                
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger text-center py-2 small" role="alert"><?= $error_message ?></div>
                <?php endif; ?>
                
                <form id="loginForm" action="index.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label small fw-bold">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required value="<?= htmlspecialchars($email) ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label small fw-bold">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-custom-maroon w-100 mt-2">Log In</button>
                </form>
                
                <div class="link text-center mt-3 small">
                    <p>Need an account? <a href="register.php">Register Here</a></p>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

   <script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        document.getElementById('loading-overlay').style.display = 'flex';

        var timer = 2000; 
        var currentForm = e.target;

        setTimeout(function() {
            currentForm.submit();
        }, timer);
    });
</script>
</body>
</html>