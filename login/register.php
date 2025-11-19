<?php
// Include the class definition file
include 'functions.php';

// Instantiate the class
$auth = new AuthSystem();
$error_message = '';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Basic validation
    if (empty($fullname) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters long.";
    } else {
        // Sanitize inputs
        $clean_fullname = htmlspecialchars($fullname);
        $clean_email = filter_var($email, FILTER_SANITIZE_EMAIL); 
        
        // Call the register method
        // Note: The register method handles its own success/failure alerts and redirects
        $auth->register($clean_fullname, $clean_email, $password);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clinic Staff Registration</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .register-container { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); width: 350px; }
        h2 { text-align: center; color: #333; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background-color: #1e7e34; }
        .error { color: red; text-align: center; margin-bottom: 15px; }
        .login-link { text-align: center; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Clinic Staff Registration 🧑‍⚕️</h2>
        <?php if (!empty($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        
        <form action="register.php" method="POST">
            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" name="fullname" required value="<?php echo htmlspecialchars($fullname); ?>">
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($email); ?>">
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            
            <button type="submit">Register Account</button>
        </form>
        
        <div class="login-link">
            <p>Already have an account? <a href="index.php">Login Here</a></p>
        </div>
    </div>
</body>
</html>