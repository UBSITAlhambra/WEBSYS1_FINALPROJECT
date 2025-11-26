<?php
// Ensure this file is accessible at the same level as your functions.php or adjust the path
include 'functions.php'; 

// Check if the email was passed via the GET request
if (isset($_GET['email']) && !empty($_GET['email'])) {
    $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);
    
    $auth = new AuthSystem();
    
    if ($auth->check_email_availability($email)) {
        // Email found (DUPLICATE)
        echo 'taken'; 
    } else {
        // Email not found (AVAILABLE)
        echo 'available';
    }
} else {
    echo 'error';
}
?>