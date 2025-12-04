
<?php
if (sessin_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the core class file
include 'functions.php';

$auth = new AuthSystem();

// Calls the method that destroys the session and redirects to index.php
// The actual logic for session_unset(), session_destroy(), and redirection 
// is handled securely inside the $auth->logout() method.
$auth->logout();
?>