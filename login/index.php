<?php
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Login</title>
  
</head>
<body>
    <div class="form-container">
        <h2>Clinic Staff Login </h2>
        <?php if (!empty($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        
        <form action="index.php" method="POST">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($email); ?>">
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Log In</button>
        </form>
        
        <div class="link">
            <p>Need an account? <a href="register.php">Register Here</a></p>
        </div>
    </div>
</body>

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
            width: 320px;
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
</html>