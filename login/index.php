<?php
// Include the class definition file
include 'functions.php';

// Instantiate the class
$auth = new AuthSystem();

// Check if the form was submitted (POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic check for required fields
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        
        // Sanitize inputs before passing to the class method
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        // Call the login method
        $auth->login($email, $password);
        
    } else {
        $error_message = "Please fill in both email and password fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clinic Staff Login</title>
  
</head>
<body>
    <div class="login-container">
        <h2>Clinic Staff Login 🔑</h2>
        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        
        <form action="index.php" method="POST">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Log In</button>
        </form>
        
        <div class="register-link">
            <p>Don't have an account? <a href="register.php">Register Here</a></p>
        </div>
    </div>
</body>


  <style>
        body { 
            font-family: Arial, sans-serif; 
            background-color: #f4f4f4; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0; }

        .login-container { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); width: 300px; }
        h2 { text-align: center; color: #333; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="email"], input[type="password"] { width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background-color: #0056b3; }
        .error { color: red; text-align: center; margin-bottom: 15px; }
        .register-link { text-align: center; margin-top: 15px; }
    </style>
</html>