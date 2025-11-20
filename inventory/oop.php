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

    public function insert_data($genericName, $dosage, $brand, $category, $quantity, $addDate, $expDate){
        $insert = "INSERT INTO inventory(genericName, dosage, brand, category, addDate, expDate, quantity) VALUES(:genericname, :Dosage, :Brand, :Category, :AddDate, :ExpDate, :Quantity)";
        $stmt = $this->conn->prepare($insert);
        $result = $stmt->execute([
            ':genericname'=>$genericName,
            ':Dosage'=>$dosage,
            ':Brand'=>$brand,
            ':Category'=>$category,
            ':AddDate'=>$addDate,
            ':ExpDate'=>$expDate,
            ':Quantity'=>$quantity,
        ]);

        if($result){
            echo "
                <script>
                alert('Insert Complete');
                </script>
            ";
        }
    }

    public function show_data(){
        $select = "SELECT * FROM inventory";
        $stmt = $this->conn->prepare($select);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete_data($ID){
        $delete = "DELETE FROM inventory WHERE itemID = :id";
        $stmt = $this->conn->prepare($delete);
        $result = $stmt->execute([':id' => $ID]);

        if($result){
            echo "
                <script>
                    alert('ITEM DELETED');
                </script>
            ";
        }
    }

    public function show_update_data($ID){
        $update = "SELECT * FROM inventory WHERE itemID = :id";
        $stmt = $this->conn->prepare($update);
        $stmt->execute([':id' => $ID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update_data($genericName, $dosage, $brand, $category, $addDate, $expDate, $ID, $quantity){
        $update = "UPDATE inventory SET 
                   genericName = :genericname, dosage = :Dosage, brand = :Brand, 
                   category = :Category, addDate = :AddDate, expDate = :ExpDate, quantity= :Quantity
                   WHERE ID = :id";
        $stmt = $this->conn->prepare($update);
        $result = $stmt->execute([
            ':genericname'=>$genericName,
            ':Dosage'=>$dosage,
            ':Brand'=>$brand,
            ':Category'=>$category,
            ':AddDate'=>$addDate,
            ':ExpDate'=>$expDate,
            ':id' => $ID,
            ':Quantity'=>$quantity,
        ]);

        if($result){
            echo "
                <script>
                alert('Update Complete');
                </script>
            ";
        }
    }
}


