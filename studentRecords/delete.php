<?php
    include "oop.php";
    $oop = new oop_class();

    if(isset($_GET['id'])){
        $ID = $_GET['id'];

        $oop->delete_data($ID);
    }
?>