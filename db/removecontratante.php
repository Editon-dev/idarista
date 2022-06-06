<?php
    include_once('../dao/connection.php');

    $id = $_POST['id'];

    try{
        $selectprestadoras = $conn->prepare("SELECT idprestadora FROM contratos WHERE idcontratante = ".$id.";");
        $selectprestadoras->execute();
        if($selectprestadoras->rowCount()>0){
            $idprestadoras = $selectprestadoras->fetchALL();
            foreach($idprestadoras as $idprestadora){
                $queryStatus1 = "UPDATE prestadoras SET status = 1 WHERE id = ".$idprestadora['idprestadora'].";";
                $sqlStatus1 = $conn->prepare($queryStatus1);
                $sqlStatus1->execute();
            }
        }

        $queryExclui2 = "DELETE FROM contratos WHERE idcontratante = ".$id.";";
        $sqlExclui2 = $conn->prepare($queryExclui2);
        $sqlExclui2->execute();

        $queryExclui = "DELETE FROM contratantes WHERE id = ".$id.";";
        $sqlExclui = $conn->prepare($queryExclui);
        $sqlExclui->execute();

        echo 1;
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
?>