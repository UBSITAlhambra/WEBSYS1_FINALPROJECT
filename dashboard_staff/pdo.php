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
        public function show_inventory(){
        $select = "SELECT * FROM inventory";
        $stmt = $this->conn->prepare($select);
        $stmt->execute();
        return $stmt;
    }
        public function show_studentRecords(){
        $select = "SELECT * FROM studentrecord";
        $stmt = $this->conn->prepare($select);
        $stmt->execute();
        return $stmt;
    }
            public function show_transactions(){
        $select = "SELECT * FROM transaction";
        $stmt = $this->conn->prepare($select);
        $stmt->execute();
        return $stmt;
    }
    public function get_weekly_visits() {
        $sql = "SELECT COUNT(*) AS total
            FROM studentrecord
            WHERE visitDate >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
        return $this->conn->query($sql);
    }


    public function get_items_used_weekly() {
        $sql = "SELECT SUM(quantity) AS total
            FROM `transaction`
            WHERE transactionDate >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
    return $this->conn->query($sql);
    }


    public function get_new_inventory_weekly() {
        $sql = "SELECT COUNT(*) AS total
            FROM inventory
            WHERE addDate >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
        return $this->conn->query($sql);
    }


    public function get_common_complaint_weekly() {
        $sql = "SELECT complaint, COUNT(*) AS count
            FROM studentrecord
            WHERE visitDate >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
            GROUP BY complaint
            ORDER BY count DESC
            LIMIT 1";
        return $this->conn->query($sql);
    }


    
}