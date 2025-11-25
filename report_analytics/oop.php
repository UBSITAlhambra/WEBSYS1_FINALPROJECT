<?php
define("SERVER", "localhost");
define("USER", "root");
define("PASS", "");
define("DBNAME", "finalproject");

class reports {
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

    // Most dispensed medicines
    public function top_medicines($limit=10) {
        $sql = "SELECT i.genericName AS medicine, SUM(t.quantity) as total_dispensed
                FROM transaction t
                JOIN inventory i ON t.itemID = i.itemID
                GROUP BY t.itemID
                ORDER BY total_dispensed DESC
                LIMIT :lim";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':lim', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Visits per month (returns last 12 months)
    public function visits_per_month() {
        $sql = "SELECT DATE_FORMAT(visitDate, '%Y-%m') AS month, COUNT(*) AS total_visits
                FROM studentrecord
                GROUP BY month
                ORDER BY month DESC
                LIMIT 12";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Top complaints
    public function top_complaints($limit=10) {
        $sql = "SELECT complaint, COUNT(*) AS count
                FROM studentrecord
                GROUP BY complaint
                ORDER BY count DESC
                LIMIT :lim";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':lim', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Students with most visits
    public function top_students($limit=10) {
        $sql = "SELECT name, COUNT(*) AS visits
                FROM studentrecord
                GROUP BY name
                ORDER BY visits DESC
                LIMIT :lim";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':lim', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
