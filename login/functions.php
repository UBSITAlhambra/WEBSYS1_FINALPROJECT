<?php
// Database Configuration: UPDATED TO clinic_tracker
define("SERVER", "localhost");
define("USER", "root");
define("PASS", "");
define("DBNAME", "finalproject"); // <<< FINAL DATABASE NAME

class AuthSystem {
    private $conn;

    function __construct(){
        try {
            $connection = "mysql:host=" . SERVER . ";dbname=" . DBNAME . ";charset=utf8";
            $this->conn = new PDO($connection, USER, PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "<script>alert('Connection Failed to " . DBNAME . "');</script>";
            // In production, log $e->getMessage() but don't show it to the user.
            die(); 
        }
    }

    // --- AUTHENTICATION METHODS ---

    /**
     * Handles new user registration (Clinic Staff).
     */
    public function register($fname, $mname, $lname, $email, $password) { 
        // Checks the 'login' table
        $check = "SELECT ID FROM login WHERE Email = :email"; 
        $check_stmt = $this->conn->prepare($check);
        $check_stmt->execute([':email' => $email]);

        if ($check_stmt->rowCount() > 0) {
            echo "<script>alert('Email already registered!'); window.location.href='register.php';</script>";
            return;
        } 
        
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $insert_role = 'Staff'; 
        
        // Inserts data into the 'login' table
        $insert = "INSERT INTO login (FirstName, MiddleName, LastName, Email, Password, Role, Created_At) 
                   VALUES(:Fname, :Mname, :Lname, :Email, :Password, :Role, NOW())"; 
        $insert_stmt = $this->conn->prepare($insert);
        
        $result = $insert_stmt->execute([
            ':Fname' => $fname,
            ':Mname' => $mname,
            ':Lname' => $lname,
            ':Email' => $email,
            ':Password' => $hashed,
            ':Role' => $insert_role
        ]);

        if ($result) {
            echo "<script>alert('Staff Account Registered Successfully! You can now log in.'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Registration Failed! Please check details.'); window.location.href='register.php';</script>";
        }
    }

    /**
     * Handles staff login and session creation.
     */
    public function login($email, $password) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Retrieves data from the 'login' table
        $query = "SELECT ID, FirstName, MiddleName, LastName, Password, Role FROM login WHERE Email = :email"; 
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifies the password against the 'Password' column
        if ($user && password_verify($password, $user['Password'])) { 
            $_SESSION['user_id'] = $user['ID'];
            $_SESSION['fullname'] = trim($user['FirstName'] . ' ' . $user['MiddleName'] . ' ' . $user['LastName']);
            $_SESSION['role'] = $user['Role'];

            header("location: dashboard_staff.php"); 
            exit;
        } else {
            echo "<script>alert('Invalid Email or Password!'); window.location.href='index.php';</script>";
        }
    }

    /**
     * Destroys the current session and redirects the staff member (Logout).
     */
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        header("location: index.php"); 
        exit;
    }
    
    // NOTE: Your student tracking CRUD methods would be placed here.
}
?>