<?php
// Include the core class file
require_once 'functions.php';

$auth = new AuthSystem();

// Calls the method that destroys the session and redirects to index.php
$auth->logout();
?>