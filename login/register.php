<?php
// Include the core class file
require_once 'functions.php';

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
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .form-container { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); width: 350px; }
        h2 { text-align: center; color: #333; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background-color: #1e7e34; }
        .error { color: red; text-align: center; margin-bottom: 15px; }
        .link { text-align: center; margin-top: 15px; }
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