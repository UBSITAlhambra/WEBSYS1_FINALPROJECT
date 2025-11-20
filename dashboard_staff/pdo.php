<?php
define("SERVER", "localhost");
define("USER", "root");
define("PASS", "");
define("DBNAME", "finalproject");

class oop_class {
    private $conn;

    // function __construct(){
    //     try {
    //         $connection = "mysql:host=" . SERVER . ";dbname=" . DBNAME . ";charset=utf8";
    //         $this->conn = new PDO($connection, USER, PASS);
    //         $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //     } catch (PDOException $e) {
    //         echo "
    //             <script>
    //             alert('Connection Failed');
    //             </script>
    //         ";
    //     }
    // }
        public function show_datat(){
        $select = "SELECT * FROM studentrecord AND inventory";
        $stmt = $this->conn->prepare($select);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}