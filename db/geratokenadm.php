<?php
    include_once('../dao/connection.php');

    try{
        $id = $_POST['id'];
        $tipousuario = $_POST['tipousuario'];
        if($tipousuario == 1){
            $page = 'admdashboard_prestadora.php';
            $table = 'prestadoras';
        }
        if($tipousuario == 2){
            $page = 'admdashboard_contratante.php';
            $table = 'contratantes';
        }

        $upper = implode('', range('A', 'Z'));
        $lower = implode('', range('a', 'z'));
        $nums = implode('', range(0, 9));

        $alphaNumeric = $upper.$lower.$nums;
        $string = '';
        $len = 10;
        for($i = 0; $i < $len; $i++) {
            $string .= $alphaNumeric[rand(0, strlen($alphaNumeric) - 1)];
        }
        $token = strval($string);

        $mudaToken = $conn->prepare("
            UPDATE ".$table." SET token = '".$token."'
            where id = ".$id.";");
        $mudaToken->execute();

        echo $page.'?tk='.$token;
    }
    catch(Exception $e){
        $e->getMessage();
    }

?>