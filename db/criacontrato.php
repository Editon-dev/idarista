<?php
    require_once '../dao/connection.php';

    $detalhe = $_POST['detalhe'];
    $data = $_POST['data'];
    $idpre = $_POST['idpre'];
    $idcon = $_POST['idcon'];
    $status = "Aguardando";

    if(strtotime($data) > strtotime(date('Y-m-d'))){
        try{
            $insere = $conn->prepare("INSERT INTO contratos (
                idcontratante,
                idprestadora,
                detalhe,
                data,
                status
            )
            VALUES(
                :idcontratante,
                :idprestadora,
                :detalhe,
                :data,
                :status
            );");
            $insere->execute(array(
                ':idcontratante' => $idcon,
                ':idprestadora' => $idpre,
                ':detalhe' => $detalhe,
                ':data' => $data,
                ':status' => $status
            ));
            $pass = $insere->rowCount();

            if($pass > 0){
                $atualizacon = $conn->prepare("UPDATE contratantes SET status = 2 WHERE id = ".$idcon.";");
                $atualizacon->execute();
            }
            $conn = null;
        }
        catch(PDOException $e){
            $e->getMessage();
            $conn = null;
        }
    }
    else{
        die("A data do serviço não pode ser menor que a data atual!");
    }

?>