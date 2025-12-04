<?php
define("SERVER", "localhost");
define("USER", "root");
define("PASS", "");
define("DBNAME", "finalproject");

class studentVitals {
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

    /* INSERT vitals */
    public function insert_data($studentID, $vitalDate, $temperature, $bloodPressure, $pulse, $respiratoryRate){
        $insert= "INSERT INTO student_vitals(studentID, vitalDate, temperature, bloodPressure, pulse, respiratoryRate)
                       VALUES(:studentID, :vitalDate, :temperature, :bloodPressure, :pulse, :respiratoryRate)";

        $insert = $this->conn->prepare($insert);

        $result = $insert->execute([
            ':studentID' => $studentID,
            ':vitalDate' => $vitalDate,
            ':temperature' => $temperature,
            ':bloodPressure' => $bloodPressure,
            ':pulse' => $pulse,
            ':respiratoryRate' => $respiratoryRate
        ]);

        if($result){
            echo "<script>alert('Vitals Added'); window.location='index.php';</script>";
        }
    }

    /* SHOW ALL */
    public function show_data(){
        $show = "SELECT v.*, s.name AS studentName 
                     FROM student_vitals v 
                     LEFT JOIN studentrecord s ON v.studentID = s.ID
                     ORDER BY v.vitalDate DESC";

        $show= $this->conn->prepare($show);
        $show->execute();

        return $show->fetchAll(PDO::FETCH_ASSOC);
    }

    /* SHOW ONE RECORD */
    public function show_update_data($vitalID){
        $single= "SELECT * FROM student_vitals WHERE vitalID = :id";

        $single = $this->conn->prepare($single);
        $single->execute([':id' => $vitalID]);

        return $single->fetch(PDO::FETCH_ASSOC);
    }

    /* UPDATE */
    public function update_data($temperature, $bloodPressure, $pulse, $respiratoryRate, $vitalID){
        $update = "UPDATE student_vitals SET 
                          temperature = :temperature, 
                          bloodPressure = :bloodPressure, 
                          pulse = :pulse, 
                          respiratoryRate = :respiratoryRate
                       WHERE vitalID = :id";

        $update = $this->conn->prepare($update);

        $result = $update->execute([
            ':temperature' => $temperature,
            ':bloodPressure' => $bloodPressure,
            ':pulse' => $pulse,
            ':respiratoryRate' => $respiratoryRate,
            ':id' => $vitalID
        ]);

        if($result){
            echo "<script>alert('Vitals Updated'); window.location='index.php';</script>";
        }
    }

    /* DELETE */
    public function delete_data($vitalID){
        $delete = "DELETE FROM student_vitals WHERE vitalID = :id";

        $delete = $this->conn->prepare($delete);

        $result = $delete->execute([':id' => $vitalID]);

        if($result){
            echo "<script>alert('Vitals Deleted'); window.location='index.php';</script>";
        }
    }

    /* FETCH STUDENTS (for dropdown) */
    public function fetch_students() {
        $fetch = "SELECT ID, name FROM studentrecord ORDER BY name DESC";

        $fetch = $this->conn->prepare($fetch);
        $fetch->execute();

        return $fetch->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
