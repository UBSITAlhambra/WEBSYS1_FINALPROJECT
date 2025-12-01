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

    // INSERT INVENTORY ITEM
    public function insert_data($genericName, $dosage, $category, $quantity, $addDate, $expDate){
        $insert = "INSERT INTO inventory(genericName, dosage, category, addDate, expDate, quantity) 
                   VALUES(:genericname, :Dosage, :Category, :AddDate, :ExpDate, :Quantity)";
        $stmt = $this->conn->prepare($insert);
        $result = $stmt->execute([
            ':genericname'=>$genericName,
            ':Dosage'=>$dosage,
            ':Category'=>$category,
            ':AddDate'=>$addDate,
            ':ExpDate'=>$expDate,
            ':Quantity'=>$quantity
        ]);

        if($result){
            echo "<script>alert('Insert Complete'); window.location='index.php';</script>";
        }
    }

    // SHOW ALL ITEMS – MOST RECENT FIRST
    public function show_data(){
        $select = "SELECT * FROM inventory ORDER BY addDate DESC";
        $stmt = $this->conn->prepare($select);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // DELETE ITEM
    public function delete_data($ID){
        $delete = "DELETE FROM inventory WHERE itemID = :id";
        $stmt = $this->conn->prepare($delete);
        $result = $stmt->execute([':id' => $ID]);

        if($result){
            echo "<script>alert('Item Deleted'); window.location='index.php';</script>";
        }
    }

    // SHOW SPECIFIC ITEM FOR UPDATE
    public function show_update_data($ID){
        $update = "SELECT * FROM inventory WHERE itemID = :id";
        $stmt = $this->conn->prepare($update);
        $stmt->execute([':id' => $ID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE ITEM
    public function update_data($genericName, $dosage, $category, $addDate, $expDate, $quantity, $ID){
        $update = "UPDATE inventory SET 
                       genericName = :genericname,
                       dosage = :Dosage,
                       category = :Category,
                       addDate = :AddDate,
                       expDate = :ExpDate,
                       quantity = :Quantity
                   WHERE itemID = :id";

        $stmt = $this->conn->prepare($update);
        $result = $stmt->execute([
            ':genericname'=>$genericName,
            ':Dosage'=>$dosage,
            ':Category'=>$category,
            ':AddDate'=>$addDate,
            ':ExpDate'=>$expDate,
            ':Quantity'=>$quantity,
            ':id'=>$ID
        ]);

        if($result){
            echo "<script>alert('Update Complete'); window.location='index.php';</script>";
        }
    }
}
?>
