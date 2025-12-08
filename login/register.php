<?php
// login/register.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'functions.php'; 
$auth = new AuthSystem();
$error_message = '';

$fname = $_POST['fname'] ?? '';
$mname = $_POST['mname'] ?? ''; 
$lname = $_POST['lname'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($fname) || empty($lname) || empty($email) || empty($password)) {
        $error_message = "Required fields are missing.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        $auth->register(htmlspecialchars($fname), htmlspecialchars($mname), htmlspecialchars($lname), filter_var($email, FILTER_SANITIZE_EMAIL), $password);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff Registration</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <style>
        :root { --primary-maroon: #800000; --light-bg: #f8f8f8; }
        body { font-family: 'Segoe UI', sans-serif; background-color: var(--light-bg); display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; position: relative; overflow-x: hidden; }
        body::before { content: ""; position: absolute; top:0; left:0; width:100%; height:100%; background-image: url('../images/BCNHS.jpg'); background-size: cover; background-position: center; filter: blur(10px); transform: scale(1.1); z-index: -2; }
        body::after { content: ""; position: absolute; top:0; left:0; width:100%; height:100%; background-color: rgba(128, 0, 0, 0.55); z-index: -1; }
        .custom-card { background: white; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4); border-radius: 12px; padding: 30px; width: 100%; max-width: 550px; position: relative; }
        .login-logo { width: 70px; height: auto; display: block; margin: 0 auto 15px; }
        h2 { color: var(--primary-maroon); font-weight: 600; text-align: center; margin-bottom: 20px; }
        .btn-custom-maroon { background-color: white; color: var(--primary-maroon); border: 2px solid var(--primary-maroon); font-weight: 600; transition: 0.2s; }
        .btn-custom-maroon:hover { background-color: var(--primary-maroon); color: white; }
        .validation-text { font-size: 0.7rem; font-weight: bold; margin-top: 2px; display: block;}
    </style>
</head>
<body>
    <div class="custom-card">
        <img src="../images/logo.png" alt="Logo" class="login-logo">
        <h2>Clinic Staff Registration</h2>
        
        <?php if ($error_message): ?>
            <div class="alert alert-danger py-2 small text-center"><?= $error_message ?></div>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <div class="row g-2 mb-3">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">First Name</label>
                    <input type="text" name="fname" class="form-control form-control-sm" required value="<?= htmlspecialchars($fname) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Middle Name</label>
                    <input type="text" name="mname" class="form-control form-control-sm" value="<?= htmlspecialchars($mname) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Last Name</label>
                    <input type="text" name="lname" class="form-control form-control-sm" required value="<?= htmlspecialchars($lname) ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Email</label>
                <input type="email" id="email" name="email" class="form-control form-control-sm" required onkeyup="checkEmailAvailability()">
                <div id="emailAvailabilityResult" class="validation-text"></div>
            </div>

            <div class="row g-2">
                <div class="col-md-6 mb-3">
                    <label class="form-label small fw-bold">Password</label>
                    <input type="password" id="password" name="password" class="form-control form-control-sm" required onkeyup="validatePasswords()">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label small fw-bold">Confirm</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control form-control-sm" required onkeyup="validatePasswords()">
                    <div id="passwordMatchResult" class="validation-text"></div>
                </div>
            </div>

            <button type="submit" class="btn btn-custom-maroon w-100 mt-2">Register Account</button>
        </form>
        <div class="text-center mt-3 small">
            Already registered? <a href="index.php" style="color: var(--primary-maroon); font-weight:600;">Login Here</a>
        </div>
    </div>

    <script>
    function checkEmailAvailability() {
        var email = document.getElementById('email').value;
        var res = document.getElementById('emailAvailabilityResult');
        if (email.length < 5) { res.innerHTML = ''; return; }
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                res.innerHTML = (this.responseText.trim() === 'taken') ? 
                '<span class="text-danger">❌ Already registered.</span>' : 
                '<span class="text-success">✅ Available!</span>';
            }
        };
        xhr.open("GET", "check_email.php?email=" + encodeURIComponent(email), true);
        xhr.send();
    }

    function validatePasswords() {
        var p = document.getElementById('password').value;
        var c = document.getElementById('confirm_password').value;
        var res = document.getElementById('passwordMatchResult');
        if (c === "") { res.innerHTML = ""; return; }
        res.innerHTML = (p === c) ? 
        '<span class="text-success">✅ Match!</span>' : 
        '<span class="text-danger">❌ No match.</span>';
    }
    </script>
</body>
</html>