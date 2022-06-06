<?php
    include_once('../dao/connection.php');

    $token = $_POST['id'];
    $tipo = $_POST['tipo'];

    try{
    $mudaToken = $conn->prepare("
        UPDATE ".$tipo." SET token = NULL
        where token = '".$token."';");
    $mudaToken->execute();
    
    $confereToken = $conn->prepare("
    SELECT * FROM usuarios
    where token = '".$token."';");
    $confereToken->execute();
    if($confereToken->rowCount()>0)
        echo 0;
    else
        echo 1;
    }
    catch(Exception $e){
        echo 0;
    }

?>