<?php
    $username = 'admin';
    $pwd = '3t3rn001';
    $host = 'stg-db.c4xhxsxl9nsa.us-east-2.rds.amazonaws.com';
    $db = 'idarista';

    try{
        $conn = new PDO('mysql:host='.$host.';dbname='.$db,$username, $pwd);
        $conn->exec('SET CHARACTER SET utf8');
    }catch(PDOException $e){
        echo 'Error:'. $e->getMessage();
    }
?>
