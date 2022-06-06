<?php
    include_once('../dao/connection.php');

    $idcon = $_POST['idcon'];
    $idpre = $_POST['idpre'];
    $idcontrato = $_POST['idcontrato'];

    $pass = 0;
    try{
        $queryContrato = "UPDATE contratos SET status = 'Aceito' WHERE id = ".$idcontrato.";";
        $sqlContrato = $conn->prepare($queryContrato);
        $sqlContrato->execute();

        $pass++;
    }
    catch(Exception $e){
        echo $e->getMessage();
    }

    if($pass == 1){
        try{
            $queryStatus1 = "UPDATE prestadoras SET status = 2 WHERE id = ".$idpre.";";
            $sqlStatus1 = $conn->prepare($queryStatus1);
            $sqlStatus1->execute();
    
            $pass++;
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }

    if($pass == 2){
        try{
            $queryStatus2 = "DELETE FROM contratos WHERE idprestadora = ".$idpre." AND idcontratante = ".$idcon." AND id != ".$idcontrato.";";
            $sqlStatus2 = $conn->prepare($queryStatus2);
            $sqlStatus2->execute();
    
            $pass++;
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }

    if($pass == 3){
        echo 1;
    }
    else{
        echo 'ERRO!';
    }
?>