<?php
define("SERVER", "localhost");
define("USER", "root");
define("PASS", "");
define("DBNAME", "finalproject");

class oop_class {
    private $conn;

    function __construct(){
        try {
            $connection = "mysql:host=" . SERVER . ";dbname=" . DBNAME . ";charset=utf8";
            $this->conn = new PDO($connection, USER, PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "
                <script>
                alert('Connection Failed');
                </script>
            ";
        }
    }

   public function register($fullname, $email, $password) { // Removed $role parameter
        // 1. Check if email already exists
        $check = "SELECT id FROM users WHERE email = :email";
        $check_stmt = $this->conn->prepare($check);
        $check_stmt->execute([':email' => $email]);

        if ($check_stmt->rowCount() > 0) {
            echo "
                <script>
                    alert('Email already registered!');
                    window.location.href='register.php';
                </script>
            ";
            return;
        } 
        
        // 2. Hash the password
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        
        // 3. Insert new user. Defaulting role to 'Staff'.
        $insert_role = 'Staff'; // Enforcing the role for clinic staff
        $insert = "INSERT INTO users (fullname, email, password, role, created_at) 
                   VALUES(:sName, :Email, :Password, :Role, NOW())";
        $insert_stmt = $this->conn->prepare($insert);
        $result = $insert_stmt->execute([
            ':sName' => $fullname,
            ':Email' => $email,
            ':Password' => $hashed,
            ':Role' => $insert_role
        ]);

        if ($result) {
            echo "
                <script>
                    alert('Staff Account Registered Successfully! You can now log in.');
                    window.location.href='index.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Registration Failed! Please check details.');
                    window.location.href='register.php';
                </script>
            ";
        }
    }

    /**
     * Handles staff login and session creation.
     * Redirects all successful logins to the main dashboard.
     * @param string $email Staff member's email.
     * @param string $password Staff member's plain-text password.
     */
    public function login($email, $password) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 1. Retrieve user data by email
        $query = "SELECT id, fullname, password, role FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // 2. Verify password
        if ($user && password_verify($password, $user['password'])) {
            // Success: Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['role'] = $user['role']; // Will be 'Staff' or 'Admin'

            // 3. Redirect to the main clinic tracking dashboard
            header("location: dashboard_staff.php"); 
            exit;
        } else {
            // Failure
            echo "
                <script>
                    alert('Invalid Email or Password!');
                    window.location.href='login.php';
                </script>
            ";
        }
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        header("location: index.php"); 
        exit;
    }


