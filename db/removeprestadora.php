<?php
    include_once('../dao/connection.php');

    $id = $_POST['id'];

    try{
        $selectContratantes = $conn->prepare("SELECT idcontratante FROM contratos WHERE idprestadora = ".$id.";");
        $selectContratantes->execute();
        if($selectContratantes->rowCount()>0){
            $idcontratantes = $selectContratantes->fetchALL();
            foreach($idcontratantes as $idcontratante){
                $queryStatus1 = "UPDATE contratantes SET status = 1 WHERE id = ".$idcontratante['idcontratante'].";";
                $sqlStatus1 = $conn->prepare($queryStatus1);
                $sqlStatus1->execute();
            }
        }

        $queryExclui2 = "DELETE FROM contratos WHERE idprestadora = ".$id.";";
        $sqlExclui2 = $conn->prepare($queryExclui2);
        $sqlExclui2->execute();

        $queryExclui = "DELETE FROM prestadoras WHERE id = ".$id.";";
        $sqlExclui = $conn->prepare($queryExclui);
        $sqlExclui->execute();

        echo 1;
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
?>