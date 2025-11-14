<?php
    class inventoryCRUD{
        private $pdo;

        function __construct(){
            $host = "localhost";
            $user = "root";
            $pass = "";
            $database = "dbname";
            $charset= "utf8";
            try{
                $conn = $conn = "mysql:host=$host;dbname=$database;charset=$charset";
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ];
                $this->pdo = new PDO($conn, $user, $pass, $options);
            } catch (PDOException $e) {
            echo "
                <script>
                alert('Connection Failed');
                window.location.href = 'index.php';
                </script>
            ";
        }
        
        public function insert_item(){
            $insert = "INSERT INTO inventory() VALUES(e)";
            $query = $this->pdo->prepare($insert);
            $result = $query->execute();
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
            $query = $this->pdo->prepare($select);
            $result = $query->execute();
            return $query->fetchAll();

        }

        public function delete_data($ID){
            $delete = "DELETE FROM inventory WHERE ID= :id ";
            $query = $this->pdo->prepare($delete);
            $result = $query->execute([":id"=>$ID]);
            echo "
				<script>
					alert('ITEM DELETED');
				</script>
			";
        }

        public function show_update_data($ID){
            $update = "SELECT * FROM inventory WHERE ID= :id ";
            $query = $this->pdo->prepare($update);
            $result = $query->execute([":id"=>$ID]);
            return $stmt->fetch();
        }

        public function update_data(){
            $update = "UPDATE inventory SET WHERE ID= :id";
            $query = $this->pdo->prepare($update);
            $result = $query->execute();
            echo "
				<script>
					alert('ITEM UPDATED');
					window.location.href = 'show.php';
				</script>
			";
        }

        }
    }
?>