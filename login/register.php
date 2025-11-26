<?php
include 'functions.php';

$auth = new AuthSystem();
$error_message = '';

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
        
        $clean_fname = htmlspecialchars($fname);
        $clean_mname = htmlspecialchars($mname);
        $clean_lname = htmlspecialchars($lname);
        $clean_email = filter_var($email, FILTER_SANITIZE_EMAIL); 
        
        $auth->register($clean_fname, $clean_mname, $clean_lname, $clean_email, $password);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff Registration</title>
    
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
        <div class="card p-4 custom-card" style="width: 400px;"> 
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Clinic Staff Registration </h2>
                
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger text-center" role="alert"><?php echo $error_message; ?></div>
                <?php endif; ?>
                
                <form action="register.php" method="POST">
                    
                    <div class="mb-3">
                        <label for="fname" class="form-label">First Name</label>
                        <input type="text" id="fname" name="fname" class="form-control" required value="<?php echo htmlspecialchars($fname); ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="mname" class="form-label">Middle Name (Optional)</label>
                        <input type="text" id="mname" name="mname" class="form-control" value="<?php echo htmlspecialchars($mname); ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" id="lname" name="lname" class="form-control" required value="<?php echo htmlspecialchars($lname); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($email); ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-custom-maroon w-100 mt-2">Register Account</button>
                </form>
                
                <div class="link text-center mt-3">
                    <p>Already have an account? <a href="index.php">Login Here</a></p>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>