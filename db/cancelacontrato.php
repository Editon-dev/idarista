<?php
    include_once('../dao/connection.php');

    $idcontrato = $_POST['idcontrato'];
    $idcon = $_POST['idcon'];
    $idpre = $_POST['idpre'];

    $pass = 0;
    try{
        $queryCancela = "DELETE FROM contratos WHERE id = ".$idcontrato.";";
        $sqlCancela = $conn->prepare($queryCancela);
        $sqlCancela->execute();

        $pass++;
    }
    catch(Exception $e){
        echo $e->getMessage();
    }

    if($pass == 1){
        try{
            $queryStatus1 = "UPDATE contratantes SET status = 1 WHERE id = ".$idcon.";";
            $sqlStatus1 = $conn->prepare($queryStatus1);
            $sqlStatus1->execute();
            $queryStatus2 = "UPDATE prestadoras SET status = 1 WHERE id = ".$idpre.";";
            $sqlStatus2 = $conn->prepare($queryStatus2);
            $sqlStatus2->execute();
    
            $pass++;
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }

    if($pass == 2){
        echo 1;
    }
    else{
        echo 'ERRO!';
    }
?>