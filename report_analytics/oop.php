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

    /* ============================================================
       MOST DISPENSED MEDICINES
    ============================================================ */
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

    /* ============================================================
       VISITS PER MONTH
    ============================================================ */
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

    /* ============================================================
       TOP COMPLAINTS (GLOBAL)
    ============================================================ */
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

    /* ============================================================
       TOP STUDENTS (GLOBAL)
    ============================================================ */
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


    /* ============================================================
       SUMMARY BY GRADE + SECTION
    ============================================================ */
    public function get_summary_by_department() {
        $sql = "SELECT 
                    department,
                    section,
                    COUNT(*) AS total_students,
                    COUNT(complaint) AS total_visits,
                    SUM(gender = 'Male') AS male_count,
                    SUM(gender = 'Female') AS female_count
                FROM studentrecord
                GROUP BY department, section
                ORDER BY department, section";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ============================================================
       NEW: TOP COMPLAINT BY SPECIFIC GRADE LEVEL
    ============================================================ */
    public function top_complaint_by_grade($grade) {
        $sql = "SELECT complaint, COUNT(*) AS count
                FROM studentrecord
                WHERE department = :grade
                AND complaint IS NOT NULL AND complaint <> ''
                GROUP BY complaint
                ORDER BY count DESC
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':grade' => $grade]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* ============================================================
       NEW: TOP STUDENT WITH MOST VISITS BY GRADE
    ============================================================ */
    public function top_student_by_grade($grade) {
        $sql = "SELECT name, COUNT(*) AS visits
                FROM studentrecord
                WHERE department = :grade
                GROUP BY name
                ORDER BY visits DESC
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':grade' => $grade]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
