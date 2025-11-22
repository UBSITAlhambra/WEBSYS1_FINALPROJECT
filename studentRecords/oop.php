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

    // INSERT
    public function insert_data($name, $idNum, $department, $complaint, $visitDate){
        $insert = "INSERT INTO studentrecord(name, idNum, department, complaint, visitDate) 
                   VALUES(:sName, :IDnum, :Department, :Complaint, :VisitDate)";
        $stmt = $this->conn->prepare($insert);
        $result = $stmt->execute([
            ':sName'=>$name,
            ':IDnum'=>$idNum,
            ':Department'=>$department,
            ':Complaint'=>$complaint,
            ':VisitDate'=>$visitDate,
        ]);

        if($result){
            echo "<script>alert('Insert Complete'); window.location='index.php';</script>";
        }
    }

    // SHOW ALL – ORDER BY latest visit first
    public function show_data(){
        $select = "SELECT * FROM studentrecord ORDER BY visitDate DESC";
        $stmt = $this->conn->prepare($select);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // DELETE
    public function delete_data($ID){
        $delete = "DELETE FROM studentrecord WHERE ID = :id";
        $stmt = $this->conn->prepare($delete);
        $result = $stmt->execute([':id' => $ID]);

        if($result){
            echo "<script>alert('Record Deleted'); window.location='index.php';</script>";
        }
    }

    // SHOW ONE
    public function show_update_data($ID){
        $update = "SELECT * FROM studentrecord WHERE ID = :id";
        $stmt = $this->conn->prepare($update);
        $stmt->execute([':id' => $ID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function update_data($name, $idNum, $department, $complaint, $visitDate, $ID){
        $update = "UPDATE studentrecord SET 
                   name = :sName, 
                   idNum = :IDnum, 
                   department = :Department, 
                   complaint = :Complaint, 
                   visitDate = :VisitDate
                   WHERE ID = :id";
        $stmt = $this->conn->prepare($update);
        $result = $stmt->execute([
            ':sName'=>$name,
            ':IDnum'=>$idNum,
            ':Department'=>$department,
            ':Complaint'=>$complaint,
            ':VisitDate'=>$visitDate,
            ':id' => $ID
        ]);

        if($result){
            echo "<script>alert('Update Complete'); window.location='index.php';</script>";
        }
    }
}
?>
