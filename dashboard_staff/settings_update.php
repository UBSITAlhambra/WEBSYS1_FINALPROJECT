<?php
include 'pdo.php';
session_start();

$oop = new oop_class();

if (!isset($_SESSION['user_id'])) {
    header("Location: ./login/index.php");
    exit();
}

$id = $_SESSION['user_id'];

// Get POST data
$fullName = trim($_POST['full_name']);
$email = $_POST['email'];
$current = $_POST['current_password'];
$newPass = $_POST['new_password'];
$confirmPass = $_POST['confirm_password'];

// Split full name
$nameParts = explode(" ", $fullName);
$first = $nameParts[0] ?? "";
$middle = $nameParts[1] ?? "";
$last = implode(" ", array_slice($nameParts, 2)); 

// Fetch user
$user = $oop->get_user($id);

// Handle password change
if (!empty($newPass)) {

    if (!password_verify($current, $user['Password'])) {
        echo "<script>alert('Current password is incorrect'); history.back();</script>";
        exit();
    }

    if ($newPass !== $confirmPass) {
        echo "<script>alert('New passwords do not match'); history.back();</script>";
        exit();
    }

    $oop->update_user_with_password($id, $first, $middle, $last, $email, $newPass);

} else {
    // Update without password
    $oop->update_user_no_password($id, $first, $middle, $last, $email);
}

// Success
echo "<script>
        alert('Settings updated successfully!');
        window.location.href = 'settings.php';
      </script>";
?>
