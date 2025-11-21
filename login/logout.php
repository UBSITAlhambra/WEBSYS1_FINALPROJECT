<?php
// Include the core class file
include 'functions.php';

$auth = new AuthSystem();

// Calls the method that destroys the session and redirects to index.php
$auth->logout();
?>