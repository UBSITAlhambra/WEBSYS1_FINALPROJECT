<?php
// FILE: login/logout.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'functions.php';

// Clear all session data immediately on page load
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out...</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <style>
        :root { --primary-maroon: #800000; }
        body { 
            background-color: var(--primary-maroon); 
            height: 100vh; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            color: white; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            overflow: hidden;
        }
        .logout-container { text-align: center; }
        
        /* Pulse Animation Logic */
        .loading-logo { 
            width: 120px; /* Made slightly larger since it's the solo element */
            height: auto;
            animation: pulse 1.5s infinite ease-in-out; 
        }
        
        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.7; }
            50% { transform: scale(1.1); opacity: 1; }
            100% { transform: scale(1); opacity: 0.7; }
        }

        h3 { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: 300; /* Lighter weight for a more modern feel */
        }
    </style>
</head>
<body>

    <div class="logout-container">
        <img src="../images/logo.png" class="loading-logo mb-4" alt="School Logo">
        
        <h3 class="mt-4 fw-bold">Signing out...</h3>
    </div>

    <script>
        // Simulate a brief delay to show the pulsing logo transition
        setTimeout(function() {
            window.location.href = 'index.php';
        }, 1800); // Redirects after 1.8 seconds
    </script>
</body>
</html>