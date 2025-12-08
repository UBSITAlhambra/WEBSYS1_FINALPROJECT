<?php
/**
 * SECURITY GUARD FILE
 * Place this inside the 'login' folder.
 * This file protects secured pages from unauthorized access.
 */

// 1. Force the session to start or resume
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past to expire cache immediately


// 3. AUTHENTICATION CHECK
// We check if the 'user_id' created during login exists.
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    
    /**
     * 4. REDIRECT ON FAILURE
     * If user is not logged in, kick them back to the login page.
     * Note: Path might need adjustment depending on where you include this from.
     * Use index.php for your login page.
     */
    header("Location: ../login/index.php"); 
    
    // Critical: Stop script execution so the rest of the dashboard code is not processed.
    exit;
}

// If the script continues past here, the user is authenticated.
?>