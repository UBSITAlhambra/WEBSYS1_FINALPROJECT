<?php
include "oop.php";
$oop = new oop_class();

if (isset($_GET['id'])) {
    $transactionID = $_GET['id'];
    $oop->delete_data($transactionID);
    // Optionally, you can redirect to show.php after deleting
    // header("Location: show.php");
    // exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Transaction</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #e52d27, #b31217);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .message-box {
            background: #fff;
            padding: 36px 38px;
            border-radius: 13px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.17);
            text-align: center;
            animation: fadeIn 0.6s ease-in-out;
        }
        h1 {
            color: #b31217;
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 15px;
        }
        a {
            display: inline-block;
            margin-top: 13px;
            padding: 11px 22px;
            background: #e52d27;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }
        a:hover {
            background: #b31217;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="message-box">
        <h1>Transaction deleted (if ID exists)</h1>
        <a href="show.php">Back to transaction list</a>
    </div>
</body>
</html>
