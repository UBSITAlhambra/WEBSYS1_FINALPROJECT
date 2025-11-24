<?php
    include "oop.php";
    $oop = new studentVitals();

    if(isset($_GET['id'])){
        $ID = $_GET['id'];

        $oop->delete_data($ID);
    }
?>