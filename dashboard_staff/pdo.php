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
    // Fetch student records along with their latest vitals
public function show_studentRecords_with_vitals(){
    $select = "
        SELECT 
            sr.*,
            sv.temperature,
            sv.bloodPressure,
            sv.pulse,
            sv.respiratoryRate,
            sv.vitalDate
        FROM studentrecord sr
        LEFT JOIN student_vitals sv ON sr.ID = sv.studentID
            AND sv.vitalDate = (
                SELECT MAX(vitalDate) 
                FROM student_vitals sv2 
                WHERE sv2.studentID = sr.ID
            )
        ORDER BY sr.visitDate DESC
    ";
    $stmt = $this->conn->prepare($select);
    $stmt->execute();
    return $stmt;
}

}
?>
