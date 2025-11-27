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

        public function insert_data($genericName, $dosage, $brand, $category, $quantity, $addDate, $expDate){
            $insert = "INSERT INTO inventory(genericName, dosage, brand, category, addDate, expDate, quantity) 
                        VALUES(:genericname, :Dosage, :Brand, :Category, :AddDate, :ExpDate, :Quantity)";
            $stmt = $this->conn->prepare($insert);
            $result = $stmt->execute([
                ':genericname'=>$genericName,
                ':Dosage'=>$dosage,
                ':Brand'=>$brand,
                ':Category'=>$category,
                ':AddDate'=>$addDate,
                ':ExpDate'=>$expDate,
                ':Quantity'=>$quantity
            ]);

            if($result){
                echo "<script>alert('Insert Complete'); window.location='index.php';</script>";
            }
        }

        public function show_data(){
            $select = "SELECT * FROM inventory ORDER BY addDate DESC";
            $stmt = $this->conn->prepare($select);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function delete_data($ID){
            $delete = "DELETE FROM inventory WHERE itemID = :id";
            $stmt = $this->conn->prepare($delete);
            $result = $stmt->execute([':id' => $ID]);

            if($result){
                echo "<script>alert('Item Deleted'); window.location='index.php';</script>";
            }
        }

        public function show_update_data($ID){
            $update = "SELECT * FROM inventory WHERE itemID = :id";
            $stmt = $this->conn->prepare($update);
            $stmt->execute([':id' => $ID]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function update_data($genericName, $dosage, $brand, $category, $addDate, $expDate, $quantity, $ID){
            $update = "UPDATE inventory SET 
                            genericName = :genericname,
                            dosage = :Dosage,
                            brand = :Brand,
                            category = :Category,
                            addDate = :AddDate,
                            expDate = :ExpDate,
                            quantity = :Quantity
                        WHERE itemID = :id";

            $stmt = $this->conn->prepare($update);
            $result = $stmt->execute([
                ':genericname'=>$genericName,
                ':Dosage'=>$dosage,
                ':Brand'=>$brand,
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

        //SEARCH FUNCTION
        public function search_inventory($searchTerm) {
            $term = '%' . $searchTerm . '%';
            $search = "SELECT itemID, genericName, dosage, brand, category, quantity, addDate, expDate 
                    FROM inventory 
                    WHERE genericName LIKE :term 
                    OR brand LIKE :term 
                    OR category LIKE :term
                    OR dosage LIKE :term
                    ORDER BY genericName ASC";
            
            $stmt = $this->conn->prepare($search);
            $stmt->execute([':term' => $term]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        }
        //NOTIFICATION FUNCTIONS
        //Checks inventory for items with quantity BELOW THE DEFINED THRESHOLD.
        //Change the value of the variable "threshold" if needed
        //Threshold is currently set to 50
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

        //Checks inventory for items expiring WITHIN THE NEXT 90 DAYS.
        //Change the value of the variable "days" if needed
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