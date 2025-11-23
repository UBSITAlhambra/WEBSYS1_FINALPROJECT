<?php
    define("SERVER", "localhost");
    define("USER", "root");
    define("PASS", "");
    define("DBNAME", "finalproject");

    class oop_class {
        private $conn;

<<<<<<< Updated upstream
    function __construct() {
        try {
            $connection = "mysql:host=" . SERVER . ";dbname=" . DBNAME . ";charset=utf8";
            $this->conn = new PDO($connection, USER, PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "<script>alert('Connection Failed');</script>";
        }
    }

    // PUBLIC connection getter (needed for dropdowns)
    public function get_connection() {
        return $this->conn;
    }

    // GET itemID using medicine name
    public function get_itemID_by_name($genericName) {
        $query = "SELECT itemID FROM inventory WHERE genericName = :name LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':name' => $genericName]);
        return $stmt->fetchColumn();
    }

    // GET studentID using student name
    public function get_studentID_by_name($studentName) {
        $query = "SELECT ID FROM studentrecord WHERE name = :name LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':name' => $studentName]);
        return $stmt->fetchColumn();
    }

    // INSERT Transaction using NAME
    public function insert_data_by_name($quantity, $transactionDate, $medicineName, $studentName) {
        $itemID = $this->get_itemID_by_name($medicineName);
        $studentID = $this->get_studentID_by_name($studentName);

        if (!$itemID || !$studentID) {
            echo "<script>alert('Invalid Medicine or Student Name');</script>";
            return;
        }

        // Check stock first
        $stockCheck = $this->conn->prepare("SELECT quantity FROM inventory WHERE itemID = :id");
        $stockCheck->execute([':id' => $itemID]);
        $stock = $stockCheck->fetchColumn();

        if ($stock < $quantity) {
            echo "<script>alert('Not Enough Stock');</script>";
            return;
        }

        // Start transaction
        $this->conn->beginTransaction();

        try {
            // Insert transaction
            $insert = "INSERT INTO transaction (quantity, transactionDate, itemID, studentID)
                       VALUES (:quantity, :date, :itemID, :studentID)";
            $stmt = $this->conn->prepare($insert);
            $stmt->execute([
                ':quantity' => $quantity,
                ':date' => $transactionDate,
                ':itemID' => $itemID,
                ':studentID' => $studentID
            ]);

            // Deduct stock
            $deduct = "UPDATE inventory SET quantity = quantity - :qty WHERE itemID = :id";
            $stmt2 = $this->conn->prepare($deduct);
            $stmt2->execute([
                ':qty' => $quantity,
                ':id' => $itemID
            ]);

            $this->conn->commit();
            echo "<script>alert('Transaction Added Successfully');</script>";

        } catch (Exception $e) {
            $this->conn->rollBack();
            echo "<script>alert('Error while inserting');</script>";
=======
        function __construct() {
            try {
                $connection = "mysql:host=" . SERVER . ";dbname=" . DBNAME . ";charset=utf8";
                $this->conn = new PDO($connection, USER, PASS);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "<script>alert('Connection Failed');</script>";
            }
        }

        public function get_connection() {
            return $this->conn;
        }

        public function get_itemID_by_name($genericName) {
            $query = "SELECT itemID FROM inventory WHERE genericName = :name LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([':name' => $genericName]);
            return $stmt->fetchColumn();
>>>>>>> Stashed changes
        }

        public function get_studentID_by_name($studentName) {
            $query = "SELECT ID FROM studentrecord WHERE name = :name LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([':name' => $studentName]);
            return $stmt->fetchColumn();
        }

<<<<<<< Updated upstream
    // DELETE Transaction
    public function delete_data($transactionID) {
        $delete = "DELETE FROM transaction WHERE transactionID = :id";
        $stmt = $this->conn->prepare($delete);
        $stmt->execute([':id' => $transactionID]);
        echo "<script>alert('Transaction Deleted');</script>";
    }

    // GET Transaction by ID
    public function show_update_data($transactionID) {
        $select = "SELECT * FROM transaction WHERE transactionID = :id";
        $stmt = $this->conn->prepare($select);
        $stmt->execute([':id' => $transactionID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE Transaction using NAME and update inventory
    public function update_data($quantity, $transactionDate, $medicineName, $studentName, $transactionID) {
        $itemID = $this->get_itemID_by_name($medicineName);
        $studentID = $this->get_studentID_by_name($studentName);

        // Fetch the original transaction quantity and itemID
        $original = $this->show_update_data($transactionID);
        $origQuantity = $original['quantity'];
        $origItemID = $original['itemID'];

        try {
            $this->conn->beginTransaction();

            if ($itemID != $origItemID) {
                // Restore old inventory
                $restore = $this->conn->prepare("UPDATE inventory SET quantity = quantity + :origQty WHERE itemID = :origItemID");
                $restore->execute([
                    ':origQty' => $origQuantity,
                    ':origItemID' => $origItemID
                ]);

                // Deduct new inventory (check stock first)
                $stockStmt = $this->conn->prepare("SELECT quantity FROM inventory WHERE itemID = :itemID");
                $stockStmt->execute([':itemID' => $itemID]);
                $stock = $stockStmt->fetchColumn();
                if ($stock < $quantity) {
                    $this->conn->rollBack();
                    echo "<script>alert('Not Enough Stock for selected medicine');</script>";
                    return;
                }
                $deduct = $this->conn->prepare("UPDATE inventory SET quantity = quantity - :qty WHERE itemID = :itemID");
                $deduct->execute([
                    ':qty' => $quantity,
                    ':itemID' => $itemID
                ]);
            } else {
                // Same medicine: update quantity based on delta
                $delta = $quantity - $origQuantity;
                if ($delta != 0) {
                    // If increasing, check stock first
                    if ($delta > 0) {
                        $stockStmt = $this->conn->prepare("SELECT quantity FROM inventory WHERE itemID = :itemID");
                        $stockStmt->execute([':itemID' => $itemID]);
                        $stock = $stockStmt->fetchColumn();
                        if ($stock < $delta) {
                            $this->conn->rollBack();
                            echo "<script>alert('Not Enough Stock');</script>";
                            return;
                        }
                    }
                    $adj = $this->conn->prepare("UPDATE inventory SET quantity = quantity - :delta WHERE itemID = :itemID");
                    $adj->execute([
                        ':delta' => $delta,
                        ':itemID' => $itemID
                    ]);
                }
            }

            // Update transaction record
            $update = "UPDATE transaction SET 
                          quantity = :quantity,
                          transactionDate = :date,
                          itemID = :itemID,
                          studentID = :studentID
                       WHERE transactionID = :id";
            $stmt = $this->conn->prepare($update);
            $stmt->execute([
                ':quantity' => $quantity,
                ':date' => $transactionDate,
                ':itemID' => $itemID,
                ':studentID' => $studentID,
                ':id' => $transactionID
            ]);

            $this->conn->commit();
            echo "<script>alert('Transaction Updated');</script>";
        } catch (Exception $e) {
            $this->conn->rollBack();
            echo "<script>alert('Error during update');</script>";
=======
        // INSERT using NAME
        public function insert_data_by_name($quantity, $transactionDate, $medicineName, $studentName) {
            $itemID = $this->get_itemID_by_name($medicineName);
            $studentID = $this->get_studentID_by_name($studentName);

            if (!$itemID || !$studentID) {
                echo "<script>alert('Invalid Medicine or Student Name');</script>";
                return;
            }

            $stockCheck = $this->conn->prepare("SELECT quantity FROM inventory WHERE itemID = :id");
            $stockCheck->execute([':id' => $itemID]);
            $stock = $stockCheck->fetchColumn();

            if ($stock < $quantity) {
                echo "<script>alert('Not Enough Stock');</script>";
                return;
            }

            $this->conn->beginTransaction();

            try {
                $insert = "INSERT INTO transaction (quantity, transactionDate, itemID, studentID)
                        VALUES (:quantity, :date, :itemID, :studentID)";
                $stmt = $this->conn->prepare($insert);
                $stmt->execute([
                    ':quantity' => $quantity,
                    ':date' => $transactionDate,
                    ':itemID' => $itemID,
                    ':studentID' => $studentID
                ]);

                $deduct = "UPDATE inventory SET quantity = quantity - :qty WHERE itemID = :id";
                $stmt2 = $this->conn->prepare($deduct);
                $stmt2->execute([
                    ':qty' => $quantity,
                    ':id' => $itemID
                ]);

                $this->conn->commit();
                echo "<script>alert('Transaction Added Successfully'); window.location='index.php';</script>";

            } catch (Exception $e) {
                $this->conn->rollBack();
                echo "<script>alert('Error while inserting');</script>";
            }
        }

        // SHOW all transactions with names
        public function show_data() {
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
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function delete_data($transactionID) {
            $delete = "DELETE FROM transaction WHERE transactionID = :id";
            $stmt = $this->conn->prepare($delete);
            $stmt->execute([':id' => $transactionID]);
            echo "<script>alert('Transaction Deleted'); window.location='index.php';</script>";
        }

        public function show_update_data($transactionID) {
            $select = "SELECT * FROM transaction WHERE transactionID = :id";
            $stmt = $this->conn->prepare($select);
            $stmt->execute([':id' => $transactionID]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // UPDATE using NAME + inventory update
        public function update_data($quantity, $transactionDate, $medicineName, $studentName, $transactionID) {
            $itemID = $this->get_itemID_by_name($medicineName);
            $studentID = $this->get_studentID_by_name($studentName);

            $original = $this->show_update_data($transactionID);
            $origQuantity = $original['quantity'];
            $origItemID = $original['itemID'];

            try {
                $this->conn->beginTransaction();

                if ($itemID != $origItemID) {
                    $restore = $this->conn->prepare("UPDATE inventory SET quantity = quantity + :origQty WHERE itemID = :origItemID");
                    $restore->execute([
                        ':origQty' => $origQuantity,
                        ':origItemID' => $origItemID
                    ]);

                    $stockStmt = $this->conn->prepare("SELECT quantity FROM inventory WHERE itemID = :itemID");
                    $stockStmt->execute([':itemID' => $itemID]);
                    $stock = $stockStmt->fetchColumn();

                    if ($stock < $quantity) {
                        $this->conn->rollBack();
                        echo "<script>alert('Not Enough Stock for selected medicine');</script>";
                        return;
                    }

                    $deduct = $this->conn->prepare("UPDATE inventory SET quantity = quantity - :qty WHERE itemID = :itemID");
                    $deduct->execute([
                        ':qty' => $quantity,
                        ':itemID' => $itemID
                    ]);

                } else {
                    $delta = $quantity - $origQuantity;

                    if ($delta != 0) {
                        if ($delta > 0) {
                            $stockStmt = $this->conn->prepare("SELECT quantity FROM inventory WHERE itemID = :itemID");
                            $stockStmt->execute([':itemID' => $itemID]);
                            $stock = $stockStmt->fetchColumn();

                            if ($stock < $delta) {
                                $this->conn->rollBack();
                                echo "<script>alert('Not Enough Stock');</script>";
                                return;
                            }
                        }
                        $adj = $this->conn->prepare("UPDATE inventory SET quantity = quantity - :delta WHERE itemID = :itemID");
                        $adj->execute([
                            ':delta' => $delta,
                            ':itemID' => $itemID
                        ]);
                    }
                }

                $update = "UPDATE transaction SET 
                            quantity = :quantity,
                            transactionDate = :date,
                            itemID = :itemID,
                            studentID = :studentID
                        WHERE transactionID = :id";
                $stmt = $this->conn->prepare($update);
                $stmt->execute([
                    ':quantity' => $quantity,
                    ':date' => $transactionDate,
                    ':itemID' => $itemID,
                    ':studentID' => $studentID,
                    ':id' => $transactionID
                ]);

                $this->conn->commit();
                echo "<script>alert('Transaction Updated'); window.location='index.php';</script>";

            } catch (Exception $e) {
                $this->conn->rollBack();
                echo "<script>alert('Error during update');</script>";
            }
        }

        //SEARCH
        public function search_transactions_by_name($searchTerm) {
            $term = '%' . $searchTerm . '%';
            
            //Define the complex SQL query using LEFT JOINs.
            $search = "
                SELECT 
                    t.transactionID,
                    t.quantity,
                    t.transactionDate,
                    i.genericName AS medicineName,
                    s.name AS studentName
                FROM transaction t
                LEFT JOIN inventory i ON t.itemID = i.itemID
                LEFT JOIN studentrecord s ON t.studentID = s.ID
                WHERE 
                    i.genericName LIKE :term OR 
                    s.name LIKE :term OR
                    t.transactionID LIKE :term 
                ORDER BY t.transactionDate DESC
            ";
    
            $stmt = $this->conn->prepare($search);
            
            $stmt->execute([':term' => $term]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC); 
>>>>>>> Stashed changes
        }
    }
?>