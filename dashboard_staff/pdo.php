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
                echo "<script>alert('Connection Failed');</script>";
            }
        }

        // Fetch whole inventory table
        public function show_inventory(){
            $select = "SELECT * FROM inventory";
            $stmt = $this->conn->prepare($select);
            $stmt->execute();
            return $stmt;
        }

        // Fetch whole student records table
        public function show_studentRecords(){
            $select = "SELECT * FROM studentrecord";
            $stmt = $this->conn->prepare($select);
            $stmt->execute();
            return $stmt;
        }

        // Fetch transactions with student name and medicine generic name for dashboard
        public function show_transactions(){
            $select = "
                SELECT 
                    t.transactionID,
                    t.quantity,
                    t.transactionDate,
                    i.genericName AS medicineName,
                    s.name AS studentName
                FROM transaction t
                LEFT JOIN inventory i ON t.itemID = i.itemID
                LEFT JOIN studentrecord s ON t.studentID = s.ID
                ORDER BY t.transactionID DESC
            ";
            $stmt = $this->conn->prepare($select);
            $stmt->execute();
            return $stmt;
        }

        // Get weekly clinic visits
        public function get_weekly_visits() {
            $sql = "SELECT COUNT(*) AS total
                    FROM studentrecord
                    WHERE visitDate >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
            return $this->conn->query($sql);
        }

        // Get number of items used this week
        public function get_items_used_weekly() {
            $sql = "SELECT SUM(quantity) AS total
                    FROM `transaction`
                    WHERE transactionDate >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
            return $this->conn->query($sql);
        }

        // Get new inventory items this week
        public function get_new_inventory_weekly() {
            $sql = "SELECT COUNT(*) AS total
                    FROM inventory
                    WHERE addDate >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
            return $this->conn->query($sql);
        }

        // Get most common complaint this week
        public function get_common_complaint_weekly() {
            $sql = "SELECT complaint, COUNT(*) AS count
                    FROM studentrecord
                    WHERE visitDate >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                    GROUP BY complaint
                    ORDER BY count DESC
                    LIMIT 1";
            return $this->conn->query($sql);
        }

        // --- AJAX SEARCH BY STUDENT ID NUMBER ---
        public function search_by_idNum($idNum) {
            $sql = "SELECT * FROM studentrecord WHERE idNum = :idNum LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':idNum' => $idNum]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
         //NOTIFICATION FUNCTIONS
        //Checks inventory for items with quantity below the threshold (50).
        public function get_low_stock_items($threshold = 50) {
            $sql = "SELECT itemID, genericName, quantity, category 
                    FROM inventory 
                    WHERE quantity < :threshold 
                    ORDER BY quantity ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':threshold', $threshold, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //Checks inventory for items expiring within the next 90 days.
        public function get_expiring_items($days = 90) {
            $expiry_date = date('Y-m-d', strtotime("+$days days"));
            
            $sql = "SELECT itemID, genericName, expDate, quantity 
                    FROM inventory 
                    WHERE expDate <= :expiry_date AND expDate >= CURDATE()
                    ORDER BY expDate ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':expiry_date', $expiry_date, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>