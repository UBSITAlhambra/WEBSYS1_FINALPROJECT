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

    // INSERT (Expanded to include gender and section)
    public function insert_data($name, $gender, $idNum, $department, $section, $complaint, $visitDate){
        $insert = "INSERT INTO studentrecord(name, gender, idNum, department, section, complaint, visitDate) 
                    VALUES(:sName, :gender, :IDnum, :Department, :Section, :Complaint, :VisitDate)";
        $stmt = $this->conn->prepare($insert);
        $result = $stmt->execute([
            ':sName'=>$name,
            ':gender'=>$gender,
            ':IDnum'=>$idNum,
            ':Department'=>$department,
            ':Section'=>$section,
            ':Complaint'=>$complaint,
            ':VisitDate'=>$visitDate,
        ]);

        if($result){
            // Redirect to Vitals form after successful record creation
            echo "<script>window.location='../studentVital/add.php';</script>";
        }
    }

    // SHOW ALL (Expanded to JOIN with student_vitals for dashboard table view)
    public function show_data(){
        $select = "SELECT 
            sr.*,
            sv.temperature,
            sv.bloodPressure,
            sv.pulse,
            sv.respiratoryRate,
            sv.vitalDate
        FROM studentrecord sr
        LEFT JOIN student_vitals sv ON sr.ID = sv.studentID
            AND sv.vitalDate = (
                -- Subquery to find the MAX (most recent) vital date for this student
                SELECT MAX(vitalDate) 
                FROM student_vitals sv2 
                WHERE sv2.studentID = sr.ID
            )
        ORDER BY sr.visitDate DESC";
        $stmt = $this->conn->prepare($select);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // DELETE (Handles deletion in both studentrecord and student_vitals using transactions)
    public function delete_data($ID){
        $this->conn->beginTransaction();
        
        try {
            $delete_vitals = "DELETE FROM student_vitals WHERE studentID = :id";
            $stmt1 = $this->conn->prepare($delete_vitals);
            $stmt1->execute([':id' => $ID]);
            
            $delete_record = "DELETE FROM studentrecord WHERE ID = :id";
            $stmt2 = $this->conn->prepare($delete_record);
            $result = $stmt2->execute([':id' => $ID]);

            $this->conn->commit();
            
            if($result){
                echo "<script>alert('Record Deleted Successfully'); window.location='index.php';</script>";
            }
        } catch (Exception $e) {
            $this->conn->rollBack();
            echo "<script>alert('Delete Failed: " . addslashes($e->getMessage()) . "');</script>";
        }
    }

    // SHOW ONE (Used for fetching record data, updated to include new fields)
    public function show_update_data($ID){
        $select = "SELECT 
            sr.*
        FROM studentrecord sr
        WHERE sr.ID = :id";
        $stmt = $this->conn->prepare($select);
        $stmt->execute([':id' => $ID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE (Expanded to include gender and section)
    public function update_data($name, $gender, $idNum, $department, $section, $complaint, $visitDate, $ID){
        $update = "UPDATE studentrecord SET 
            name = :sName, 
            gender = :gender,
            idNum = :IDnum, 
            department = :Department, 
            section = :Section,
            complaint = :Complaint, 
            visitDate = :VisitDate
            WHERE ID = :id";
        $stmt = $this->conn->prepare($update);
        $result = $stmt->execute([
            ':sName'=>$name,
            ':gender'=>$gender,
            ':IDnum'=>$idNum,
            ':Department'=>$department,
            ':Section'=>$section,
            ':Complaint'=>$complaint,
            ':VisitDate'=>$visitDate,
            ':id' => $ID
        ]);

        if($result){
            echo "<script>alert('Update Complete'); window.location='index.php';</script>";
        }
    }

    // SHOW ONE WITH VITALS (Used for updating the vitals form)
    public function show_update_data_with_vitals($ID){
        $select = "SELECT 
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
        WHERE sr.ID = :id";
        $stmt = $this->conn->prepare($select);
        $stmt->execute([':id' => $ID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE WITH VITALS (Handles updating both student record and vitals table)
    public function update_data_with_vitals($name, $gender, $idNum, $department, $section, $complaint, $visitDate, $ID, $temperature, $bloodPressure, $pulse, $respiratoryRate, $vitalDate){
        $this->conn->beginTransaction();
        
        try {
            // 1. Update Student Record
            $update_record = "UPDATE studentrecord SET 
                name = :sName, 
                gender = :gender,
                idNum = :IDnum, 
                department = :Department, 
                section = :Section,
                complaint = :Complaint, 
                visitDate = :VisitDate
                WHERE ID = :id";
            $stmt1 = $this->conn->prepare($update_record);
            $stmt1->execute([
                ':sName'=>$name,
                ':gender'=>$gender,
                ':IDnum'=>$idNum,
                ':Department'=>$department,
                ':Section'=>$section,
                ':Complaint'=>$complaint,
                ':VisitDate'=>$visitDate,
                ':id' => $ID
            ]);

            // 2. Insert/Update Vitals Record (using ON DUPLICATE KEY UPDATE logic)
            // Note: This requires studentID and vitalDate to be a unique key/primary key combination
            if ($temperature || $bloodPressure || $pulse || $respiratoryRate) {
                $upsert_vitals = "INSERT INTO student_vitals (studentID, vitalDate, temperature, bloodPressure, pulse, respiratoryRate) 
                                 VALUES (:studentID, :vitalDate, :temperature, :bloodPressure, :pulse, :respiratoryRate)
                                 ON DUPLICATE KEY UPDATE
                                 temperature = :temperature2, 
                                 bloodPressure = :bloodPressure2, 
                                 pulse = :pulse2, 
                                 respiratoryRate = :respiratoryRate2, 
                                 vitalDate = :vitalDate2";
                $stmt2 = $this->conn->prepare($upsert_vitals);
                $stmt2->execute([
                    ':studentID' => $ID,
                    ':vitalDate' => $vitalDate,
                    ':temperature' => $temperature,
                    ':bloodPressure' => $bloodPressure,
                    ':pulse' => $pulse,
                    ':respiratoryRate' => $respiratoryRate,
                    ':temperature2' => $temperature,
                    ':bloodPressure2' => $bloodPressure,
                    ':pulse2' => $pulse,
                    ':respiratoryRate2' => $respiratoryRate,
                    ':vitalDate2' => $vitalDate
                ]);
            }

            $this->conn->commit();
            echo "<script>alert('Update Complete'); window.location='index.php';</script>";
        } catch (Exception $e) {
            $this->conn->rollBack();
            echo "<script>alert('Update Failed: " . addslashes($e->getMessage()) . "');</script>";
        }
    }
    
    // INSERT WITH VITALS (Handles inserting both student record and vitals table for new records)
    public function insert_data_with_vitals($name, $gender, $idNum, $department, $section, $complaint, $visitDate, $temperature, $bloodPressure, $pulse, $respiratoryRate, $vitalDate){
        $this->conn->beginTransaction();
        
        try {
            // 1. Insert Student Record
            $insert_record = "INSERT INTO studentrecord(name, gender, idNum, department, section, complaint, visitDate) 
                              VALUES(:sName, :gender, :IDnum, :Department, :Section, :Complaint, :VisitDate)";
            $stmt1 = $this->conn->prepare($insert_record);
            $stmt1->execute([
                ':sName'=>$name,
                ':gender'=>$gender,
                ':IDnum'=>$idNum,
                ':Department'=>$department,
                ':Section'=>$section,
                ':Complaint'=>$complaint,
                ':VisitDate'=>$visitDate,
            ]);
            
            $studentID = $this->conn->lastInsertId();
            
            // 2. Insert Vitals Record
            if ($temperature || $bloodPressure || $pulse || $respiratoryRate) {
                $insert_vitals = "INSERT INTO student_vitals (studentID, vitalDate, temperature, bloodPressure, pulse, respiratoryRate) 
                                 VALUES (:studentID, :vitalDate, :temperature, :bloodPressure, :pulse, :respiratoryRate)";
                $stmt2 = $this->conn->prepare($insert_vitals);
                $stmt2->execute([
                    ':studentID' => $studentID,
                    ':vitalDate' => $vitalDate,
                    ':temperature' => $temperature,
                    ':bloodPressure' => $bloodPressure,
                    ':pulse' => $pulse,
                    ':respiratoryRate' => $respiratoryRate
                ]);
            }
            
            $this->conn->commit();
            echo "<script>alert('Record Added Successfully'); window.location='index.php';</script>";
        } catch (Exception $e) {
            $this->conn->rollBack();
            echo "<script>alert('Add Failed: " . addslashes($e->getMessage()) . "');</script>";
        }
    }


    // SEARCH FUNCTION
    public function search_studentRecords($searchTerm) {
        $term = '%' . $searchTerm . '%';
        $search = "SELECT 
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
        WHERE sr.name LIKE :term 
        OR sr.idNum LIKE :term 
        OR sr.department LIKE :term
        OR sr.complaint LIKE :term
        ORDER BY sr.visitDate DESC";
        
        $stmt = $this->conn->prepare($search);
        $stmt->execute([':term' => $term]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
}
?>