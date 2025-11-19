<?php
// Include the class definition file
include 'functions.php';

// Instantiate the class
$auth = new AuthSystem();

// Call the dedicated logout method
// This function handles session_destroy() and redirects to index.php
$auth->logout();
?>