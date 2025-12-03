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

    // INSERT - UPDATED to include role
    public function insert_data($name, $gender, $role, $idNum, $department, $section, $complaint, $visitDate){
        $insert = "INSERT INTO studentrecord(name, gender, role, idNum, department, section, complaint, visitDate) 
                    VALUES(:sName, :gender, :role, :IDnum, :Department, :Section, :Complaint, :VisitDate)";
        $stmt = $this->conn->prepare($insert);
        $result = $stmt->execute([
            ':sName'=>$name,
            ':gender'=>$gender,
            ':role'=>$role, // ADDED BINDING
            ':IDnum'=>$idNum,
            ':Department'=>$department,
            ':Section'=>$section,
            ':Complaint'=>$complaint,
            ':VisitDate'=>$visitDate,
        ]);

        if($result){
            echo "<script>window.location='../studentVital/add.php';</script>";
        }
    }

    // SHOW ALL – Added role to select
    public function show_data(){
        $select = "SELECT 
            sr.*,
            sr.role,  /* Ensuring role is included explicitly */
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
        ORDER BY sr.visitDate DESC;";
        $stmt = $this->conn->prepare($select);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // DELETE – NO CHANGES NEEDED
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

    // SHOW ONE – No change needed as sr.* is used
    public function show_update_data($ID){
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

    // UPDATE - UPDATED to include role
    public function update_data($name, $gender, $role, $idNum, $department, $section, $complaint, $visitDate, $ID){
        $update = "UPDATE studentrecord SET 
            name = :sName, 
            gender = :gender,
            role = :role, /* ADDED ROLE */
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
            ':role'=>$role, // ADDED BINDING
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

    // SHOW ONE WITH VITALS – No change needed
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

    // UPDATE WITH VITALS - UPDATED to include role
    public function update_data_with_vitals($name, $gender, $role, $idNum, $department, $section, $complaint, $visitDate, $ID, $temperature, $bloodPressure, $pulse, $respiratoryRate, $vitalDate){
        $this->conn->beginTransaction();
        
        try {
            $update_record = "UPDATE studentrecord SET 
                name = :sName, 
                gender = :gender,
                role = :role, /* ADDED ROLE */
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
                ':role'=>$role, // ADDED BINDING
                ':IDnum'=>$idNum,
                ':Department'=>$department,
                ':Section'=>$section,
                ':Complaint'=>$complaint,
                ':VisitDate'=>$visitDate,
                ':id' => $ID
            ]);

            // Vitals Upsert logic remains the same...
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

            $this->conn->commit();
            echo "<script>alert('Update Complete'); window.location='index.php';</script>";
        } catch (Exception $e) {
            $this->conn->rollBack();
            echo "<script>alert('Update Failed: " . addslashes($e->getMessage()) . "');</script>";
        }
    }

    // INSERT WITH VITALS - UPDATED to include role
    public function insert_data_with_vitals($name, $gender, $role, $idNum, $department, $section, $complaint, $visitDate, $temperature, $bloodPressure, $pulse, $respiratoryRate, $vitalDate){
        $this->conn->beginTransaction();
        
        try {
            $insert_record = "INSERT INTO studentrecord(name, gender, role, idNum, department, section, complaint, visitDate) 
                              VALUES(:sName, :gender, :Role, :IDnum, :Department, :Section, :Complaint, :VisitDate)"; // <-- ADDED role column name
            $stmt1 = $this->conn->prepare($insert_record);
            $stmt1->execute([
                ':sName'=>$name,
                ':gender'=>$gender,
                ':Role'=>$role, // <-- ADDED BINDING
                ':IDnum'=>$idNum,
                ':Department'=>$department,
                ':Section'=>$section,
                ':Complaint'=>$complaint,
                ':VisitDate'=>$visitDate,
            ]);
            
            $studentID = $this->conn->lastInsertId();
            
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
}
?>